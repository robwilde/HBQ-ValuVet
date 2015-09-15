<?php

	/*-------------------------------------------------------------------------------
			Adding CPT to AVIA Custom Builder
	-------------------------------------------------------------------------------*/

	/**
	 * @param $metabox
	 *
	 * @return mixed
	 */
	add_filter( 'avf_builder_boxes', function ( $metabox ) {

		// Custom Post Types
		$cpt_array = array(
			'property',
			'page'
		);

		foreach ( $metabox as &$meta ) {
			if ( $meta['id'] == 'avia_builder' || $meta['id'] == 'layout' ) {

				foreach ( $cpt_array as $post_type ) {
					$meta['page'][] = $post_type;
				}
			}
		}

		return $metabox;
	} );
