<?php $options = get_option(SLEEK_SETTINGS_NAME) ?>

<?php if (
	isset($options['google_maps_api_key']) and !empty($options['google_maps_api_key']) and
	isset($google_map['lat']) and !empty($google_map['lat']) and
	isset($google_map['lng']) and !empty($google_map['lng'])
) : ?>
	<section id="google-map">

		<?php if ($google_map_title or $google_map_description) : ?>
			<header>

				<?php if ($google_map_title) : ?>
					<h2><?php echo $google_map_title ?></h2>
				<?php endif ?>

				<?php echo $google_map_description ?>

			</header>
		<?php endif ?>

		<noscript>
			<img src="https://maps.googleapis.com/maps/api/staticmap?maptype=roadmap&amp;center=<?php echo $google_map['lat'] ?>,<?php echo $google_map['lng'] ?>&amp;markers=<?php echo $google_map['lat'] ?>,<?php echo $google_map['lng'] ?>&amp;zoom=14&amp;size=600x400&amp;key=<?php echo $options['google_maps_api_key'] ?>">
		</noscript>

		<div class="google-map" data-lat="<?php echo $google_map['lat'] ?>" data-lng="<?php echo $google_map['lng'] ?>" data-zoom="12">

			<?php if ($google_map_info_window) : ?>
				<div data-lat="<?php echo $google_map['lat'] ?>" data-lng="<?php echo $google_map['lng'] ?>">
					<?php echo $google_map_info_window ?>
				</div>
			<?php endif ?>

		</div>

	</section>
<?php else : ?>
	<p class="error"><?php _e('Please make sure to enter a valid Google Maps API Key inside Settings -> Sleek', 'sleek') ?></p>
<?php endif ?>
