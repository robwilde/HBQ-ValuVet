<?php
/*
Template Name: ACF Wizard
*/

get_header();

//the_post();

?>

	<div class='container_wrap container_wrap_first main_color <?php avia_layout_class( 'main' ); ?>'>

		<div class='container'>

		<?php get_template_part('inc/content', 'wizard'); ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>