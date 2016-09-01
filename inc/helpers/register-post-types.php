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

		# Create the post type nice-name based on the the postType name
		$name = __(ucfirst(str_replace('_', ' ', $postType)), $textdomain);

		# Create the config
		$config = array(
			'labels' => array(
				'name' => $name,
				'singular_label' => $name
			),
			'rewrite' => array(
				'with_front' => false,
				'slug' => $slug
			),
			'exclude_from_search' => false,
			'has_archive' => true,
			'public' => true,
			'supports' => array(
				'title', 'editor', 'author', 'thumbnail', 'excerpt',
				'wpcom-markdown', 'trackbacks', 'custom-fields',
				'revisions', 'page-attributes', 'comments'
			)
		);

		# If a config array was specified
		if (is_array($data)) {
			$config = array_merge($config, $data);
		}

		register_post_type($postType, $config);
	}
}

function sleek_register_post_type_meta_data ($postTypes, $textdomain = 'sleek') {
	add_action('admin_head', function () {
		?>
		<style>
			div.sleek-cpt-meta-data {
			}

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

			div.sleek-cpt-meta-data div.wp-media-buttons {
				float: none;
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
		if (!is_array($data)) {
			$postType = $data;
		}

		# Create the nice name
		$name = __(ucfirst(str_replace('_', ' ', $postType)), $textdomain);

		# Add the admin menu
		add_submenu_page(
			# Parent slug
			'edit.php?post_type=' . $postType,

			# Page title
			sprintf(__('%s meta data', $textdomain), $name),

			# Menu title
			sprintf(__('%s meta data', $textdomain), $name),

			# Capability needed
			'manage_options',

			# Page slug
			'edit-' . $postType . '-meta',

			# The function that adds the settings screen
			function () use ($postType, $textdomain, $name) {
				$uploadURL = get_upload_iframe_src('image', null);
				$imgID = get_option($postType . '_image');
				$imgSrc = wp_get_attachment_image_src($imgID, 'thumbnail');
				$hasImg = is_array($imgSrc);
				?>
				<div class="wrap sleek-cpt-meta-data">

					<h1><?php printf(__('Edit %s Meta Data', $textdomain), $name) ?></h1>

					<form method="post" action="options.php">

						<div class="form-field title">
							<input type="text"
								name="<?php echo $postType ?>_title"
								value="<?php echo stripslashes(get_option($postType . '_title')) ?>"
								placeholder="<?php _e('Title', $textdomain) ?>">
						</div>

						<div class="form-field">
							<?php if ($hasImg) : ?>
								<img id="<?php echo $postType ?>-image" src="<?php echo $imgSrc[0] ?>">
							<?php else : ?>
								<img id="<?php echo $postType ?>-image">
							<?php endif ?>

							<button class="button <?php if ($hasImg) : ?>hidden<?php endif ?>" id="<?php echo $postType ?>-add-image">
								<?php _e('Upload an Image', $textdomain) ?>
							</button>
							<button class="button <?php if (!$hasImg) : ?>hidden<?php endif ?>" id="<?php echo $postType ?>-remove-image">
								<?php _e('Remove Image', $textdomain) ?>
							</button>

							<input id="<?php echo $postType ?>-image-id" name="<?php echo $postType ?>_image" type="hidden" value="<?php echo esc_attr($imgID); ?>">
						</div>

						<?php wp_editor(
							stripslashes(get_option($postType . '_description')),
							$postType . '_settings',
							array('textarea_name' => $postType . '_description')
						) ?>

						<?php settings_fields($postType . '_settings') ?>
						<?php submit_button() ?>

					</form>

				</div>
				<?php
			}
		);

		# Add upload scripts
		add_action('admin_head', function () use ($postType, $textdomain, $name) {
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
							title: '<?php _e('Upload an Image', $textdomain) ?>',
							button: {
								text: '<?php _e('Use this image', $textdomain) ?>'
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
		add_action('admin_init', function () use ($postType, $textdomain, $name) {
			register_setting($postType . '_settings', $postType . '_title');
			register_setting($postType . '_settings', $postType . '_description');
			register_setting($postType . '_settings', $postType . '_image', 'intval');
		});
	}
}
