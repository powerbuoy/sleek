SleekWP Documentation
=====================

SleekWP is really just a normal WordPress theme, so if you're familiar with theme development much of this will be famimliar. However, in order to best take advantage of SleekWP's features you should read this short documentation.

## Getting Started

You'll first need to download and install [WordPress](//wordpress.org), when that's done you can download [SleekWP](//github.com/powerbuoy/SleekWP/archive/master.zip) and as a blueprint for your own theme it's recommended you also download [SleekChild](//github.com/powerbuoy/SleekChild/archive/master.zip).

SleekChild only consists of a couple of files, but they're a perfect starting point for building your own site. After you've downloaded it, place it with the other themes and rename the folder your site or theme name.

Once you have SleekWP and SleekChild in your `wp-content/themes/` directory you can set your theme as the active one and have a look at the home page.

**It is recommended you name the SleekWP theme directory "sleek". Some of the example code, and the `Template` comment in SleekChild rely on it being called "sleek".**

We're going to go through each part of SleekWP. From WP-fixes and cleanup to CSS, JS and HTML. We'll start with the functions file.

**SleekWP is still very much in development so things change - a lot.**

## The `functions.php` file

The function file may look overwhelming at first, but it's mostly a bunch of `add_action()` calls that tell SleekWP to do stuff at certain points.

There are comments above each block of code in the included config so it should hopefully be pretty self explanatory, but I'll go through the basics.

**You may want to keep the `functions.php` file open while reading this.**

### Some (optional) configuration

The first thing you'll see are some configuration CONSTANTS. If you don't want to use ReCaptcha, Google Analytics or whatever is set here just ignore them, if you _do_ want to use them, just set them here and SleekWP takes care of the rest.

<script src="http://gist-it.appspot.com/github/powerbuoy/SleekChild/blob/master/functions.php?slice=0:8"></script>

### Thumbnail sizes & sidebars

Next we add the thumbnail sizes we need. SleekWP already adds theme support for thumbnails as well as a default size, so we just need to set the sizes specific to our theme: `add_action('init', 'sleek_child_post_thumbnails');`.

<script src="http://gist-it.appspot.com/github/powerbuoy/SleekChild/blob/master/functions.php?slice=9:19"></script>

After that we register sidebars, and if you'll be using those just uncomment the `add_action()` call and add/remove the sidebars you want in the `sleek_register_sidebars()` call. The array key is the sidebar slug and the array value is the nice name of the sidebar. You may wanna make it translatable with `__()`.

Note: `sleek_register_sidebars()` is just a wrapper around WP's `register_sidebar()`, you can see exactly what it does in [`sleek/inc/helpers/register-sidebars.php`](https://github.com/powerbuoy/SleekWP/blob/master/inc/helpers/register-sidebars.php).

<script src="http://gist-it.appspot.com/github/powerbuoy/SleekChild/blob/master/functions.php?slice=19:35"></script>

### Cusomt post types & taxonomies

Registering custom post types in WP isn't particularly hard, but SleekWP makes it slightly even less hard :P

<script src="http://gist-it.appspot.com/github/powerbuoy/SleekChild/blob/master/functions.php?slice=36:52"></script>

As you can see we use `sleek_register_post_types()` to register post types and `sleek_register_taxonomies()` for taxonomies. For post types simply pass in an associative array with `slug' => 'Description'` and taxonomies `'slug' => array('post', 'types')`. Both accept a translation textdomain as their second argument (for translating URLs).

### Register CSS & JS

Then we register our CSS and JS file. This is done exactly the same way with or without SleekPHP:

<script src="http://gist-it.appspot.com/github/powerbuoy/SleekChild/blob/master/functions.php?slice=53:73"></script>

**Prefix all functions `the_name_of_your_theme_` instead of `sleek_child_`.**

The files in dist/ will be generated from our gulpfile. We'll get to that later. If you need google web fonts you'll see a couple of commented lines of code for that too.

### Shortcodes

SleekWP also comes with a couple of shortcodes. One in particular which can be quite useful; `[include]`. It allows you to include any module from either your theme or SleekWP into any page.

It's recommended that you do this in the actual templates instead, but sometimes it can come in handy to include an about-box or ad in the middle of an article.

<script src="http://gist-it.appspot.com/github/powerbuoy/SleekChild/blob/master/functions.php?slice=74:91"></script>

### Cleanup & fixes

The rest of the code in `functions.php` is mostly minor stuff like cleaning up `<head>` from junk or giving pages excerpts. Again, it's all commented so it should hopefully be pretty straight forward. There are plenty of useful fixes in there so you may want to read through the comments.

Like most of SleekWP the things you're not interested in can be left commented, and the things you are interested in just enable. All the code related to your theme's `functions.php` can be found in sleek/inc/.

<script src="http://gist-it.appspot.com/github/powerbuoy/SleekChild/blob/master/functions.php?slice=92:"></script>







































## The page templates

Now that we got the backend configuration out of the way, let's start thinking about what the page will look like.

As a theme developer you know that WordPress uses the `.php` files found directly in your theme directory as the templates for your website. There's pretty much one template for each type of URL, like `search.php` for `/?s=`, `single.php` for `/blog/a-post/`, `archive.php` for `/blog/2015/` and so on.

On most WordPress themes, if you open one of these files, you'll find all the PHP and HTML for that entire page right there in that one file. This is where SleekWP does things a little differently.

If you have a look at a random "page template" in SleekWP you'll notice it's rather empty;

<script src="http://gist-it.appspot.com/github/powerbuoy/SleekWP/blob/master/author.php"></script>

None of the actual meat of the code is present here, and the reason for that is that we want to keep it modular. Both PostsIntro and Posts are used on several other pages, so being able to include them like this is much easier than copy/pasting the code or creating functions similar to `get_header()` or `get_footer()`.

You'll notice every template directly in the theme directory looks like this. Header, perhaps a couple of wrapping elements for styling purposes (I get by pretty well on just `main` and `aside` usually) and a footer. Clean and simple. Opening up one of these templates should give you a bird's eye view of the page in question and you should be able to easily add, remove or move around modules as you please.

## The modules that make up the pages

Unlike what you might be used to, there was hardly any HTML or PHP in the WP page templates. Instead we put all the individual module's code in their own files inside `modules/` so they can be easily shared and moved around across any number of sites.

SleekWP contains modules for all of WordPress' built in pages like archives, author listings, image attachment pages etc. The SleekWP modules are written to be as clean and semantically correct as possible. They all have a unique ID (corresponding to their filename) so that you can target them with CSS or JS specifically.

To show you what I mean, here's the code for displaying a single Post. Or, the PostModule:

<script src="http://gist-it.appspot.com/github/powerbuoy/SleekWP/blob/master/modules/post.php"></script>

As you can see, a unique #id same as the filename and semantic HTML5 with no design related classes or other clutter. For the modules you don't really care about in your theme this is very nice to have as you automatically get a nice and clean 404, search page or any other built in WordPress page.

And for the pages you _do_ care about and want to change the look of, simply create a file in your own theme with the same name as the SleekWP file and it shall be used instead. On this site, for example, I override `modules/header.php` because I wanted the tagline in an `<h2>` instead of a `<p>`. That's pretty much the only change I needed to make with this site though (not counting CSS of course).

Just remember, the templates in the root of your theme are for structuring what goes where on a certain page. The templates in the `modules/` directory are the ones that actually contain code and can be shared across pages and even different websites.

## The design

SleekWP uses NPM for front-end dependencies and Gulp for building your CSS, JavaScript, icons etc. In order to use Gulp (you should! it's lovely) you need to [install NPM](https://docs.npmjs.com/getting-started/installing-node) and then run `npm install` in both `themes/sleek/` and `themes/your-theme-name/`. After that's done you can run `gulp` in your theme folder. This will generate one file for CSS and one for JS (the ones included in `wp_enqueue_scripts/styles` earlier). It will also generate an icon font based on `icons.json` (you can import this file on [fontello.com](http://fontello.com/)).

The CSS and JS is very much up to you, but for gulp to work you need to put your SASS in `src/sass/` (and include it all from `all.scss`) and your JS in `src/js/`. We use [Browserify](http://browserify.org/) to merge all JS, so to use jQuery, or a jQuery plugin, or any other NPM module from your JS, you should use a template like:

	(function () {
		'use strict';

		var $ = require('jquery');

		console.log('jQuery is now available in $:');
		console.dir($);

		// require('slick-carousel');
		// $('.slideshow').slick();
	})();

## Yeoman (BETA)

If you're feeling adventurous you can [check out the SleekWP Yeoman Generator](https://github.com/powerbuoy/SleekWPGenerator), `npm link` it locally, and then run `yo sleekwp` and it will do _a lot_ of this stuff (and more!) for you. Please note though that this is a generator I'm using for work, and a lot of the things in there (like the Bitbucket and WPEngine related stuff) might not be for everyone. You may wanna open the `index.js` file up and comment out some of the tasks (in particular `initGIT()`) before running it.

## That's it

That should be it. Use the comments if you have questions.
