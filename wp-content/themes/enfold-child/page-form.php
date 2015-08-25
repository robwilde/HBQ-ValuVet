<?php
/*
Template Name: ACF FORM
*/

acf_form_head();

get_header();

the_post();

?>

	<div class='container_wrap container_wrap_first main_color <?php avia_layout_class( 'main' ); ?>'>

		<div class='container'>

			<?php

			$args = array(
				'post_id' => 'new',
				'field_groups' => array(2339 )
			);

			Debug_Bar_Extender::instance()->trace_var( $args, $var_name = 'ARGS' );

			acf_form( $args );

			?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>