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
		new CleanWebpackPlugin(),

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
