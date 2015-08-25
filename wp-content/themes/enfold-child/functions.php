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
		Custom Columns
	-------------------------------------------------------------------------------*/
	add_filter( 'manage_edit-property_columns', 'my_edit_property_columns' );
	function my_edit_property_columns( $columns ) {

		$columns = array (
			'cb'            => '<input type="checkbox" />',
			'title'         => __( 'Movie' ),
			'practice_name' => __( 'Practice Name' ),
			'add_package'   => __( 'Add Package' ),
			'full_name'     => __( 'Name' ),
			'mobile'        => __( 'Phone Number' ),
			'contact_email' => __( 'eMail' ),
			'_status'       => __( 'Status' ),
			'date'          => __( 'Date' )
		);

		return $columns;
	}

	add_action( 'manage_property_posts_custom_column', 'my_manage_property_columns' );
	function my_manage_property_columns( $column ) {

		global $post;
		/* @TODO -------------------------------------------------------- LOGGING --------------------------------------------------- */
		Debug_Bar_Extender::instance()->trace_var( $post );
		switch ( $column ) {
			/* If displaying the 'Practice Name' column. */
			case 'practice_name' :
				the_field( 'practice_name', $post->ID );
				break;
			case 'add_package':
				$package = get_field( 'advertisement_package', $post->ID );
				echo '$' . $package;
				break;
			/* If displaying the 'First Name' column. */
			case 'full_name' :
				$full_name = get_field( 'first_name', $post->ID ) . '' . get_field( 'last_name', $post->ID );
				echo $full_name;
				break;
			case 'mobile' :
				$phoneNumber = get_field( 'phone_number', $post->ID );
				echo $phoneNumber;
				break;
			case 'contact_email' :
				the_field( 'contact_email', $post->ID );
				break;

			case '_status':
				echo $post->post_status;
				break;

			/* Just break out of the switch statement for everything else. */
			default :
				break;
		}
	}