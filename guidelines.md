# Code Guidelines

Sleek uses Google's guidelines: https://google.github.io/styleguide/htmlcssguide.html

## With these exceptions:

### Indentation

https://google.github.io/styleguide/htmlcssguide.html#Indentation

Indent with one tab. Never spaces. Never mix.

### TODOs

https://google.github.io/styleguide/htmlcssguide.html#Action_Items

It's not entirely necessary to provide an author with every TODO comment. _Do_ use TODO comments however.

### Optional tags

https://google.github.io/styleguide/htmlcssguide.html#Optional_Tags

Close all elements that need closing. In other words, _do not_ (**ever**) omit optional tags.

### CSS declaration order

https://google.github.io/styleguide/htmlcssguide.html#Declaration_Order

Instead of alphabetical order, group related properties;

```sass
#my-module {
	position: absolute;
	left: 0;
	top: 0;
	z-index: 99;

	margin: 0;
	padding: 1rem 2rem;

	border: 1px solid #ccc;
	border-radius: .25rem;
}
```

## And these additions:

### Whitespace

Let your code breathe. If an HTML element has margin and padding by default, give it some margin and padding in the code;

**Bad**

```html
<section id="my-module">
	<h2>A heading</h2>
	<p>Followed by a
		<strong>paragraph</strong></p>
	<ul><li>And a</li><li>List</li></ul>
</section>
```

**Good**

```html
<section id="my-module">

	<h2>A heading</h2>

	<p>Followed by a <strong>paragraph</strong>.</p>

	<ul>
		<li>And a</li>
		<li>List</li>
	</ul>

</section>
```

### ID vs Class

Use `#id`:s for unique styling where you only want to affect one single module and nothing outside it. This is useful for super unique styling that has no use outside your module.

**Bad**

```sass
// An error message's styling should probably be shared (use a class instead)
#error-message {
	color: red;
	border: 1px solid red;
}
```

**Good**

```sass
// The site header is unique on the page, and no other element shares its styling
#site-header {
	background: blue;
	padding: 1rem;
}
```

Use `.class`es for generic styling that should be re-used by many different modules. Keep in mind that every time you create a class you take that name and namespace forever and no-one else can use it from then on. Be smart with your classes and consider how useful they are for other modules/the site as a whole before claiming that namespace.

Also pick a namespace for your class and add modifiers to it.

**Bad**

```sass
// Too generic
.image {
	float: right;
	margin: 0 -2rem 2rem 2rem;
	box-shadow: 0 0 .5rem rgba(0, 0, 0, .25);
}
```

**Good**

```sass
// Better to split up this styling
.image--aside {
	float: right;
	margin: 0 -2rem 2rem 2rem;
}

// In two
.image--shadow {
	box-shadow: 0 0 .5rem rgba(0, 0, 0, .25);
}
```

If you need a `.class` purely for selecting an element inside your unique module styling, prefix it with your module name and keep it _inside_ your module ID namespace;

```sass
#site-header {
	background: blue;

	// This class is only used to select the login button inside the site header
	.site-header__login-button {
		float: right;
	}
}
```

In other words, `.classes` are used for generic components that can be shared and used by many different modules.

`#ids` are used for completely unique styling that isn't useful anywhere else.

Put generic components (`.classes`) inside `sass/components/`, put unique module styling (`#ids`) inside `sass/modules/`. Always name the file your module or component name (ie `modules/site-header.scss` or `components/image.scss` (do not create a file for every `image--modifier`, only one file for the entire `image` namespace)).

Components should ideally have documentation. Following this template will add your component to the generated styleguide: (example: http://bibblan.wpengine.com/wp-content/themes/bibblan/dist/styleguide.html)

```sass
/***
    title: Button
    section: Buttons
    description: Use to create buttons. Buttons come in various sizes and colors. Add more colors and customize your buttons in config/button.scss. You can also use @include button;
    example:
        <p><a href="#" class="button">I'm a normal button</a></p>
        <p><button class="button--ghost">Button elements don't need the button class</button></p>
        <p><input type="submit" value="Submit inputs do though" class="button button--disabled" disabled></p>
        <p><button class="button--wide button--white">Full width!</button></p>
        <p><a href="#" class="button">Continue</a> <a href="#" class="button button--gray button--ghost">Cancel</a></p>
        <p><a href="#" class="button button--small">Small button</a></p>
        <p><a href="#" class="button button--large">Large button</a></p>
***/
```

Please note that while tab should always be used, the styleguide generator chokes on tabs so in these particular comments spaces are needed.

### Filenames

Just like HTML and CSS, use dash-separation for filenames. Always name the file the same thing as the module or component it contains.

### PHP

When writing template PHP (PHP mixed with HTML) use the alterantive syntax for control structures (http://php.net/manual/en/control-structures.alternative-syntax.php) and keep your PHP short, ideally one statement per opening and closing PHP tag. Never `echo` HTML code. HTML should be the default code inside a template. Omit closing `;` when not needed (ideally they should never be needed as there's only one statement per PHP block).

**Bad**

```php
<?php if ($someCondition) {
	echo '<section id="my-module">';
	the_title('<h2>', '</h2>');
	?>
	<ul>
		<?php foreach (get_field('call-to-actions') as $cta) {
			echo '<li>' . $cta . '</li>';
		} ?>
	</ul>
	<?php
	echo '</section>';
} ?>
```

**Good**

```php
<?php if ($someCondition) : ?>
	<section id="my-module">

		<h2><?php the_title() ?></h2>

		<?php the_content() ?>

		<ul>
			<?php foreach (get_field('call-to-actions') as $cta) : ?>
				<li><?php echo $cta ?></li>
			<?php endforeach ?>
		</ul>

	</section>
<?php endif ?>
```

When writing large chunks of PHP always use the standard PHP syntax;

```php
<?php
class MyCoolClass {
	public function __constructor ($name) {
		if ($name) {
			$this->name = $name;
		}
		else {
			$this->name = 'Unnamed';
		}
	}
}
```
