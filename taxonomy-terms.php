<?php /* Template Name: Taxonomy Terms */ ?>
<?php get_header() ?>

<div class="section gray"><div>

	<?php the_title() ?>

</div></div>

<div class="section"><div>

	<?php include TEMPLATEPATH . '/modules/post-content.php' ?>
	<?php include TEMPLATEPATH . '/modules/taxonomy-terms.php' ?>

</div></div>

<aside id="aside" class="section light-blue"><div>

	<?php dynamic_sidebar('aside') ?>

</div></aside>

<?php get_footer() ?>
