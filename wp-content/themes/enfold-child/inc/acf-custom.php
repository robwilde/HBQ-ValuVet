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
						buildingType: null,
						addressCity: null,
						addressState: null
					}
					// var $practiceFor, $practiceType, $addressCity, $addressState;

					// count words in field
					function wordCount(val) {
						return {
							charactersNoSpaces: val.replace(/\s+/g, '').length,
							characters: val.length,
							words: val.match(/\S+/g).length,
							lines: val.split(/\r*\n/).length
						};
					}


					// retrieve PRACTICE IS FOR selected
					var $acfPracticeFor = $('#acf-field_55dc2db2e9268');
					$acfPracticeFor.on('change', function () {
						acfFields.practiceFor = $(this).val();
						headingField(acfFields);
					});


					// retrieve PRACTICE TYPE selected
					var $acfPracticeType = $('#acf-field_55dc2db2e8739');
					$acfPracticeType.on('change', function () {
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


					// retrieve BUILDING TYPE selected
					var $acfBuildType = $('#acf-field_55dc564e9f897');
					$acfBuildType.on('change', function () {
						acfFields.buildingType = $(this).val();
						console.log($(this).val());
						acfFields.buildingType = $(this).val();

						headingField(acfFields);
					});


					// retrieve ADDRESS CITY selected
					var $acfAddressCity = $('#acf-field_55dc2db2e8b0e');
					$acfAddressCity.on('change', function () {
						acfFields.addressCity = $(this).val();
						headingField(acfFields);
					});

					// retrieve ADDRESS CITY selected
					var $acfAddressState = $('#acf-field_55dc2db2e8bfa');
					$acfAddressState.on('change', function () {
						acfFields.addressState = $(this).val();
						headingField(acfFields);
					});

					// creating the heading and/or custom heading prepend/append
					var $headline = $('#level_one_headline').find('.acf-input');
					var $customHeadline = $('.acf-field-55dc2db2eacf2').find('.acf-input');

					function headingField(inputs) {
						$headline.html(acfFields.practiceFor + ' - '
							+ acfFields.practiceType + ' '
							+ acfFields.buildingType + ' - '
							+ acfFields.addressCity + ','
							+ acfFields.addressState);

						$customHeadline.find('.acf-input-prepend').html(acfFields.practiceFor);
						$customHeadline.find('.acf-input-append').html(acfFields.addressCity + ',' + acfFields.addressState);
					};

					// add word count to section
					// SHORT DESCRIPTION 150
					$('#acf-field_55dc3a802b7a6').counter({
						type: 'word',
						goal: 150
					});

					// SHORT DESCRIPTION 300
					$('#acf-field_55dc2db2eaed4').counter({
						type: 'word',
						goal: 300
					});

					// BUSINESS DESCRIPTION (Package 3)
					$('#acf-field_55dc3e01ce02f').counter({
						type: 'word',
						goal: 300
					});

					// BUSINESS OPPORTUNITY (Package 3)
					$('#acf-field_55dc3e8ace030').counter({
						type: 'word',
						goal: 300
					});

					// BUSINESS LOCATION (Package 3)
					$('#acf-field_55dc3ea1ce031').counter({
						type: 'word',
						goal: 300
					});

				});

			})(jQuery);
		</script>
		<?php
	} );