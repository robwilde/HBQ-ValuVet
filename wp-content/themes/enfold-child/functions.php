<?php
	/*
	* Add your own functions here. You can also copy some of the theme functions into this file.
	* Wordpress will use those functions instead of the original functions then.
	*/
	define( 'CHILD_PATH_URI', get_stylesheet_directory_uri() );
	define( 'CHILD_PATH_DIR', get_stylesheet_directory() );
	function wtc_wizard_scripts() {

		// Only run this code when it is the wizard template
		if ( is_page_template( 'page-wizard.php' ) ) {
			wp_enqueue_style( 'wtc_wizard_bootstrap_css', CHILD_PATH_URI . '/css/bootstrap.min.css' );
			wp_enqueue_style( 'wtc_wizard_fuelux_css', CHILD_PATH_URI . '/css/fuelux.min.css' );
			wp_enqueue_script( 'wtc_wizard_bootstrap_js', CHILD_PATH_URI . '/js/bootstrap.min.js', array ( 'jquery' ), '3.2.2', TRUE );
			wp_enqueue_script( 'wtc_wizard_fuelux_js', CHILD_PATH_URI . '/js/fuelux.min.js', array ( 'jquery' ), '3.4.0', TRUE );
		}
	}

	add_action( 'wp_enqueue_scripts', 'wtc_wizard_scripts' );


	/*-------------------------------------------------------------------------------
		ACF Custom actions
	-------------------------------------------------------------------------------*/
	require_once (CHILD_PATH_DIR . "/inc/acf-custom.php");
