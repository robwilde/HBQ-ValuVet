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
	add_filter( 'manage_edit-property_columns', function ( $columns ) {

		$columns = array (
			'cb'            => '<input type="checkbox" />',
			'title'         => __( 'Movie' ),
			'practice_name' => __( 'Practice Name' ),
			'add_package'   => __( 'Package' ),
			'full_name'     => __( 'Name' ),
			'mobile'        => __( 'Phone Number' ),
			'contact_email' => __( 'eMail' ),
			'_status'       => __( 'Status' ),
			'date'          => __( 'Date' )
		);

		return $columns;
	} );
	add_action( 'manage_property_posts_custom_column', function ( $column ) {

		global $post;
		switch ( $column ) {
			/* If displaying the 'Practice Name' column. */
			case 'practice_name' :
				the_field( 'practice_name', $post->ID );
				break;
			case 'add_package':
				/**
				 *  165 : Package 1 - $165
				 *  330 : Package 2 - $330
				 *  550 : Package 3 - $550
				 */
				$package = get_field( 'advertisement_package', $post->ID );
				switch ( $package ) {
					case "165":
						echo "P1";
						break;
					case "330":
						echo "P2";
						break;
					case "550":
						echo "P3";
						break;
				}
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
	} );
	/*-------------------------------------------------------------------------------
	ACF Filter Field - run after ACF saves the $_POST['acf'] data
	-------------------------------------------------------------------------------*/
	add_action( 'acf/save_post', function ( $post_id ) {

		// STATE | POST ID | PACKAGE LEVEL No |
		$address_state         = get_field( 'address_state' );
		$advertisement_package = get_field( 'advertisement_package' );
		switch ( $advertisement_package ) {
			case '165':
				$package = 'P1';
				break;
			case '330':
				$package = 'P2';
				break;
			case '550':
				$package = 'P3';
				break;
			default:
				$package = 'ERROR';
		}
		$property_id = $address_state . '-' . $post_id . '-' . $package;
		$post_array  = array (
			'ID'         => $post_id,
			'post_title' => $property_id
		);
		$post_title = get_the_title( $post_id );
		//	update the post title
		if ( $property_id !== $post_title ) {
			// did the update work OK
			wp_update_post( $post_array, TRUE );
			if ( is_wp_error( $post_id ) ) {
				// capture the errors and write to the WP Log
				$errors = $post_id->get_error_messages();
				if ( function_exists( '_log' ) ) {
					_log( array (
						'FILE_NAME'      => basename( __FILE__ ),
						'LINE'           => ( __LINE__ ),
						'WP_UPDATE_POST' => $errors
					) );
				}
			}
		}
	}, 100 );
	/*-------------------------------------------------------------------------------
	ACF Javascript - created to modify and update fields in the properties post_type
	-------------------------------------------------------------------------------*/
	add_action( 'acf/input/admin_footer', function () {
		?>

		<script type = "text/javascript">
			(function ($) {

				$.fn.money = function (number, format) {

					var $this = this;

					if (!number || typeof(number) === 'object') {
						//incase just parameters are entered and not a number
						var format = number;
						number = $this.html();
					}


					var format = format || {},
						commas = format.commas || true,
						symbol = format.symbol || "";

					number = parseFloat(number)
						.toFixed(2);

					if (commas) {

						var count = 0;
						var numArr = number.toString().split("");

						var len = numArr.length - 6;

						for (var i = len; i > 0; i = i - 3) {
							numArr.splice(i, 0, ",");

						}

						number = numArr.join("");

					}

					if (typeof symbol === 'string') {
						number = symbol + number;

					}

					$this.val(number);

					return $this;

				};

				// ------------------------------------------------------------
				// function created for displaying log info
				// ------------------------------------------------------------

				var meLog = function (logArray) {

					var logObj = logArray || {},
						value = logObj.value || false,
						name = logObj.name || null;

					if (name !== null) {
						console.info(name);
					}
					console.log(value);

				};

				// ------------------------------------------------------------
				// function filter for fields after load
				// ------------------------------------------------------------
				acf.add_action('ready', function ($el) {

					// ------------------------------------------------------------
					// Updating the Advertising package on save after add upgrade
					// ------------------------------------------------------------

					// selecting the Advertising Package
					var $acfAddPack = $('#acf-field_55dc2db2e7a4f');
					var getTestField = {};
					var $package;
					$acfAddPack.on('change', function () {
						$package = $(this).val();
					});

					// update package with option from P1 to P2 or P3
					var $acfUpOptionOne = $('#acf-field_55dc61325be8b');
					$acfUpOptionOne.on('change', function () {
						var $option = $(this).val();

						switch ($option) {
							case 'Upgrade to Level 2':
								$acfAddPack.val('330');
								break;
							case 'Upgrade to Level 3':
								$acfAddPack.val('550');
								break;
							default :
								$acfAddPack.val('165');
						}

					});


					// update package with option from P2 to P3
					var $acfUpOptionTwo = $('#acf-field_55dd2bd18e20a');
					$acfUpOptionTwo.on('change', function () {
						var $option = $(this).val();

						switch ($option) {
							case 'Upgrade to Level 3':
								$acfAddPack.val('550');
								break;
							default :
								$acfAddPack.val('330');
						}
					});

					// ------------------------------------------------------------
					// Creating the Headline - Advertising Info
					// ------------------------------------------------------------

					// fields for the headline
					var acfFields = {
						practiceFor: null,
						practiceType: null,
						buildingType: null,
						addressCity: null,
						addressState: null
					};

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

					// ------------------------------------------------------------
					// Add word count to text areas
					// ------------------------------------------------------------

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


					// ------------------------------------------------------------
					// Addition of currency fields and filter number to currency
					// ------------------------------------------------------------

					// set stock_dollar_value
					var $acfStock = $('#acf-field_55dc2db2e9445');
					$acfStock.on('change', function () {
						var $thisValue = $(this).val();
						$acfStock.money($thisValue, {commas: true});
						setTotalValue()

					});
					// equipment_dollar_value
					var $acfEquipment = $('#acf-field_55dc2db2e953c');
					$acfEquipment.on('change', function () {
						var $thisValue = $(this).val();
						$acfEquipment.money($thisValue, {commas: true});
						setTotalValue()
					});
					// goodwill_dollar_value
					var $acfGoodwill = $('#acf-field_55dc2db2e963f');
					$acfGoodwill.on('change', function () {
						var $thisValue = $(this).val();
						setTotalValue()
						$acfGoodwill.money($thisValue, {commas: true});
					});
					// property_realestate_value
					var $acfProperty = $('#acf-field_55dc2db2e994c');
					$acfProperty.on('change', function () {
						var $thisValue = $(this).val();
						setTotalValue()
						$acfProperty.money($thisValue, {commas: true});
					});

					// total_value
					var $acfTotal = $('#acf-field_55dc2db2e9b51');

					function setTotalValue() {
						//	convert currency to Number for addition
						function getNumber(currency) {
							if (currency == 0) {
								return currency;
							}
							return Number(currency.replace(/[^0-9\.]+/g, ""));
						}

						// create total
						var totalValue = parseInt(getNumber($acfStock.val()))
							+ parseInt(getNumber($acfEquipment.val()))
							+ parseInt(getNumber($acfGoodwill.val()))
							+ parseInt(getNumber($acfProperty.val()));
						// set total as currency and update
						$acfTotal.money(totalValue, {commas: true})
					}

				});

			})(jQuery);
		</script>
		<?php
	} );