// Utils
const path = require('path');
const fs = require('fs');
const request = require('request');
const unzipper = require('unzipper');
const css = require('css');

// Fontello Plugin
class FontelloSassWebpackPlugin {
	constructor (config) {
		this.config = Object.assign({
			src: path.resolve(__dirname, 'src/icons.json'),
			dest: path.resolve(__dirname, 'src/assets/fontello'),
			sass: path.resolve(__dirname, 'src/sass/icons.scss'),
			url: 'https://fontello.com'
		}, config);
	}

	// Converts the fontello.css to what we need
	convertFontelloCss (code) {
		var obj = css.parse(code);
		var newRules = [];
		var sassVars = '';
		var sassMixin = '';

		obj.stylesheet.rules.forEach(rule => {
			const selector = (rule.selectors && rule.selectors.length) ? rule.selectors[0] : null;

			if (selector) {
				// [class] rule
				if (selector.indexOf('[class^="icon-"]:before') !== -1) {
					rule.selectors.push(...['[class^="icon-"]:after', '[class*=" icon-"]:after']);

					rule.declarations.forEach(d => {
						if (d.type === 'declaration') {
							sassMixin += `${d.property}: ${d.value};\n`;
						}
					});

					sassMixin = `@mixin icon ($icon-code: "[NOICO]") {\n${sassMixin}\ncontent: $icon-code;\n}`;
				}
				// Icon rule
				if (selector.indexOf('.icon-') !== -1) {
					const iconName = selector.match(/\.icon-(.*?):before/)[1];
					var iconVal = '[NO-ICON]';

					rule.declarations.forEach(d => {
						if (d.property === 'content') {
							iconVal = d.value;
						}
					});

					newRules.push({
						type: 'rule',
						selectors: [`.icon-${iconName}.icon--after:before`],
						declarations: [{
							type: 'declaration',
							property: 'content',
							value: 'normal'
						}]
					});

					newRules.push({
						type: 'rule',
						selectors: [`.icon-${iconName}.icon--after:after`],
						declarations: rule.declarations
					});

					sassVars += `$icon-${iconName}: ${iconVal};\n`;
				}
			}
		});

		obj.stylesheet.rules.push(...newRules);

		return css.stringify(obj, {compress: false}).replace(/\.\.\/font\//g, 'assets/fontello/') + sassMixin + sassVars;
	}

	apply () {
		const fontelloConfig = fs.createReadStream(this.config.src, 'utf8');

		// Make sure folder exists
		if (!fs.existsSync(this.config.dest)) {
			fs.mkdirSync(this.config.dest, {recursive: true});
		}

		// Fetch session
		request.post({url: this.config.url, formData: {config: fontelloConfig}}, (err, res, body) => {
			if (err) {
				return console.error(err);
			}

			console.log('Successfully fetched ZIP, extracting...');

			// Fetch ZIP
			request.get(`${this.config.url}/${body}/get`)
				// Unzip it
				.pipe(unzipper.Parse())

				// For each file
				.on('entry', (entry) => {
					const basename = path.basename(entry.path);
					const ext = path.extname(basename);

					console.log('Parsing ' + basename);

					// Copy the fontello.css to the sass path
					if (basename === 'fontello.css') {
						entry.pipe(fs.createWriteStream(this.config.sass)).on('finish', () => {
							fs.readFile(this.config.sass, 'utf8', (err, data) => {
								fs.writeFile(this.config.sass, this.convertFontelloCss(data), 'utf8', (err) => {});
							});
						});
					}
					// Copy fonts and config.json to dist
					else if (entry.type === 'File' && (basename === 'config.json' || entry.path.indexOf('/font/') !== -1)) {
						entry.pipe(fs.createWriteStream(this.config.dest + '/' + basename));
					}
					// Otherwise clean up: https://github.com/ZJONSSON/node-unzipper#parse-zip-file-contents
					else {
						entry.autodrain();
					}
				});
		});
	}
}

const fswp = new FontelloSassWebpackPlugin();

fswp.apply();
