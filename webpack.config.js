// Utils
const path = require('path');
const glob = require('glob');

// Plugins
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const VueLoaderPlugin = require('vue-loader/lib/plugin');
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');

// Base config
var config = {
	// In
	entry: {
		app: ['./src/js/app.js', './src/sass/app.scss'].concat(glob.sync('./languages/*.po'))
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

		// CSS Extractor
		new MiniCssExtractPlugin({
			filename: '[name].css'
		}),

		// Copy assets
		new CopyWebpackPlugin({
			patterns: [
				{from: 'src/assets/', to: 'assets/', globOptions: {ignore: ['.DS_Store']}}
			]
		}),

		// Handle Vue SFC
		new VueLoaderPlugin()
	],

	// Externals
	externals: {
		jquery: 'jQuery'
	},

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
				exclude: /node_modules\/(?!sleek\-ui)/,
				use: [
					// Babel
					{
						loader: 'babel-loader',
						options: {
							presets: ['@babel/preset-env']
						}
					},

					// Glob
					{
						loader: 'import-glob-loader'
					}
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
								require('postcss-custom-selectors'),
								require('css-has-pseudo/postcss')
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
		// Sourcemaps
		config.devtool = 'source-map';
	}
	// Prod
	else {
		// NOTE: Don't merge longhand
		// https://github.com/cssnano/cssnano/issues/675
		config.plugins.push(new OptimizeCssAssetsPlugin({
			cssProcessorPluginOptions: {
				preset: [
					'default', {
						mergeLonghand: false,
						calc: false
					}
				]
			}
		}));
	}

	// Watch
	if (argv.watch) {
		config.watch = true;
		config.watchOptions = {
			ignored: /node_modules/,
			aggregateTimeout: 300
		};
	}

	return config;
};
