// Utils
const path = require('path');
const glob = require('glob');

// Plugins
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const VueLoaderPlugin = require('vue-loader/lib/plugin');
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const TerserPlugin = require("terser-webpack-plugin");

// Base config
var config = {
	// In
	entry: {
		app: ['./src/js/app.js', './src/sass/app.scss'].concat(glob.sync('./lang/**/*.po'))
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

	// Externals (NOTE: Deprecate)
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
				use: [
					{
						loader: 'file-loader',
						options: {
							name: '[path][name].mo'
						}
					},
					'po2mo-loader'
				]
			},

			// JS
			{
				test: /\.js$/,
				exclude: /node_modules\/(?!sleek\-ui)/, // NOTE: We need to run babel in sleek-ui...
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
						loader: MiniCssExtractPlugin.loader
					},

					// Enable importing CSS(???)
					{
						loader: 'css-loader',
						options: {
							url: false // Don't parse url()
						}
					},

					// PostCSS (autoprefixer etc)
					{
						loader: 'postcss-loader',
						options: {
							postcssOptions: {
								plugins: [
									require('autoprefixer'),
									require('postcss-custom-media'),
									require('postcss-custom-selectors'),
									require('css-has-pseudo/postcss'),
									require('postcss-inset')(),
									require('postcss-clamp')(),
									require('postcss-font-display')([
										{
											display: 'swap',
											replace: false
										},
										{
											test: 'fontello',
											display: 'block',
											replace: false
										}
									])
								]
							}
						}
					},

					// SASS
					{
						loader: 'sass-loader',
						options: {
							sassOptions: {
								outputStyle: 'expanded'
							}
						}
					},

					// Glob
					{
						loader: 'import-glob-loader'
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

		// Watch
		config.watch = true;
		config.watchOptions = {
			ignored: /node_modules/,
			aggregateTimeout: 300
		};
	}

	// Minimizers
	config.optimization = {
		minimizer: [
			new TerserPlugin(),
			new CssMinimizerPlugin({
				minimizerOptions: {
					preset: [
						'default',
						{
							// NOTE: Don't merge longhand
							// https://github.com/cssnano/cssnano/issues/675
							mergeLonghand: false,

							// NOTE: Don't optimize calc()
							calc: false
						}
					]
				}
			})
		]
	};

	return config;
};
