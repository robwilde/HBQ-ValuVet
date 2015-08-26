<?php
	/**
	 * Created by WTC.
	 * User: Rob Wilde
	 * Date: 26/08/2015
	 * Time: 1:27 PM
	 */
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

	/*-------------------------------------------------------------------------------
	ACF Javascript
-------------------------------------------------------------------------------*/
	add_action( 'acf/input/admin_footer', function () {

		/*
		 * creating a capture for the generated heading
		 * [practice_is_for] - [practice_type] - [address_city, address_state]
		 *
		 */
		?>


		<script type = "text/javascript">
			(function ($) {

				acf.add_action('ready', function ($el) {

					var acfFields = {
						practiceFor: null,
						practiceType: null,
						addressCity: null,
						addressState: null
					}

//					var $practiceFor, $practiceType, $addressCity, $addressState;

					// retrieve PRACTICE IS FOR selected
					var $field = $('#acf-field_55dc2db2e9268');
					$field.on('change', function () {
						acfFields.practiceFor = $(this).val();
						headingField(acfFields);
					});


					// retrieve PRACTICE TYPE selected
					var $field = $('#acf-field_55dc2db2e8739');
					$field.on('change', function () {
						acfFields.practiceType = $(this).val();
						if (acfFields.practiceType == 'Other') {
							$('#acf-field_55dc2db2e8826').on('change', function () {
								console.info('other');
								console.log($(this).val());
								acfFields.practiceType = $(this).val();
								headingField(acfFields);

							});
						} else {
							headingField(acfFields);
						}
					});

					// retrieve ADDRESS CITY selected
					var $field = $('#acf-field_55dc2db2e8b0e');
					$field.on('change', function () {
						acfFields.addressCity = $(this).val();
						headingField(acfFields);
					});

					// retrieve ADDRESS CITY selected
					var $field = $('#acf-field_55dc2db2e8bfa');
					$field.on('change', function () {
						acfFields.addressState = $(this).val();
						headingField(acfFields);
					});

					var $headline = $('#level_one_headline').find('.acf-input');
					// level 2 & 3 custom headline
//					var $customHeadLinePrepend = $('.acf-field-55dc2db2eacf2').find('.acf-input-prepend');

					var $customHeadline = $('.acf-field-55dc2db2eacf2').find('.acf-input');

//					var $customHeadLinePrepend = $('.acf-field-55dc2db2eacf2').find('.acf-input-prepend');


					function headingField(inputs) {
						$headline.html(acfFields.practiceFor + ' - '
							+ acfFields.practiceType + ' - '
							+ acfFields.addressCity + ','
							+ acfFields.addressState);

						$customHeadline.find('.acf-input-prepend').html(acfFields.practiceFor);
//						$customHeadline.find('.acf-input-wrap').html(acfFields.practiceType);
						$customHeadline.find('.acf-input-append').html(acfFields.addressCity + ',' + acfFields.addressState);
					};


				});

			})(jQuery);
		</script>
		<?php
	} );