# Sleek

[![Packagist](https://img.shields.io/packagist/vpre/powerbuoy/sleek.svg?style=flat-square)](https://packagist.org/packages/powerbuoy/sleek)
[![GitHub license](https://img.shields.io/github/license/powerbuoy/sleek.svg?style=flat-square)](https://github.com/powerbuoy/sleek/blob/master/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/powerbuoy/sleek.svg?style=flat-square)](https://github.com/powerbuoy/sleek/issues)
[![GitHub forks](https://img.shields.io/github/forks/powerbuoy/sleek.svg?style=flat-square)](https://github.com/powerbuoy/sleek/network)
[![GitHub stars](https://img.shields.io/github/stars/powerbuoy/sleek.svg?style=flat-square)](https://github.com/powerbuoy/sleek/stargazers)

The WordPress Theme for Developers.

## Getting Started

### Installation

wp cli

#### Install Dependencies

composer install
npm install

## Folder Structure

```shell
themes/sleek/             # → Sleek root
├── languages/            # → Translations
│   └── sv_SE.po          # → Swedish translation of Sleek (add more po files as needed)
├── modules/              # → Modules
│   ├── */                # → A folder indicates a module with both a class and one or more templates
│   └── *.php             # → A single file module, template only
├── post-types/           # → Post Types
│   └── *.php             # → Each file represents a post type
├── src/                  # → Front-end code and assets
│   ├── assets/           # → Fonts, images, icons etc
│   ├── js/               # → JavaScript
│   │   └── app.js        # → JS entry point, should import all other JS
│   ├── sass/             # → SASS
│       └── app.scss      # → SASS entry point, should import all other SASS
├── dist/                 # → Webpack bundled app.js and app.css as well as assets (don't touch, don't commit)
├── vendor/               # → PHP dependencies installed by composer (don't touch, don't commit)
├── node_modules/         # → Front-end dependencies installed by NPM (don't touch, don't commit)
├── .gitignore            # → Files and folders to ignore during git commits
├── .prodignore           # → Files and folders to ignore during sleek-deploy
├── composer.json         # → Specify PHP dependencies here using composer (related: composer.lock)
├── package.json          # → Specify front-end dependencies here using NPM (related: package-lock.json)
├── webpack.config.js     # → Webpack build script
├── fontello.js           # → Builds fontello icons
├── style.css             # → WordPress Theme config (don't touch)
├── editor-style.css      # → CSS to add to WP admin WYSIWYG
└── *.php                 # → WordPress templates: https://developer.wordpress.org/themes/basics/template-files/
```
