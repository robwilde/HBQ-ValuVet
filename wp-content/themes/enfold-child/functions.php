<?php
	/*
	* Add your own functions here. You can also copy some of the theme functions into this file.
	* Wordpress will use those functions instead of the original functions then.
	*/
	define( 'CHILD_PATH_URI', get_stylesheet_directory_uri() );
	define( 'CHILD_PATH_DIR', get_stylesheet_directory() );
	/*-------------------------------------------------------------------------------
	Enqueue Script
	-------------------------------------------------------------------------------*/
	add_action( 'admin_enqueue_scripts', function(){
		wp_enqueue_script('word-counter', CHILD_PATH_URI . '/js/jquery.word-and-character-counter.min.js', array('jquery'), '2.4.0', TRUE);
	});


	/*-------------------------------------------------------------------------------
	Avia builder debug mode
	-------------------------------------------------------------------------------*/
	add_action( 'avia_builder_mode', "builder_set_debug" );
	function builder_set_debug() {

		return "debug";
	}

	/*-------------------------------------------------------------------------------
	Avia builder Autoload Shortcodes
	-------------------------------------------------------------------------------*/
	add_filter('avia_load_shortcodes', 'avia_include_shortcode_template', 15, 1);
	function avia_include_shortcode_template($paths)
	{
		$template_url = get_stylesheet_directory();
		array_unshift($paths, $template_url.'/shortcodes/');

		return $paths;
	}

	/*-------------------------------------------------------------------------------
	Change AVIA LAYOUT BUILDER PORTFOLIO GRID to include CUSTOM POST TYPEs
	-------------------------------------------------------------------------------*/
	add_theme_support( 'avia_template_builder_custom_post_type_grid' );
	add_theme_support( 'add_avia_builder_post_type_option' );

	/*-------------------------------------------------------------------------------
	WTC Actions and Filters - add PROPERTY to use the ADVANCED LAYOUT BUIILDER
	-------------------------------------------------------------------------------*/

	require_once( CHILD_PATH_DIR . '/inc/wtc-hooks.php' );

	/*-------------------------------------------------------------------------------
		ACF Custom actions
	-------------------------------------------------------------------------------*/
	require_once( CHILD_PATH_DIR . "/inc/acf-custom.php" );



