const http = require('http');
const fs = require('fs');

class FontelloWebpackPlugin {
	constructor (config) {
		this.config = Object.assign({
			src: 'src/icons.json',
			sass: 'src/sass/icons.scss',
			dest: 'dist'
		}, config);

		console.log(this.config);
	}

	apply (compiler) {
		compiler.hooks.compilation.tap('FontelloWebpackPlugin', (compilation, compilationParams) => {
			console.log('Sending request...');

		/*	const request = require('request');
			const fs = require('fs');

			console.log('sending request...');

			request.post({
				url: 'http://fontello.com',
				formData: {config: fs.createReadStream('src/icons.json', 'utf8')}
			}, (err, res, body) => {
				if (err) {
					return console.error(err);
				}

				request.get(`http://fontello.com/${body}/get`, (err2, res2, body2) => {
					console.log(body2);
				});
			}); */
		});
	}
}

/*
	TODO:
	- icons (svg? fontello? icomoon)
	- fix po watch
	- load vue-sass after other sass so it can use other sass...
*/
// Utils
const path = require('path');
const glob = require('glob');

// Plugins
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const VueLoaderPlugin = require('vue-loader/lib/plugin');

// Base config
var config = {
	// In
	entry: {
		app: ['./src/js/app.js'].concat(glob.sync('./languages/*.po'))
	},

	// n out
	output: {
		filename: '[name].js',
		path: path.resolve(__dirname, 'dist')
	},

	// Plug-ins
	plugins: [
		// Clean dist/
		new CleanWebpackPlugin({
			cleanStaleWebpackAssets: false
		}),

		// Fontello
		new FontelloWebpackPlugin({
			src: 'src/icons.json',
			sass: 'src/sass/icons.scss',
			dest: 'dist'
		}),

		// CSS Extractor
		new MiniCssExtractPlugin({
			filename: '[name].css'
		}),

		// Copy assets
		new CopyWebpackPlugin([
			{from: 'src/assets/', to: 'assets/', ignore: ['.DS_Store']}
		]),

		// Handle Vue SFC
		new VueLoaderPlugin()
	],

	// Config
	module: {
		rules: [
			// Vue
			{
				test: /\.vue$/,
				loader: 'vue-loader'
			},

			// PO-files
			{
				test: /\.po$/,
				loader: 'file-loader?name=[name].mo!po2mo-loader'
			},

			// JS
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: [
					// Babel
					{
						loader: 'babel-loader',
						options: {
							presets: ['@babel/preset-env']
						}
					},

					// Glob
					{loader: 'import-glob-loader'}
				]
			},

			// SASS
			{
				test: /\.(s)?css$/,
				exclude: /node_modules/,
				use: [
					// Extract CSS(???)
					{
						loader: MiniCssExtractPlugin.loader,
						options: {
							sourceMap: true
						}
					},

					// Enable importing CSS(???)
					{
						loader: 'css-loader',
						options: {
							sourceMap: true,
							url: false // Don't parse url()
						}
					},

					// PostCSS (autoprefixer etc)
					{
						loader: 'postcss-loader',
						options: {
							plugins: [
								require('autoprefixer'),
								require('postcss-custom-media'),
								require('postcss-custom-selectors')
							],
							sourceMap: true
						}
					},

					// SASS
					{
						loader: 'sass-loader',
						options: {
							sourceMap: true
						}
					},

					// Glob
					{
						loader: 'import-glob-loader',
						options: {
							sourceMap: true
						}
					}
				]
			}
		]
	}
};

// Finish config
module.exports = (env, argv) => {
	// Dev only
	if (argv.mode === 'development') {
		// Watch
		config.watch = true;
		config.watchOptions = {
			ignored: /node_modules/,
			aggregateTimeout: 300,
			poll: 1000
		};

		// Sourcemaps
		config.devtool = 'source-map';
	}

	return config;
};
