<?php /* Template Name: Taxonomy Terms */ ?>
<?php get_header() ?>

<div id="primary-content">

	<?php include TEMPLATEPATH . '/modules/post-content.php' ?>
	<?php include TEMPLATEPATH . '/modules/taxonomy-terms.php' ?>

</div>

<div id="secondary-content">

	<?php dynamic_sidebar('aside') ?>

</div>

<?php get_footer() ?>
