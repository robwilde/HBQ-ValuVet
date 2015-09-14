<?php
	/*
	* Add your own functions here. You can also copy some of the theme functions into this file.
	* WordPress will use those functions instead of the original functions then.
	*/
	define( 'CHILD_PATH_URI', get_stylesheet_directory_uri() );
	define( 'CHILD_PATH_DIR', get_stylesheet_directory() );

	/*-------------------------------------------------------------------------------
		Logging Function
	-------------------------------------------------------------------------------*/
	if ( ! function_exists( '_log' ) ) {
		function _log( $message ) {
			if ( WP_DEBUG === true ) {
				if ( is_array( $message ) || is_object( $message ) ) {
					error_log( print_r( $message, true ) );
				} else {
					error_log( $message );
				}
			}
		}
	}

	/*-------------------------------------------------------------------------------
		Enqueue Script
	-------------------------------------------------------------------------------*/

	// admin
	add_action( 'admin_enqueue_scripts', function () {

		wp_enqueue_style( 'valuvet-admin-css', CHILD_PATH_URI . '/css/valuvet-admin-styles.css', '1.0.0' );
		wp_enqueue_script( 'valuvet-admin', CHILD_PATH_URI . '/js/valuvet-admin.js', array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script( 'word-counter', CHILD_PATH_URI . '/js/jquery.word-and-character-counter.min.js', array( 'jquery' ), '2.4.0', true );
	} );

	// public
	add_action( 'wp_enqueue_scripts', function () {

		wp_enqueue_script( 'valuvet-display', CHILD_PATH_URI . '/js/valuvet-public.js', array( 'jquery' ), '1.0.0', true );
	} );

	/*-------------------------------------------------------------------------------
		Avia builder debug mode
	-------------------------------------------------------------------------------*/
	add_action( 'avia_builder_mode', function () {

		return "debug";
	} );

	/*-------------------------------------------------------------------------------
		Avia builder Autoload Shortcodes
	-------------------------------------------------------------------------------*/
	add_filter( 'avia_load_shortcodes', function ( $paths ) {

		$template_url = get_stylesheet_directory();
		array_unshift( $paths, $template_url . '/shortcodes/' );

		return $paths;
	}, 15, 1 );

	/*-------------------------------------------------------------------------------
		Auto assign WP POST Featured image from ACF primary_image
	-------------------------------------------------------------------------------*/
	// acf/update_value/name={$field_name} - filter for a specific field based on it's name
	add_filter( 'acf/update_value/name=primary_image', function ( $value, $post_id, $field ) {

		if ( $value != '' ) {
			delete_post_thumbnail( $post_id );
			//Add the value which is the image ID to the _thumbnail_id meta data for the current post
			add_post_meta( $post_id, '_thumbnail_id', $value );
		}

		return $value;
	}, 10, 3 );

	/*-------------------------------------------------------------------------------
		Change AVIA LAYOUT BUILDER PORTFOLIO GRID to include CUSTOM POST TYPEs
	-------------------------------------------------------------------------------*/
	add_theme_support( 'avia_template_builder_custom_post_type_grid' );
	add_theme_support( 'add_avia_builder_post_type_option' );

	/*-------------------------------------------------------------------------------
		WTC Actions and Filters - add PROPERTY to use the ADVANCED LAYOUT BUILDER
	-------------------------------------------------------------------------------*/
	require_once( CHILD_PATH_DIR . '/inc/wtc-hooks.php' );

	/*-------------------------------------------------------------------------------
		ACF Custom actions
	-------------------------------------------------------------------------------*/
	require_once( CHILD_PATH_DIR . "/inc/acf-custom.php" );
