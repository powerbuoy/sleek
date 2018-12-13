<?php $options = get_option(SLEEK_SETTINGS_NAME) ?>

<?php if (isset($options['google_maps_api_key']) and !empty($options['google_maps_api_key'])) : ?>
	<section id="google-map">

		<?php if ($google_map_title or $google_map_description) : ?>
			<header>

				<?php if ($google_map_title) : ?>
					<h2><?php echo $google_map_title ?></h2>
				<?php endif ?>

				<?php echo $google_map_description ?>

			</header>
		<?php endif ?>

		<div class="google-map" data-lat="<?php echo $google_map['lat'] ?>" data-lng="<?php echo $google_map['lng'] ?>">

			<img src="https://maps.googleapis.com/maps/api/staticmap?maptype=roadmap&amp;center=<?php echo $google_map['lat'] ?>,<?php echo $google_map['lng'] ?>&amp;markers=<?php echo $google_map['lat'] ?>,<?php echo $google_map['lng'] ?>&amp;zoom=14&amp;size=600x400&amp;key=<?php echo $options['google_maps_api_key'] ?>">

			<?php if ($google_map_info_window) : ?>
				<div class="google-map-info-window">
					<?php echo $google_map_info_window ?>
				</div>
			<?php endif ?>

		</div>

	</section>
<?php else : ?>
	<p class="error"><?php _e('Please make sure to enter a valid Google Maps API Key inside Settings -> Sleek', 'sleek') ?></p>
<?php endif ?>
