SleekWP Documentation
=====================

SleekWP is really just a normal WordPress theme, so if you're familiar with theme development much of this will be easy. However, in order to best take advantage of SleekWP's features you should read this short documentation.

## Getting Started

You'll obviously first need to download and install [WordPress](//wordpress.org), when that's done you can download [SleekWP](//github.com/powerbuoy/SleekWP/master.zip) and as a blueprint for your own theme it's recommended you also download [SleekChild](//github.com/powerbuoy/SleekChild/master.zip).

SleekChild only consists of a couple of files, but they're a perfect starting point for building your own site. After you've downloaded it, place it with the other themes and rename the folder your site or theme name.

Once you have SleekWP and SleekChild in your `wp-content/themes/` directory you can set your theme as the active one and have a look at the home page.

**In order for your theme to take advantage of SleekWP you need to set the `Template:`-comment in `style.css` to the name of the SleekWP directory. It should already be set to `sleek` but if you named the folder differently remember to also change the `Template:`-comment.**

As you can see there's some basic styling in place. Don't worry! they're just placeholder. The CSS is all yours. If you don't want to use anything of SleekWP's CSS you don't have to. That said, it does come with plenty of useful SASS @mixins and other smart code.

We're going to go through each part of SleekWP. From WP-fixes and cleanup to CSS, JS and HTML. We'll start with the functions file.

**SleekWP is still very much in development so things change - a lot.**

## The `functions.php` file

The function file may look overwhelming at first, but it's mostly a bunch of `add_action()` calls that tell SleekWP to do stuff at certain points.

There are comments above each block of code in the included config so it should hopefully be pretty self explanatory, but I'll go through the basics.

**You may want to keep the `functions.php` file open while reading this.**

### Register CSS & JS

First thing we do is register our CSS and JS file. This is done exactly the same way with or without SleekPHP:

<script src="http://gist-it.appspot.com/github/powerbuoy/SleekChild/blob/master/functions.php?slice=0:25"></script>

**Prefix all functions `the_name_of_your_theme_` instead of `sleek_child_`.**

Business as usual here, except you may notice we're including a `php` file when registering our JavaScript, what's this sorcery you might ask, and we'll get to that later in the JavaScript section.

### Thumbnail sizes & sidebars 

Next we add the thumbnail sizes we need. SleekWP already adds theme support for thumbnails as well as a default size, so we just need to set the sizes specific to our theme: `add_action('init', 'sleek_child_post_thumbnails');`.

After you can register sidebars, and if you'll be using those just uncomment the `add_action()` call and add/remove the sidebars you want in the `sleek_register_sidebars()` call. The array key is the sidebar slug and the array value is the nice name of the sidebar. You may wanna make it translatable with `__()`.

<script src="http://gist-it.appspot.com/github/powerbuoy/SleekChild/blob/master/functions.php?slice=26:44"></script>

### Cusomt post types & taxonomies

I use custom post types and taxonomies in more or less every theme I create nowadays. Be it for testimnials, portfolio items, company employees or whatever.

Registering them in WP isn't particularly hard, but SleekWP makes it slightly even less hard :P

<script src="http://gist-it.appspot.com/github/powerbuoy/SleekChild/blob/master/functions.php?slice=45:63"></script>

As you can see we use `sleek_register_post_types()` to register both post types and taxonomies. The function takes three arguments;

1. An array of post types and descriptions in the form of `'movies' => 'My movie collection'`.
2. An array of taxonomies and which post types they should belong to in the form of `'taxonomy_name => array('post_type_one', 'post_type_two')`
3. An optional textdomain. The function sets the post type slugs to "url_[post-type-name]", and once you're live you most likely don't want that so by passing in a textdomain here you can later translate "url_movies" to just "movies" or perhaps "films" for the UK version of the site.

### Shortcodes

SleekWP also come with a couple of shortcodes. One in particular which can be quite useful; `[include]`. It allows you to include any module from either your theme or SleekWP into any page.

It's recommended that you do this in the actual templates instead, but sometimes it can come in handy to include an about-box or ad in the middle of an article.

<script src="http://gist-it.appspot.com/github/powerbuoy/SleekChild/blob/master/functions.php?slice=64:77"></script>

### Cleanup & fixes

The rest of the code in `functions.php` is mostly minor stuff like cleaning up `<head>` from junk or giving pages excerpts. Again, it's all commented so it should hopefully be pretty straight forward.

Like most of SleekWP the things you're not interested in can be left commented, and the things you are interested in just enable. All the code related to your theme's `functions.php` can be found in sleek/inc/.

## The page templates

Now that we got the backend configuration out of the way, let's start thinking about what the page will look like.

As a theme developer you know that WordPress uses the `.php` files found directly in your theme directory as the templates for your website. There's pretty much one template for each type of URL, like `search.php` for `/?s=`, `single.php` for `/blog/a-post/`, `archive.php` for `/blog/2015/` and so on.

On most WordPress themes, if you open one of these files, you'll find all the PHP and HTML for that entire page right there in that one file. This is where SleekWP does things a little differently.

If you have a look at a random "page template" in SleekWP you'll notice it's rather empty;

	<?php get_header() ?>

	<main>

		<?php sleek_get_module('posts-intro') ?>
		<?php sleek_get_module('post-author') ?>
		<?php sleek_get_module('posts') ?>

	</main>

	<?php if is_active_sidebar('aside') : ?>
		<aside id="aside">

			<?php dynamic_sidebar('aside') ?>

		</aside>
	<?php endif ?>

	<?php get_footer() ?>

None of the actual meat of the code is present here, and the reason for that is that we want to keep it modular. Both PostsIntro and Posts are used on several other pages, so being able to include them like this is much easier than copy/pasting the code or creating functions similar to `get_header()` or `get_footer()`.

You'll notice every template directly in the theme directory looks like this. Header, perhaps a couple of wrapping elements for styling purposes (I get by pretty well on just `main` and `aside` usually) and a footer. Clean and simple. Opening up one of these templates should give you a birds eye view of the page in question and you should be able to easily add, remove or move around modules as you please.

You'll notice yet another `sleek_` function; `sleek_get_module()`. This is a simple wrapper for a normal `include` that **first checks the child theme** before falling back to SleekWP. This way you can easily override modules from your child.

## The modules that make up the pages

Unlike what you might be used to, there was hardly any HTML or PHP in the WP page templates. No, instead we put all the individual module's code in their own files inside `modules/` so they can be easily shared and moved around across any number of sites.

SleekWP contains modules for all of WordPress' built in pages like archives, author listings, image attachment pages etc. The SleekWP modules are written to be as clean and semantically correct as possible. They all have a unique ID (corresponding to their filename) so that you can target the with CSS or JS specifically.

To show you what I mean, here's the code for displaying a single Post. Or, the PostModule:

	<section id="post">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<header>

				<?php the_post_thumbnail('sleek-medium') ?>

				<h1><?php the_title() ?></h1>

				<?php sleek_get_module('partials/post-pubdate') ?>

			</header>

			<?php the_content() ?>

			<footer>

				<?php wp_link_pages(array('before' => '<p>' . __('Pages', 'sleek') . ': ', 'after' => '</p>', 'next_or_number' => 'number')) ?>
				<?php sleek_get_module('partials/post-meta') ?>

			</footer>
		<?php endwhile; else : ?>
			<?php sleek_get_module('partials/nothing-found') ?>
		<?php endif ?>

	</section>

	<nav id="pagination">
		<?php previous_post_link('%link', '%title') ?>
		<?php next_post_link('%link', '%title') ?>
	</nav>

As you can see, a unique #id same as the filename and semantic HTML5 with no design related classes or other clutter. For the modules you don't really care about in your theme this is very nice to have as you automatically get a nice and clean 404, search page or any other built in WordPress page.

And for the pages you _do_ care about and want to change the look of, simply create a file in your own theme with the same name as the SleekWP file and it shall be used instead. On this site, for example, I override `modules/header.php` because I wanted the tagline in an `<h2>` instead of a `<p>`. That's pretty much the only change I needed to make with this site though (not counting CSS of course).

Just remember, the templates in the root of your theme are for structuring what goes where on a certain page. The templates in the `modules/` directory are the ones that actually contain code and can be shared across pages and even different websites.

## The design

Ok, config done, page templates done(? we'll probably come back to them during the design phase), now let's get some design on.

SleekWP encourages the use of SASS. In fact, if you don't want to use SASS you can't really use any of SleekWP's built in CSS so you can skip this entire chapter. If you _do_ use SASS (and you should!), then keep reading.

If you look inside your `css/` directory you'll see 4 files:

1. all.css - the generated CSS, this is what's served to the browser
2. all.scss - the file used to generate all.css, this file @import:s all other css be it from SleekWP or from your own theme
3. config.scss - configuration variables for more or less every aspect of SleekWP's base styling
4. layout.scss - example of how you can design your own theme

### all.scss - or: @import all the things!

Here's what all.scss looks like:

	// Config
	@import "../../sleek/css/default-config";
	@import "config";

	// Sleek stuff
	@import "../../sleek/css/font-awesome/all";
	@import "../../sleek/css/all-utils";
	// @import "../../sleek/css/all-plugins";
	@import "../../sleek/css/all-general";

	// Our layout
	@import "layout";

Now let me explain that. `default-config` contains every config variable used by SleekWP's built in @mixins and generic CSS styling. You should always start by including it, and then override the configs that are relevant to you from your own config file; `config`.

Next we include the nice starter CSS SleekWP offers. First of all FontAwesome and related classes and @mixins, then a bunch of handy utilities (in the form of @mixins - they don't actually add any CSS unless you use them), plugins (which are basically CSS/JS combinations like ImageZoom or CodeHighlight) and finally general.

Out of all those files only general will actually make a difference to the page as it's the only one that actually outputs any CSS that directly affects things. The general CSS consists of Normalize, WP-Classes, Forms and General. You should be familiar with Normalize, but it's a much better way to reset your CSS than traditional CSS resets. WP-Classes just contains styling for the align-classes WP adds to images. Forms contains some basic form styling and finally General contains styling on single element selector level.

That sounded well high tech, but what I mean is it contains styling for things like `a {}` or `p {}` etc. Nothing specific, only generic. And more or less everything can be changed using the...

### config.scss - or: change all the things!

Open up the config and you should be able to understand what to do immediately. Everything is commented and config variables have sensible names (and defaults). Here's what (parts of it) looks like:

	// Animations and effects
	$transition-speed: .1s;
	$transition-easing: ease-out;
	$border-radius: 5px;

	// Colors
	$link-color: #777;
	$link-color-hover: #333;
	$link-color-visited: #609;

	$error-color: #c00;
	$success-color: #0c0;
	$white-color: #fefefe;
	$gray-color: #999;

A couple of things that may need further explaining; the `$bp-`-configs are for @media query breakpoints. The `$site-width` and `$max-site-width` are used in various @mixins (like @section) and they should most likely be set in % for site-width and px/em for max-site-width.

Margin & gutter are used for vertical and horizontal spacing respectively. I find I like to have more space between items horizontally than vertically but your mileage may vary.

Animation speeds, typography and colors should hopefully be self explanatory.

**It's important that when you start developing your own design that you too use these configs so that later on, if you want to change something, changing it in the config file will change both SleekWP's mixins and general styling as well as your own CSS.**

To know more about the mixins or classes I recommend checking the code in SleekWP/css/. You can also check the [projects section](//andreaslagerkvist.com/projects/) on my website as I tend to put some of the stuff there.

## The JavaScript

modules / running plugins from header

SleekWP comes with a few handy JavaScript/jQuery plug-ins and code snippets and in order for your child theme to take advantage of them it needs to include the `js/head.php` and `js/foot.php` files.

Those PHP scripts take care of merging and compressing your theme's JS as well as SleekWP's into one file each; `foot.js` and `head.js`. If you don't need any JavaScript in the `<head>` just comment out including `js/head.php`. You can of course include any other JS you like as usual.

For your JavaScript files to be included in the generated file you need to prefix them with either `foot-` or `head-` depending on where you want them included, for example; `foot-plugin-image-zoom.js`. The files are included in order of filename so you may want to include a number for it to be higher up in the generated code; `foot-1-plugin-image-zoom.js`.

It is recommended that you add your own JS code to SleekWP's `App` object in order to keep everything nice and namespaced. When you want to add JavaScript code that affects a certain part of the page (i.e. `#recent-comments`) you add a JS object to `App.modules`;

	App.modules.RecentComments = {
		// this function will run IF your module (#recent-comments in this case) exists
		init: function (mod) {
			// mod is the element connected to this code (#recent-comments)
		}
	};

Code added this way will only run if the corresponding element (`#recent-comments` in this case) exists on the page. Should you add a module dynamically you can always run the code manually; `App.modules.RecentComments.init()`.

**It's important you name your module object exactly the same* as the ID of the element the code is connected to so that SleekWP knows which element to look for**

If you for example have added an AddThis widget (`<div id="add-this"></div>`) and you want to attach some 

## That's it

...
