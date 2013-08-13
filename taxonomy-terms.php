<?php /* Template Name: Taxonomy Terms */ ?>
<?php get_header() ?>

<div class="section"><div>

	<div class="wrapper">

		<div class="primary">

			<?php include TEMPLATEPATH . '/modules/post-content.php' ?>
			<?php include TEMPLATEPATH . '/modules/taxonomy-terms.php' ?>

		</div>

		<div class="secondary">

			<?php dynamic_sidebar('aside') ?>

		</div>

	</div>

	<h2><?php _e('Popular packages', 'h5b') ?></h2>

	<?php include TEMPLATEPATH . '/modules/featured-packages.php' ?>

</div></div>

<?php get_footer() ?>
