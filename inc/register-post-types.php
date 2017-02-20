<?php
/**
 * Register custom post types
 *
 * Pass in an array of custom post type slugs. You can optionally override the default
 * configuration by passing in a multi-dimensional array; array('my_post_type' => ['my-config' => 'my-value'])
 */
function sleek_register_post_types ($postTypes, $textdomain = 'sleek') {
	foreach ($postTypes as $postType => $data) {
		# If no data was supplied - a one-dimensional array is assumed
		if (!is_array($data)) {
			$postType = $data;
		}

		# Create the post type slug - if a textdomain is specified make it translatable, otherwise make it dash-separated
		$slug = $textdomain ? __('url_' . $postType, $textdomain) : str_replace('_', '-', $postType);

		# Create the post type nice-name based on the the post type slug
		$name = __(ucfirst(str_replace('_', ' ', $postType)), $textdomain);

		# Create the config
		$config = [
			'labels' => [
				'name' => $name,
				'singular_label' => $name
			],
			'rewrite' => [
				'with_front' => false,
				'slug' => $slug
			],
			'exclude_from_search' => false, # Never exclude from search because it prevents taxonomy archives for this post type (https://core.trac.wordpress.org/ticket/20234)
			'has_archive' => true,
			'public' => true,
			'supports' => [
				'title', 'editor', 'author', 'thumbnail', 'excerpt',
				'wpcom-markdown', 'trackbacks', 'custom-fields',
				'revisions', 'page-attributes', 'comments'
			]
		];

		# If a config array was specified
		if (is_array($data)) {
			$config = array_merge($config, $data);
		}

		register_post_type($postType, $config);
	}
}

# Instead of exclude_from_search we can use this to specifically tell WP which CPTs to include in search
function sleek_set_cpt_in_search ($pts = [], $override = false) {
	$postTypes = array_merge(['post', 'page'], $pts);

	if ($override) {
		$postTypes = $pts;
	}

	add_filter('pre_get_posts', function ($query) use ($postTypes) {
		if ($query->is_search() and !$query->is_admin() and $query->is_main_query() and !isset($_GET['post_type'])) {
			$query->set('post_type', $postTypes);
		}

		return $query;
	});
}

# Registers CPT meta data such as title, description and image (for use in archive pages)
function sleek_register_post_type_meta_data ($postTypes, $extraFields = []) {
	add_action('admin_head', function () {
		?>
		<style>
			div.sleek-cpt-meta-data form {
				padding-top: 10px;
			}

			div.sleek-cpt-meta-data div.form-field {
				overflow: hidden;
				margin: 0 0 2rem;
			}

			div.sleek-cpt-meta-data div.form-field img {
				display: block;
				margin-bottom: 1rem;
				max-width: 160px;
			}

			div.sleek-cpt-meta-data hr {
				margin: 2rem 0;
			}

			/* Copied from WPs normal title field... */
			div.sleek-cpt-meta-data div.form-field.title input {
				background-color: #fff;
				width: 100%;
				padding: 3px 8px;
				font-size: 1.7em;
				line-height: 100%;
				height: 1.7em;
				outline: 0;
			}
		</style>
		<?php
	});

	foreach ($postTypes as $postType => $data) {
		# If no data was supplied - a one-dimensional array is assumed
		# TODO: This isn't even in use???
		if (!is_array($data)) {
			$postType = $data;
		}

		# Add the admin menu
		add_submenu_page(
			# Parent slug
			'edit.php?post_type=' . $postType,

			# Page title
			__('Archive Title & Description', 'sleek'),

			# Menu title
			__('Archive Title & Description', 'sleek'),

			# Capability needed
			'manage_options',

			# Page slug
			'edit-' . $postType . '-meta',

			# The function that adds the settings screen
			function () use ($postType, $extraFields) {
				$uploadURL = get_upload_iframe_src('image', null);
				$imgID = get_option($postType . '_image');
				$imgSrc = wp_get_attachment_image_src($imgID, 'thumbnail');
				$hasImg = is_array($imgSrc);
				?>
				<div class="wrap sleek-cpt-meta-data">

					<h1><?php _e('Archive Title & Description', 'sleek') ?></h1>

					<p><?php _e('Enter a title, description and image here and it will be used on the archive page for this post type.', 'sleek') ?></p>

					<form method="post" action="options.php">

						<div class="form-field title">
							<label>
								<?php _e('Title', 'sleek') ?>
								<input type="text"
									name="<?php echo $postType ?>_title"
									value="<?php echo stripslashes(get_option($postType . '_title')) ?>"
									placeholder="<?php _e('Title', 'sleek') ?>">
							</label>
						</div>

						<?php foreach ($extraFields as $field => $type) : $title = ucfirst(str_replace('_', ' ', $field)) ?>
							<div class="form-field title">
								<label>
									<?php _e($title, 'sleek') ?>
									<input type="text"
										name="<?php echo $postType ?>_<?php echo $field ?>"
										value="<?php echo stripslashes(get_option($postType . '_' . $field)) ?>"
										placeholder="<?php _e($title, 'sleek') ?>">
								</label>
							</div>
						<?php endforeach ?>

						<div class="form-field">
							<?php _e('Background Image', 'sleek') ?>

							<?php if ($hasImg) : ?>
								<img id="<?php echo $postType ?>-image" src="<?php echo $imgSrc[0] ?>">
							<?php else : ?>
								<img id="<?php echo $postType ?>-image">
							<?php endif ?>

							<button class="button <?php if ($hasImg) : ?>hidden<?php endif ?>" id="<?php echo $postType ?>-add-image">
								<?php _e('Choose image', 'sleek') ?>
							</button>
							<button class="button <?php if (!$hasImg) : ?>hidden<?php endif ?>" id="<?php echo $postType ?>-remove-image">
								<?php _e('Remove image', 'sleek') ?>
							</button>

							<input id="<?php echo $postType ?>-image-id" name="<?php echo $postType ?>_image" type="hidden" value="<?php echo esc_attr($imgID); ?>">
						</div>

						<hr>

						<?php wp_editor(
							stripslashes(get_option($postType . '_description')),
							$postType . '_settings',
							[
								'textarea_name' => $postType . '_description',
								# 'media_buttons' => false # This makes the other image uploader not work
							]
						) ?>

						<?php settings_fields($postType . '_settings') ?>
						<?php submit_button() ?>

					</form>

				</div>
				<?php
			}
		);

		# Add upload scripts
		add_action('admin_head', function () use ($postType) {
			?>
			<script>
				jQuery(function ($) {
					var frame;
					var add = $('#<?php echo $postType ?>-add-image');
					var remove = $('#<?php echo $postType ?>-remove-image');
					var img = $('#<?php echo $postType ?>-image');
					var id = $('#<?php echo $postType ?>-image-id');

					add.on('click', function (e) {
						e.preventDefault();

						if (frame) {
							frame.open();
							return;
						}

						frame = wp.media({
							title: '<?php _e('Upload an Image', 'sleek') ?>',
							button: {
								text: '<?php _e('Use this image', 'sleek') ?>'
							},
							multiple: false
						});

						frame.on('select', function () {
							var attachment = frame.state().get('selection').first().toJSON();

							img.attr('src', attachment.url);
							id.val(attachment.id);
							add.addClass('hidden');
							remove.removeClass('hidden');
						});

						frame.open();
					});

					remove.on('click', function (e) {
						e.preventDefault();

						img.attr('src', '');
						id.val('');
						add.removeClass('hidden');
						remove.addClass('hidden');
					});
				});
			</script>
			<?php
		});

		# Add our new options
		add_action('admin_init', function () use ($postType, $extraFields) {
			register_setting($postType . '_settings', $postType . '_title');
			register_setting($postType . '_settings', $postType . '_description');
			register_setting($postType . '_settings', $postType . '_image', 'intval');

			foreach ($extraFields as $field => $type) {
				register_setting($postType . '_settings', $postType . '_' . $field);
			}
		});
	}
}
