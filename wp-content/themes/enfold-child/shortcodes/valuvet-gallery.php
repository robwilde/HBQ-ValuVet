<?php
	/**
	 * Gallery
	 * Shortcode that allows to create a gallery based on images selected from the media library
	 */

	if ( ! class_exists( 'avia_valuvet_gallery' ) ) {
		class avia_valuvet_gallery extends aviaShortcodeTemplate {
			static $gallery = 0;
			var $extra_style = "";
			var $non_ajax_style = "";

			/**
			 * Create the config array for the shortcode button
			 */
			function shortcode_insert_button() {
				$this->config['name']       = __( 'ValuVet Gallery', 'avia_framework' );
				$this->config['tab']        = __( 'Media Elements', 'avia_framework' );
				$this->config['icon']       = AviaBuilder::$path['imagesURL'] . "sc-gallery.png";
				$this->config['order']      = 6;
				$this->config['target']     = 'avia-target-insert';
				$this->config['shortcode']  = 'vv_gallery';
				$this->config['modal_data'] = array( 'modal_class' => 'mediumscreen' );
				$this->config['tooltip']    = __( 'Add a Valuvet image gallery', 'avia_framework' );
			}

			/**
			 * Popup Elements
			 *
			 * If this function is defined in a child class the element automatically gets an edit button, that, when pressed
			 * opens a modal window that allows to edit the element properties
			 *
			 * @return void
			 */
			function popup_elements() {
				$this->elements = array(

					array(
						"name"    => __( "Gallery Style", 'avia_framework' ),
						"desc"    => __( "Choose the layout of your Gallery", 'avia_framework' ),
						"id"      => "style",
						"type"    => "select",
						"std"     => "thumbnails",
						"subtype" => array(
							__( 'Small Thumbnails', 'avia_framework' )                => 'thumbnails',
							__( 'Big image with thumbnails below', 'avia_framework' ) => 'big_thumb',
						)
					),
					array(
						"name"     => __( "Gallery Big Preview Image Size", 'avia_framework' ),
						"desc"     => __( "Choose image size for the Big Preview Image", 'avia_framework' ),
						"id"       => "preview_size",
						"type"     => "select",
						"std"      => "portfolio",
						"required" => array( 'style', 'equals', 'big_thumb' ),
						"subtype"  => AviaHelper::get_registered_image_sizes( array( 'logo' ) )
					),
					array(
						"name"     => __( "Force same size for all big preview images?", 'avia_framework' ),
						"desc"     => __( "Depending on the size you selected above, preview images might differ in size. Should the theme force them to display at exactly the same size?", 'avia_framework' ),
						"id"       => "crop_big_preview_thumbnail",
						"type"     => "select",
						"std"      => "yes",
						"required" => array( 'style', 'equals', 'big_thumb' ),
						"subtype"  => array(
							__( 'Yes, force same size on all Big Preview images, even if they use a different aspect ratio', 'avia_framework' ) => 'avia-gallery-big-crop-thumb',
							__( 'No, do not force the same size', 'avia_framework' )                                                            => 'avia-gallery-big-no-crop-thumb'
						)
					),
					array(
						"name"    => __( "Gallery Preview Image Size", 'avia_framework' ),
						"desc"    => __( "Choose image size for the small preview thumbnails", 'avia_framework' ),
						"id"      => "thumb_size",
						"type"    => "select",
						"std"     => "portfolio",
						"subtype" => AviaHelper::get_registered_image_sizes( array( 'logo' ) )
					),
					array(
						"name"    => __( "Gallery Columns", 'avia_framework' ),
						"desc"    => __( "Choose the column count of your Gallery", 'avia_framework' ),
						"id"      => "columns",
						"type"    => "select",
						"std"     => "5",
						"subtype" => AviaHtmlHelper::number_array( 1, 12, 1 )
					),
					array(
						"name"    => __( "Use Lighbox", 'avia_framework' ),
						"desc"    => __( "Do you want to activate the lightbox", 'avia_framework' ),
						"id"      => "imagelink",
						"type"    => "select",
						"std"     => "5",
						"subtype" => array(
							__( 'Yes', 'avia_framework' )                                             => 'lightbox',
							__( 'No, open the images in the browser window', 'avia_framework' )       => 'aviaopeninbrowser noLightbox',
							__( 'No, open the images in a new browser window/tab', 'avia_framework' ) => 'aviaopeninbrowser aviablank noLightbox',
							__( 'No, don\'t add a link to the images at all', 'avia_framework' )      => 'avianolink noLightbox'
						)
					),
					array(
						"name"    => __( "Thumbnail fade in effect", 'avia_framework' ),
						"desc"    => __( "You can set when the gallery thumbnail animation starts", 'avia_framework' ),
						"id"      => "lazyload",
						"type"    => "select",
						"std"     => "avia_lazyload",
						"subtype" => array(
							__( 'Show the animation when user scrolls to the gallery', 'avia_framework' )                      => 'avia_lazyload',
							__( 'Activate animation on page load (might be preferable on large galleries)', 'avia_framework' ) => 'deactivate_avia_lazyload'
						)
					),

				);

			}

			/**
			 * Editor Element - this function defines the visual appearance of an element on the AviaBuilder Canvas
			 * Most common usage is to define some markup in the $params['innerHtml'] which is then inserted into the drag and drop container
			 * Less often used: $params['data'] to add data attributes, $params['class'] to modify the className
			 *
			 *
			 * @param array $params this array holds the default values for $content and $args.
			 *
			 * @return $params the return array usually holds an innerHtml key that holds item specific markup.
			 */
			function editor_element( $params ) {
				$params['innerHtml'] = "<img src='" . $this->config['icon'] . "' title='" . $this->config['name'] . "' />";
				$params['innerHtml'] .= "<div class='avia-element-label rabbits-shit'>" . $this->config['name'] . "</div>";
				$params['content'] = null; //remove to allow content elements
				return $params;
			}

			/**
			 * Frontend Shortcode Handler
			 *
			 * @param array $atts array of attributes
			 * @param string $content text within enclosing form of shortcode element
			 * @param string $shortcodename the shortcode found, when == callback name
			 *
			 * @return string $output returns the modified html string
			 */
			function shortcode_handler( $atts, $content = "", $shortcodename = "", $meta = "" ) {
				$output = "";
				$first  = true;

				if ( empty( $atts['columns'] ) && isset( $atts['ids'] ) ) {
					$atts['columns'] = count( explode( ",", $atts['ids'] ) );
					if ( $atts['columns'] > 10 ) {
						$atts['columns'] = 10;
					}
				}

				/**
				 * @var $order
				 * @var $thumb_size
				 * @var $size
				 * @var $lightbox_size
				 * @var $preview_size
				 * @var $ids
				 * @var $ajax_request
				 * @var $imagelink
				 * @var $style
				 * @var $columns
				 * @var $lazyload
				 * @var $crop_big_preview_thumbnail
				 */

				extract( shortcode_atts( array(
					'order'                      => 'ASC',
					'thumb_size'                 => 'thumbnail',
					'size'                       => '',
					'lightbox_size'              => 'large',
					'preview_size'               => 'portfolio',
					'ids'                        => '',
					'ajax_request'               => false,
					'imagelink'                  => 'lightbox',
					'style'                      => 'thumbnails',
					'columns'                    => 8,
					'lazyload'                   => 'avia_lazyload',
					'crop_big_preview_thumbnail' => 'avia-gallery-big-crop-thumb'
				), $atts, $this->config['shortcode'] ) );

				$attachments = get_field( 'image_gallery_2' );

				//compatibility mode for default wp galleries
				if ( ! empty( $size ) ) {
					$thumb_size = $size;
				}


				if ( ! empty( $attachments ) && is_array( $attachments ) ) {
					self::$gallery ++;
					$thumb_width = round( 100 / $columns, 4 );

					$markup = avia_markup_helper( array(
						'context'       => 'image',
						'echo'          => false,
						'custom_markup' => $meta['custom_markup']
					) );
					
					$output .= '<div class="hr hr-default"><span class="hr-inner "><span class="hr-inner-style"></span></span></div>';
					$output .= '<h3>Image Gallery</h3><br/>';
					
					$output .= "<div class='avia-gallery avia-gallery-" . self::$gallery . " " . $lazyload . " avia_animate_when_visible " . $meta['el_class'] . "' $markup>";
					$thumbs  = "";
					$counter = 0;

					foreach ( $attachments as $attachment ) {
						$link              = apply_filters( 'avf_avia_builder_gallery_image_link', wp_get_attachment_image_src( $attachment['ID'], $lightbox_size ), $attachment, $atts, $meta );
						$custom_link_class = ! empty( $link['custom_link_class'] ) ? $link['custom_link_class'] : '';
						$class             = $counter ++ % $columns
							? "class='$imagelink $custom_link_class suppress-tooltip'"
							: "class='first_thumb $imagelink $custom_link_class suppress-tooltip'";

						$img  = wp_get_attachment_image_src( $attachment['ID'], $thumb_size );
						$prev = wp_get_attachment_image_src( $attachment['ID'], $preview_size );

//						$caption = trim( $attachment->post_excerpt ) ? wptexturize( $attachment->post_excerpt ) : "";
						$caption = trim( $attachment['caption'] ) ? wptexturize( $attachment['caption'] ) : "";
						$tooltip = $caption ? "data-avia-tooltip='" . $caption . "'" : "";

						$alt = get_post_meta( $attachment['ID'], '_wp_attachment_image_alt', true );
						$alt = ! empty( $alt ) ? esc_attr( $alt ) : '';
//						$title       = trim( $attachment->post_title ) ? esc_attr( $attachment->post_title ) : "";
//						$description = trim( $attachment->post_content ) ? esc_attr( $attachment->post_content ) : esc_attr( trim( $attachment->post_excerpt ) );

						$title       = trim( $attachment['title'] ) ? esc_attr( $attachment['title'] ) : "";
						$description = trim( $attachment['description'] ) ? esc_attr( $attachment['description'] ) : esc_attr( trim( $attachment['caption'] ) );

						$markup_url = avia_markup_helper( array(
							'context'       => 'image_url',
							'echo'          => false,
							'id'            => $attachment['ID'],
							'custom_markup' => $meta['custom_markup']
						) );

						if ( $style == "big_thumb" && $first ) {
							$output .= "<a class='avia-gallery-big fakeLightbox $imagelink $crop_big_preview_thumbnail $custom_link_class' href='" . $link[0] . "'  data-onclick='1' title='" . $description . "' ><span class='avia-gallery-big-inner' $markup_url>";
							$output .= "	<img width='" . $prev[1] . "' height='" . $prev[2] . "' src='" . $prev[0] . "' title='" . $title . "' alt='" . $alt . "' />";
							if ( $caption ) {
								$output .= "	<span class='avia-gallery-caption'>{$caption}</span>";
							}
							$output .= "</span></a>";
						}

						$thumbs .= " <a href='" . $link[0] . "' data-rel='gallery-" . self::$gallery . "' data-prev-img='" . $prev[0] . "' {$class} data-onclick='{$counter}' title='" . $description . "' $markup_url><img {$tooltip} src='" . $img[0] . "' width='" . $img[1] . "' height='" . $img[2] . "'  title='" . $title . "' alt='" . $alt . "' /></a>";
						$first = false;
					}

					$output .= "<div class='avia-gallery-thumb'>{$thumbs}</div>";
					$output .= "</div>";
		
					

					$selector = ! empty( $atts['ajax_request'] ) ? ".ajax_slide" : "";

					//generate thumb width based on columns
					$this->extra_style .= "<style type='text/css'>";
					$this->extra_style .= "#top #wrap_all {$selector} .avia-gallery-" . self::$gallery . " .avia-gallery-thumb a{width:{$thumb_width}%;}";
					$this->extra_style .= "</style>";

					if ( ! empty( $this->extra_style ) ) {
						if ( ! empty( $atts['ajax_request'] ) ) {
							$output .= $this->extra_style;
							$this->extra_style = "";
						} else {
							$this->non_ajax_style = $this->extra_style;
							add_action( 'wp_footer', array( $this, 'print_extra_style' ) );
						}
					}

				}

				return $output;
			}


			function print_extra_style() {
				echo $this->non_ajax_style;
			}

		}
	}

