<?php
	/**
	 * Created by HQ
	 * User: Justin Graham
	 * Date: 28/08/2015
	 * Time: 05:09 PM
	 */


	/*======================================================================*/

	/** ADDING CPT TO THE AVIA CUSTOM BUILDER TO SHOW THE CONTENT EDITOR */
	/**
	 * @param $metabox
	 *
	 * @return mixed
	 */
	function add_builder_to_posttype( $metabox ) {

		// Custom Post Types
		$cpt_array = array(
			'property',
		);

		foreach ( $metabox as &$meta ) {
			if ( $meta['id'] == 'avia_builder' || $meta['id'] == 'layout' ) {

				foreach ( $cpt_array as $post_type ) {
					$meta['page'][] = $post_type;
				}
			}
		}

		return $metabox;
	}

	add_filter( 'avf_builder_boxes', 'add_builder_to_posttype' );

	/*======================================================================*/
