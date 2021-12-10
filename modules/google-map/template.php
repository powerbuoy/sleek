<?php $key = Sleek\Settings\get_setting('google_maps_api_key') ?>

<?php if (!empty($key)) : ?>
	<section id="google-map">

		<?php if ($title or $description) : ?>
			<header>

				<?php if ($title) : ?>
					<h2><?php echo $title ?></h2>
				<?php endif ?>

				<?php echo $description ?>

			</header>
		<?php endif ?>

		<noscript>
			<img src="https://maps.googleapis.com/maps/api/staticmap?maptype=roadmap&amp;center=<?php echo $google_map['lat'] ?>,<?php echo $google_map['lng'] ?>&amp;markers=<?php echo $google_map['lat'] ?>,<?php echo $google_map['lng'] ?>&amp;zoom=14&amp;size=600x400&amp;key=<?php echo $options['google_maps_api_key'] ?>">
		</noscript>

		<?php if (isset($google_map['lat']) and !empty($google_map['lat']) and isset($google_map['lng']) and !empty($google_map['lng'])) : ?>
			<div class="google-map" data-lat="<?php echo $google_map['lat'] ?>" data-lng="<?php echo $google_map['lng'] ?>" data-zoom="12">

				<?php if ($info_window) : ?>
					<div data-lat="<?php echo $google_map['lat'] ?>" data-lng="<?php echo $google_map['lng'] ?>">
						<?php echo $info_window ?>
					</div>
				<?php endif ?>

			</div>
		<?php else : ?>
			<p class="error"><?php _e('No latitude or longitude specified for map.', 'sleek_admin') ?></p>
		<?php endif ?>

	</section>
<?php elseif (current_user_can('edit_posts')) : ?>
	<p class="error"><?php _e('Please make sure to enter a valid Google Maps API Key inside Settings -> Sleek', 'sleek_admin') ?></p>
<?php endif ?>
