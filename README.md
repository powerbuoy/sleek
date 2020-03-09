# [Sleek](https://github.com/powerbuoy/sleek/)

[![Packagist](https://img.shields.io/packagist/vpre/powerbuoy/sleek.svg?style=flat-square)](https://packagist.org/packages/powerbuoy/sleek)
[![GitHub license](https://img.shields.io/github/license/powerbuoy/sleek.svg?style=flat-square)](https://github.com/powerbuoy/sleek/blob/master/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/powerbuoy/sleek.svg?style=flat-square)](https://github.com/powerbuoy/sleek/issues)
[![GitHub forks](https://img.shields.io/github/forks/powerbuoy/sleek.svg?style=flat-square)](https://github.com/powerbuoy/sleek/network)
[![GitHub stars](https://img.shields.io/github/stars/powerbuoy/sleek.svg?style=flat-square)](https://github.com/powerbuoy/sleek/stargazers)

The WordPress Theme for Developers.

## Getting Started

### Installation

The easiest way to install Sleek is by using [`wp cli`](https://wp-cli.org/). Assuming you already have WordPress downloaded and installed, simply run:

```shell
# Move to project folder
$ cd /path/to/my/wordpress-site/

# Install Sleek
$ wp theme install https://github.com/powerbuoy/sleek/archive/master.zip

# Move to Sleek folder
$ cd wp-content/themes/sleek/

# Install PHP dependencies
$ composer install

# Install front-end dependencies
$ npm install

# Build assets
$ npm run build

# Activate Sleek:
$ wp theme activate sleek
```

### Development

During development run:

```shell
$ npm run dev
```

This watches for changes and builds non minified assets with sourcemaps.

To build for production run:

```shell
$ npm run build
```

This does _not_ watch, minifies and does not include any sourcemaps.

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

## Sleek Packages

Sleek is made up of several composer packages that provide different functionality.

---

### [Sleek ACF](https://github.com/powerbuoy/sleek-acf/)

[![Packagist](https://img.shields.io/packagist/vpre/powerbuoy/sleek-acf.svg?style=flat-square)](https://packagist.org/packages/powerbuoy/sleek-acf)
[![GitHub license](https://img.shields.io/github/license/powerbuoy/sleek-acf.svg?style=flat-square)](https://github.com/powerbuoy/sleek-acf/blob/master/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/powerbuoy/sleek-acf.svg?style=flat-square)](https://github.com/powerbuoy/sleek-acf/issues)
[![GitHub forks](https://img.shields.io/github/forks/powerbuoy/sleek-acf.svg?style=flat-square)](https://github.com/powerbuoy/sleek-acf/network)
[![GitHub stars](https://img.shields.io/github/stars/powerbuoy/sleek-acf.svg?style=flat-square)](https://github.com/powerbuoy/sleek-acf/stargazers)

Improves ACF in a number of ways like nicer flexible content titles, collapsed flexible content layouts, better looking relationship field and more.

#### Theme Support

##### `sleek/acf/hide_admin`

Enable to hide the ACF admin.

##### `sleek/acf/fields/redirect_url`

Enable the redirect_url field.

#### Hooks

N/A

#### Functions

##### `Sleek\Acf\generate_keys($fields, $prefix)`

Generate a `key` property next to every `name` property in `$fields`. The `key` will be in the form of `{$prefix}_{$name}`.

#### Classes

N/A

---

### [Sleek Archive Filter](https://github.com/powerbuoy/sleek-archive-filter/)

[![Packagist](https://img.shields.io/packagist/vpre/powerbuoy/sleek-archive-filter.svg?style=flat-square)](https://packagist.org/packages/powerbuoy/sleek-archive-filter)
[![GitHub license](https://img.shields.io/github/license/powerbuoy/sleek-archive-filter.svg?style=flat-square)](https://github.com/powerbuoy/sleek-archive-filter/blob/master/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/powerbuoy/sleek-archive-filter.svg?style=flat-square)](https://github.com/powerbuoy/sleek-archive-filter/issues)
[![GitHub forks](https://img.shields.io/github/forks/powerbuoy/sleek-archive-filter.svg?style=flat-square)](https://github.com/powerbuoy/sleek-archive-filter/network)
[![GitHub stars](https://img.shields.io/github/stars/powerbuoy/sleek-archive-filter.svg?style=flat-square)](https://github.com/powerbuoy/sleek-archive-filter/stargazers)

Adds the ability to filter posts in an archive using GET params:

- `?sleek_filter_tax_{taxonomy_name}[]={term_id}`  
	Show only posts belonging to `{term_id}` in `{taxonomy_name}`.
- `?sleek_filter_meta_min_{meta_field_name}[]={value}`  
	Show only posts whose (numeric) `{meta_field_name}` is a minimum of `{value}`.
- `?sleek_filter_meta_max_{meta_field_name}[]={value}`  
	Show only posts whose (numeric) `{meta_field_name}` is a maximum of `{value}`.
- `?sleek_filter_meta_{meta_field_name}[]={value}`  
	Show only posts whose `{meta_field_name}` is exactly `{value}`.

#### Theme Support

##### `sleek/archive_filter`

Enable the above.

#### Hooks

N/A

#### Functions

N/A

#### Classes

N/A

---

### [Sleek Archive Meta](https://github.com/powerbuoy/sleek-archive-meta/)

[![Packagist](https://img.shields.io/packagist/vpre/powerbuoy/sleek-archive-meta.svg?style=flat-square)](https://packagist.org/packages/powerbuoy/sleek-archive-meta)
[![GitHub license](https://img.shields.io/github/license/powerbuoy/sleek-archive-meta.svg?style=flat-square)](https://github.com/powerbuoy/sleek-archive-meta/blob/master/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/powerbuoy/sleek-archive-meta.svg?style=flat-square)](https://github.com/powerbuoy/sleek-archive-meta/issues)
[![GitHub forks](https://img.shields.io/github/forks/powerbuoy/sleek-archive-meta.svg?style=flat-square)](https://github.com/powerbuoy/sleek-archive-meta/network)
[![GitHub stars](https://img.shields.io/github/stars/powerbuoy/sleek-archive-meta.svg?style=flat-square)](https://github.com/powerbuoy/sleek-archive-meta/stargazers)

Hooks into the `the_archive_title()` and `the_archive_description()` functions to provide better search results texts, remove prefixes and more.

Also adds a new `Sleek\ArchiveMeta\the_archive_image()` (which, without ACF, only works for the user archive (using the avatar)).

If used together with `Sleek\PostTypes`' settings pages `the_archive_image()` returns the image used on the settings page.

#### Theme Support

N/A

#### Hooks

N/A

#### Functions

##### `Sleek\ArchiveMeta\get_the_archive_image($size)`

Returns potential archive images as `<img>`.

##### `Sleek\ArchiveMeta\get_the_archive_image_url(size)`

Returns potential archive image URL.

##### `Sleek\ArchiveMeta\the_archive_image(size)`

Renders potential archive image.

##### `Sleek\ArchiveMeta\the_archive_image_url(size)`

Renders potential archive image URL.

#### Classes

N/A

---

### [Sleek Cleanup](https://github.com/powerbuoy/sleek-cleanup/)

[![Packagist](https://img.shields.io/packagist/vpre/powerbuoy/sleek-cleanup.svg?style=flat-square)](https://packagist.org/packages/powerbuoy/sleek-cleanup)
[![GitHub license](https://img.shields.io/github/license/powerbuoy/sleek-cleanup.svg?style=flat-square)](https://github.com/powerbuoy/sleek-cleanup/blob/master/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/powerbuoy/sleek-cleanup.svg?style=flat-square)](https://github.com/powerbuoy/sleek-cleanup/issues)
[![GitHub forks](https://img.shields.io/github/forks/powerbuoy/sleek-cleanup.svg?style=flat-square)](https://github.com/powerbuoy/sleek-cleanup/network)
[![GitHub stars](https://img.shields.io/github/stars/powerbuoy/sleek-cleanup.svg?style=flat-square)](https://github.com/powerbuoy/sleek-cleanup/stargazers)

Cleans up a bunch of unnecessary WordPress stuff like inline emoji code, gallery markup and more.

#### Theme Support

##### `sleek/cleanup/disable_comments`

Completely disable comments on the entire site.

##### `sleek/cleanup/comment_form_placeholders`

Add placeholders to comment form fields.

#### Hooks

N/A

#### Functions

N/A

#### Classes

N/A

---

### [Sleek Core](https://github.com/powerbuoy/sleek-core/)

[![Packagist](https://img.shields.io/packagist/vpre/powerbuoy/sleek-core.svg?style=flat-square)](https://packagist.org/packages/powerbuoy/sleek-core)
[![GitHub license](https://img.shields.io/github/license/powerbuoy/sleek-core.svg?style=flat-square)](https://github.com/powerbuoy/sleek-core/blob/master/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/powerbuoy/sleek-core.svg?style=flat-square)](https://github.com/powerbuoy/sleek-core/issues)
[![GitHub forks](https://img.shields.io/github/forks/powerbuoy/sleek-core.svg?style=flat-square)](https://github.com/powerbuoy/sleek-core/network)
[![GitHub stars](https://img.shields.io/github/stars/powerbuoy/sleek-core.svg?style=flat-square)](https://github.com/powerbuoy/sleek-core/stargazers)

Adds a bunch of theme support, includes translation files, enqueues scripts etc etc.

#### Theme Support

##### `sleek/disable_jquery`

Disable jQuery on the front end (not inside admin). Note that this may break some plug-ins.

##### `sleek/jquery_cdn`

Include jQuery from a CDN (code.jquery.com).

##### `sleek/get_terms_post_type_arg`

Adds support for a `post_type` argument to `get_terms` so it only returns terms associated with that post-type.

##### `sleek/disable_theme_editor`

Disables the theme editor.

##### `sleek/classic_editor`

Disables Gutenberg and enables the classic editor everywhere.

##### `sleek/nice_email_from`

Changes the default email and name when using `wp_mail()` to use the site name and admin email instead of "WordPress".

##### `sleek/disable_404_guessing`

Disables WordPress' insane guessing when it hits a 404: https://core.trac.wordpress.org/ticket/16557

#### Hooks

##### `sleek/jquery_version`

Return a jQuery version like "3.4.1" to change it.

##### `sleek/meta_viewport`

Set a custom meta_viewport instead of the default `width=device-width, initial-scale=1.0`.

#### Functions

N/A

#### Classes

N/A

---

### [Sleek Custom Logo](https://github.com/powerbuoy/sleek-custom-logo/)

[![Packagist](https://img.shields.io/packagist/vpre/powerbuoy/sleek-custom-logo.svg?style=flat-square)](https://packagist.org/packages/powerbuoy/sleek-custom-logo)
[![GitHub license](https://img.shields.io/github/license/powerbuoy/sleek-custom-logo.svg?style=flat-square)](https://github.com/powerbuoy/sleek-custom-logo/blob/master/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/powerbuoy/sleek-custom-logo.svg?style=flat-square)](https://github.com/powerbuoy/sleek-custom-logo/issues)
[![GitHub forks](https://img.shields.io/github/forks/powerbuoy/sleek-custom-logo.svg?style=flat-square)](https://github.com/powerbuoy/sleek-custom-logo/network)
[![GitHub stars](https://img.shields.io/github/stars/powerbuoy/sleek-custom-logo.svg?style=flat-square)](https://github.com/powerbuoy/sleek-custom-logo/stargazers)

Hooks into `the_custom_logo()` and renders one of:

1) A custom logo selected in the admin
2) An SVG logo found in `dist/assets/site-logo.svg`
3) A PNG logo found in `dist/assets/site-logo.png`
4) Just outputs the site name

Also makes it possible to pass an array of arguments to `get_custom_logo()`; `the_custom_logo(['inline_svg' => true, 'append' => '-small'])` would instead render `dist/assets/site-logo-small.svg` as an inline SVG.

Finally it also changes the link class name from `custom-logo-link` to `site-logo`.

#### Theme Support

N/A

#### Hooks

N/A

#### Functions

##### `the_custom_logo($args)`

This is the native WordPress `the_custom_logo()` but we add the `$args` argument which enables you to specify `inline_svg` (`true`/`false`) and `append` (`String` to append to `site-logo` filename).

#### Classes

N/A

---

### [Sleek Gallery](https://github.com/powerbuoy/sleek-gallery/)

[![Packagist](https://img.shields.io/packagist/vpre/powerbuoy/sleek-gallery.svg?style=flat-square)](https://packagist.org/packages/powerbuoy/sleek-gallery)
[![GitHub license](https://img.shields.io/github/license/powerbuoy/sleek-gallery.svg?style=flat-square)](https://github.com/powerbuoy/sleek-gallery/blob/master/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/powerbuoy/sleek-gallery.svg?style=flat-square)](https://github.com/powerbuoy/sleek-gallery/issues)
[![GitHub forks](https://img.shields.io/github/forks/powerbuoy/sleek-gallery.svg?style=flat-square)](https://github.com/powerbuoy/sleek-gallery/network)
[![GitHub stars](https://img.shields.io/github/stars/powerbuoy/sleek-gallery.svg?style=flat-square)](https://github.com/powerbuoy/sleek-gallery/stargazers)

Improves media and gallery related output like the default gallery markup, wraps captioned images in figure/figcaption, removes gallery CSS and more.

#### Theme Support

##### `sleek/oembed/youtube` and `sleek/oembed/vimeo`

Wraps YouTube and/or Vimeo embeds in a figure with thumbnail and caption, also uses their respective APIs so that clicking the thumbnail plays or pauses the video.

##### `sleek/gallery/slideshow`

Create slideshows instead of galleries. The number of columns selected for the gallery will be the number of slides per page. Requires SleekUI.

#### Hooks

N/A

#### Functions

N/A

#### Classes

N/A

---

### [Sleek Google Maps](https://github.com/powerbuoy/sleek-google-maps/)

[![Packagist](https://img.shields.io/packagist/vpre/powerbuoy/sleek-google-maps.svg?style=flat-square)](https://packagist.org/packages/powerbuoy/sleek-google-maps)
[![GitHub license](https://img.shields.io/github/license/powerbuoy/sleek-google-maps.svg?style=flat-square)](https://github.com/powerbuoy/sleek-google-maps/blob/master/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/powerbuoy/sleek-google-maps.svg?style=flat-square)](https://github.com/powerbuoy/sleek-google-maps/issues)
[![GitHub forks](https://img.shields.io/github/forks/powerbuoy/sleek-google-maps.svg?style=flat-square)](https://github.com/powerbuoy/sleek-google-maps/network)
[![GitHub stars](https://img.shields.io/github/stars/powerbuoy/sleek-google-maps.svg?style=flat-square)](https://github.com/powerbuoy/sleek-google-maps/stargazers)

Adds a "Google Maps API Key" setting to the admin which, if not empty, adds the Google Maps API to the page with a `googleMapsInit` callback. Also sends the Google Maps Key to ACF so that ACF maps work.

Also adds a SLEEK_GOOGLE_MAPS_API_KEY JavaScript variable to the page.

#### Theme Support

N/A

#### Hooks

N/A

#### Functions

N/A

#### Classes

N/A

---

### [Sleek Google Search](https://github.com/powerbuoy/sleek-google-search/)

[![Packagist](https://img.shields.io/packagist/vpre/powerbuoy/sleek-google-search.svg?style=flat-square)](https://packagist.org/packages/powerbuoy/sleek-google-search)
[![GitHub license](https://img.shields.io/github/license/powerbuoy/sleek-google-search.svg?style=flat-square)](https://github.com/powerbuoy/sleek-google-search/blob/master/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/powerbuoy/sleek-google-search.svg?style=flat-square)](https://github.com/powerbuoy/sleek-google-search/issues)
[![GitHub forks](https://img.shields.io/github/forks/powerbuoy/sleek-google-search.svg?style=flat-square)](https://github.com/powerbuoy/sleek-google-search/network)
[![GitHub stars](https://img.shields.io/github/stars/powerbuoy/sleek-google-search.svg?style=flat-square)](https://github.com/powerbuoy/sleek-google-search/stargazers)

Under construction

![](https://media3.giphy.com/media/xKvwa3SjldeWQ/giphy.gif?cid=790b761170db4b5f3f6d323078b1396ceb15bb304fdaaf59&rid=giphy.gif)

---

### [Sleek Image Sizes](https://github.com/powerbuoy/sleek-image-sizes/)

[![Packagist](https://img.shields.io/packagist/vpre/powerbuoy/sleek-image-sizes.svg?style=flat-square)](https://packagist.org/packages/powerbuoy/sleek-image-sizes)
[![GitHub license](https://img.shields.io/github/license/powerbuoy/sleek-image-sizes.svg?style=flat-square)](https://github.com/powerbuoy/sleek-image-sizes/blob/master/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/powerbuoy/sleek-image-sizes.svg?style=flat-square)](https://github.com/powerbuoy/sleek-image-sizes/issues)
[![GitHub forks](https://img.shields.io/github/forks/powerbuoy/sleek-image-sizes.svg?style=flat-square)](https://github.com/powerbuoy/sleek-image-sizes/network)
[![GitHub stars](https://img.shields.io/github/stars/powerbuoy/sleek-image-sizes.svg?style=flat-square)](https://github.com/powerbuoy/sleek-image-sizes/stargazers)

Utility functions for registering WordPress image sizes.

#### Theme support

N/A

#### Hooks

N/A

#### Functions

##### `Sleek\ImageSizes\register($width, $height, $crop, $additionalSizes)`

Overrides WordPress' built-in thumbnail sizes (thumbnail, medium, medium_large and large) using the dimensions passed to the function, e.g: `Sleek\ImageSizes\register(1920, 1080, ['center', 'center']);` where large will be `1920x1080`, `medium_large` will be 75% of that size, `medium` 50% and `thumbnail` 25%.

Also accepts a fourth argument, `$additionalSizes`, which allows you to register more sizes under different names;

```
Sleek\ImageSizes\register(1920, 1080, ['center', 'center'], [
	'portrait' => ['width' => 1080, 'height' => 1920, 'crop' => ['center', 'top']],
	'square' => ['width' => 1920, 'height' => 1920],
]);
```

Each additional size will be registered as `{$name}_large`, `{$name}_medium_large` (75%), `{$name}_medium` (50%) and `{$name}_thumbnail` (25%)

##### `Sleek\ImageSizes\get_image_sizes($width, $height)`

Helper function for `register()`.

#### Classes

N/A

---

### [Sleek Login](https://github.com/powerbuoy/sleek-login/)

[![Packagist](https://img.shields.io/packagist/vpre/powerbuoy/sleek-login.svg?style=flat-square)](https://packagist.org/packages/powerbuoy/sleek-login)
[![GitHub license](https://img.shields.io/github/license/powerbuoy/sleek-login.svg?style=flat-square)](https://github.com/powerbuoy/sleek-login/blob/master/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/powerbuoy/sleek-login.svg?style=flat-square)](https://github.com/powerbuoy/sleek-login/issues)
[![GitHub forks](https://img.shields.io/github/forks/powerbuoy/sleek-login.svg?style=flat-square)](https://github.com/powerbuoy/sleek-login/network)
[![GitHub stars](https://img.shields.io/github/stars/powerbuoy/sleek-login.svg?style=flat-square)](https://github.com/powerbuoy/sleek-login/stargazers)

Improves the login screen and hides admin bar from subscribers, also redirects them to the home page upon login.

#### Theme Support

##### `sleek/login/styling`

Override the default WordPress styling of the login page and use the theme styling instead.

##### `sleek/login/require_login`

Require login on the entire site (intranet).

#### Hooks

N/A

#### Functions

N/A

#### Classes

N/A

---

### [Sleek Menu](https://github.com/powerbuoy/sleek-menu/)

[![Packagist](https://img.shields.io/packagist/vpre/powerbuoy/sleek-menu.svg?style=flat-square)](https://packagist.org/packages/powerbuoy/sleek-menu)
[![GitHub license](https://img.shields.io/github/license/powerbuoy/sleek-menu.svg?style=flat-square)](https://github.com/powerbuoy/sleek-menu/blob/master/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/powerbuoy/sleek-menu.svg?style=flat-square)](https://github.com/powerbuoy/sleek-menu/issues)
[![GitHub forks](https://img.shields.io/github/forks/powerbuoy/sleek-menu.svg?style=flat-square)](https://github.com/powerbuoy/sleek-menu/network)
[![GitHub stars](https://img.shields.io/github/stars/powerbuoy/sleek-menu.svg?style=flat-square)](https://github.com/powerbuoy/sleek-menu/stargazers)

Cleans up the menu HTML by removing IDs and redundant classes. Also fixes active-classes on post type and taxonomy archives.

#### Theme Support

N/A

#### Hooks

N/A

#### Functions

N/A

#### Classes

N/A

---

### [Sleek Modules](https://github.com/powerbuoy/sleek-modules/)

[![Packagist](https://img.shields.io/packagist/vpre/powerbuoy/sleek-modules.svg?style=flat-square)](https://packagist.org/packages/powerbuoy/sleek-modules)
[![GitHub license](https://img.shields.io/github/license/powerbuoy/sleek-modules.svg?style=flat-square)](https://github.com/powerbuoy/sleek-modules/blob/master/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/powerbuoy/sleek-modules.svg?style=flat-square)](https://github.com/powerbuoy/sleek-modules/issues)
[![GitHub forks](https://img.shields.io/github/forks/powerbuoy/sleek-modules.svg?style=flat-square)](https://github.com/powerbuoy/sleek-modules/network)
[![GitHub stars](https://img.shields.io/github/stars/powerbuoy/sleek-modules.svg?style=flat-square)](https://github.com/powerbuoy/sleek-modules/stargazers)

Create modules by creating classes in `/modules/`.

#### Theme Support

N/A

#### Hooks

##### `sleek/modules/fields`

Filter the ACF fields for modules before they're added. This allows you to add "global" fields to several modules at once.

##### `sleek/modules/get_dummy_field/?type=?&name=?&module=?`

Filter dummy data used by `render_dummies()`.

#### Functions

##### `Sleek\Modules\has_module($module, $area, $id)`

Check whether `$module` exists in `$area` at (optional) location `$id` (defaults to `get_the_ID()`).

##### `Sleek\Modules\render($module, $fields, $template)`

Render module `$module` using (optional) fields `$fields` (or ACF location like a term, options page or set to `null` to fetch fields from `get_the_ID()`) using (optional) template `$template`.

##### `Sleek\Modules\render_flexible($where, $id)`

Render flexible modules contained in flexible content area `$where` using (optional) `$id` as ACF location.

##### `Sleek\Modules\get_module_fields(array $modules, $layout, $withTemplates)`

Fetch ACF fields for all `$modules` and use layout `$layout` (`tabs`, `accordion`, `normal` or `flexible`). Optionally give every module group a `Template` dropdown using `$withTemplates = true`.

##### `Sleek\Modules\get_module_templates($module)`

Return all templates for `$module`.

##### `Sleek\Modules\render_dummies(array $modules)`

Render all `$modules` using dummy data.

#### Classes

##### `Sleek\Modules\Module`

Extend this class to create a module.

###### `Module::init()`

This method is called once on every page load. It allows you to add hooks or do whatever you like related to your module. Note that it runs whether or not the module is used on the current page.

###### `Module::fields()`

Return an array of ACF fields from here and they will be added to the module.

###### `Module::data()`

Return an array from here and each array property will be available in the module template.

###### `Module::get_field($name)`

Return the value of any field returned from `fields()`. Useful inside `data()` to check module configuration.

---

### [Sleek Notices](https://github.com/powerbuoy/sleek-notices/)

[![Packagist](https://img.shields.io/packagist/vpre/powerbuoy/sleek-notices.svg?style=flat-square)](https://packagist.org/packages/powerbuoy/sleek-notices)
[![GitHub license](https://img.shields.io/github/license/powerbuoy/sleek-notices.svg?style=flat-square)](https://github.com/powerbuoy/sleek-notices/blob/master/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/powerbuoy/sleek-notices.svg?style=flat-square)](https://github.com/powerbuoy/sleek-notices/issues)
[![GitHub forks](https://img.shields.io/github/forks/powerbuoy/sleek-notices.svg?style=flat-square)](https://github.com/powerbuoy/sleek-notices/network)
[![GitHub stars](https://img.shields.io/github/stars/powerbuoy/sleek-notices.svg?style=flat-square)](https://github.com/powerbuoy/sleek-notices/stargazers)

Adds settings to Settings -> Sleek to display various notices on the site.

#### Theme Support

##### `sleek/notices/cookie_consent`

Add a "Cookie Consent" message to the site. Also adds a textarea to Settings -> Sleek to customize the message.

##### `sleek/notices/outdated_browser_warning`

Add an "Outdated Browser" warning to the site. Also adds a textarea to Settings -> Sleek to customize the warning.

#### Hooks

##### `sleek/notices/cookie_consent`

Filter the cookie consent message. Only runs if no message has been entered in the admin settings.

##### `sleek/notices/outdated_browser_warning`

Filter the browser warning. Only runs if no warning has been entered in the admin settings.

#### Functions

N/A

#### Classes

N/A

---

### [Sleek Post Types](https://github.com/powerbuoy/sleek-post-types/)

[![Packagist](https://img.shields.io/packagist/vpre/powerbuoy/sleek-post-types.svg?style=flat-square)](https://packagist.org/packages/powerbuoy/sleek-post-types)
[![GitHub license](https://img.shields.io/github/license/powerbuoy/sleek-post-types.svg?style=flat-square)](https://github.com/powerbuoy/sleek-post-types/blob/master/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/powerbuoy/sleek-post-types.svg?style=flat-square)](https://github.com/powerbuoy/sleek-post-types/issues)
[![GitHub forks](https://img.shields.io/github/forks/powerbuoy/sleek-post-types.svg?style=flat-square)](https://github.com/powerbuoy/sleek-post-types/network)
[![GitHub stars](https://img.shields.io/github/stars/powerbuoy/sleek-post-types.svg?style=flat-square)](https://github.com/powerbuoy/sleek-post-types/stargazers)

Create post types by creating classes in `/post-types/`.

#### Theme Support

N/A

#### Hooks

##### `sleek/post_types/fields`

Filter the ACF fields for post types before they're added.

##### `sleek/post_types/archive_fields`

Filter the ACF fields for the archive settings before they're added.

#### Functions

##### `Sleek\PostTypes\get_file_meta()`

Return information about all files in `/post-types/` (internal use).

#### Classes

##### `Sleek\PostTypes\PostType`

Extend this class to create a post type.

###### `PostType::init()`

This method is called once on every page load. It allows you to add hooks or do whatever you like related to your post type.

###### `PostType::config()`

Return an array of post type configuration here. The array is passed directly to [register_post_type](https://developer.wordpress.org/reference/functions/register_post_type/). A few additional properties are available:

**`taxonomies`**

This is a native WordPress property but unlike when calling `register_post_type()` any taxonomy set in here will be automatically created if it doesn't already exist.

**`has_single`**

Set this to false to disable single pages for the post type.

**`hide_from_search`**

Hides the post type from search without the [side effects](https://core.trac.wordpress.org/ticket/20234) of the built-in `exclude_from_search`.

**`has_settings`**

Set this to false to _not_ add a "Settings" page for the post type.

**`has_archive`**

If this is false the settings page will be empty, if not it will have a "Title", "Image" and "Description".

###### `PostType::fields()`

Return an array of ACF fields from here and they will be added to the post type.

###### `PostType::sticky_modules()`

Return an array of module names and they will be added to the post type. Render a sticky module using `Sleek\Modules\render('name-of-module')`.

###### `PostType::flexible_modules()`

Return an array of module names and they will be available in a flexible content field named `flexible_modules`. An associative array can be used to create multiple flexible content fields;

```
[
	'left_column' => ['text-block', 'text-blocks'],
	'right_column' => ['related-posts', 'recent-comments']
]
```

Render a flexible module field using `Sleek\Modules\render_flexible('flexible_modules')` or `Sleek\Modules\render_flexible('left_column')` etc.

###### `PostType::sticky_archive_modules()`

Return an array of module names and they will be added to the post type's settings page. Render a sticky module using `Sleek\Modules\render('name-of-module', 'mycpt_settings')`.

###### `PostType::flexible_archive_modules()`

Return an array of module names and they will be available in a flexible content field named `flexible_modules` on the post type's settings page. An associative array can be used here too.

Render modules on the settings page using `Sleek\Modules\render_flexible('flexible_modules', 'mycpt_settings')`.

---

### [Sleek Settings](https://github.com/powerbuoy/sleek-settings/)

[![Packagist](https://img.shields.io/packagist/vpre/powerbuoy/sleek-settings.svg?style=flat-square)](https://packagist.org/packages/powerbuoy/sleek-settings)
[![GitHub license](https://img.shields.io/github/license/powerbuoy/sleek-settings.svg?style=flat-square)](https://github.com/powerbuoy/sleek-settings/blob/master/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/powerbuoy/sleek-settings.svg?style=flat-square)](https://github.com/powerbuoy/sleek-settings/issues)
[![GitHub forks](https://img.shields.io/github/forks/powerbuoy/sleek-settings.svg?style=flat-square)](https://github.com/powerbuoy/sleek-settings/network)
[![GitHub stars](https://img.shields.io/github/stars/powerbuoy/sleek-settings.svg?style=flat-square)](https://github.com/powerbuoy/sleek-settings/stargazers)

Adds an options page to the admin (Settings -> Sleek) with two fields: `head_code` and `foot_code` which allows you to add arbitrary HTML to `<head>` and just before `</body>`. Also provides a simple API to add more settings fields to the options page.

#### Theme Support

N/A

#### Hooks

N/A

#### Functions

##### `Sleek\Settings\add_setting($name, $type, $label)`

Add a new settings field to the options page.

##### `Sleek\Settings\get_setting($name)`

Get value of setting.

#### Classes

N/A

---

### [Sleek TinyMCE](https://github.com/powerbuoy/sleek-tinymce/)

[![Packagist](https://img.shields.io/packagist/vpre/powerbuoy/sleek-tinymce.svg?style=flat-square)](https://packagist.org/packages/powerbuoy/sleek-tinymce)
[![GitHub license](https://img.shields.io/github/license/powerbuoy/sleek-tinymce.svg?style=flat-square)](https://github.com/powerbuoy/sleek-tinymce/blob/master/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/powerbuoy/sleek-tinymce.svg?style=flat-square)](https://github.com/powerbuoy/sleek-tinymce/issues)
[![GitHub forks](https://img.shields.io/github/forks/powerbuoy/sleek-tinymce.svg?style=flat-square)](https://github.com/powerbuoy/sleek-tinymce/network)
[![GitHub stars](https://img.shields.io/github/stars/powerbuoy/sleek-tinymce.svg?style=flat-square)](https://github.com/powerbuoy/sleek-tinymce/stargazers)

Improves the TinyMCE editor.

#### Theme Support

##### `sleek/tinymce/disable_colors`

Disables the ability to change text color.

##### `sleek/tinymce/clean_paste`

Cleans up HTML that is copy/pasted by removing unwanted HTML elements and attributes.

#### Hooks

##### `sleek/tinymce/clean_paste_disallowed_elements`

Filter the list of HTML elements which are _not_ allowed to be pasted.

##### `sleek/tinymce/formats`

Add or remove elements added to the "Format" menu in the WYSIWYG editor. By default "Button" and "Button (ghost)" are added.

#### Functions

N/A

#### Classes

N/A

---

### [Sleek Utils](https://github.com/powerbuoy/sleek-utils/)

[![Packagist](https://img.shields.io/packagist/vpre/powerbuoy/sleek-utils.svg?style=flat-square)](https://packagist.org/packages/powerbuoy/sleek-utils)
[![GitHub license](https://img.shields.io/github/license/powerbuoy/sleek-utils.svg?style=flat-square)](https://github.com/powerbuoy/sleek-utils/blob/master/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/powerbuoy/sleek-utils.svg?style=flat-square)](https://github.com/powerbuoy/sleek-utils/issues)
[![GitHub forks](https://img.shields.io/github/forks/powerbuoy/sleek-utils.svg?style=flat-square)](https://github.com/powerbuoy/sleek-utils/network)
[![GitHub stars](https://img.shields.io/github/stars/powerbuoy/sleek-utils.svg?style=flat-square)](https://github.com/powerbuoy/sleek-utils/stargazers)

Utility functions used internally by Sleek. Please [check the code](https://github.com/powerbuoy/sleek-utils/blob/master/sleek-utils.php) for documentation.
