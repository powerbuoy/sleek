/*
	TODO:
	- sourcemaps in dev
	- style-loader in dev
	- watch
	- files??
	- glob-import in sass and js (main should auto-import every other file in js/ and main.scss can do @import "components/*")
	- icons (svg? fontello?)
	- gettext
*/
const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
	// In
	entry: './src/js/main.js',

	// n Out
	output: {
		filename: '[name].js',
		path: path.resolve(__dirname, 'dist')
	},

	// Plug-ins
	plugins: [
		// CSS Extractor
		new MiniCssExtractPlugin({
			filename: '[name].css'
		})
	],

	// Config
	module: {
		rules: [
			// JS
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: ['@babel/preset-env']
					}
				}
			},

			// SASS
			{
				test: /\.scss$/,
				exclude: /node_modules/,
				use: [
					// Extract CSS from main.js and create main.css
					{
						loader: MiniCssExtractPlugin.loader
					},
					// Enable importing CSS
					{
						loader: 'css-loader'
					},
					// PostCSS (autoprefixer etc)
					{
						loader: 'postcss-loader',
						options: {
							plugins: [
								require('autoprefixer')
							]
						}
					},
					// SASS
					{
						loader: 'sass-loader'
					}
				]
			}
		]
	}
};
