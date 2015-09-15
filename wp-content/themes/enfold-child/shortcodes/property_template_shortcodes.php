<?php

	/**
	 * Class VALUVET_SHORTCODES
	 * Warranty Form Shortcode
	 */
	class VALUVET_SHORTCODES {

		public static $add_package;

		public static function getAddPackage() {
			$_add_package = get_field( 'advertisement_package' );
			$package = '';

			switch ( $_add_package ) {
				case '165':
					$package = 'p1';
					break;
				case '330':
					$package = 'p2';
					break;
				case '550':
					$package = 'p3';
					break;

			}

			return $package;
		}


		public static function register_shortcodes() {
			/* Add list of Shortcode here  - function is below */
			add_shortcode( 'property_title', array( __CLASS__, 'property_title' ) );
			add_shortcode( 'property_address', array( __CLASS__, 'property_address' ) );
			add_shortcode( 'property_overview_desc', array( __CLASS__, 'property_overview_desc' ) );
			add_shortcode( 'property_price', array( __CLASS__, 'property_price' ) );
			add_shortcode( 'property_snapshot', array( __CLASS__, 'property_snapshot' ) );
			add_shortcode( 'property_type_of_practice', array( __CLASS__, 'property_type_of_practice' ) );
			add_shortcode( 'property_staff', array( __CLASS__, 'property_staff' ) );
			add_shortcode( 'property_facilities', array( __CLASS__, 'property_facilities' ) );
			add_shortcode( 'property_services_professional', array( __CLASS__, 'property_services_professional' ) );
			add_shortcode( 'property_services_ancillary', array( __CLASS__, 'property_services_ancillary' ) );
			add_shortcode( 'property_desc_business', array( __CLASS__, 'property_desc_business' ) );
			add_shortcode( 'property_desc_opportunity', array( __CLASS__, 'property_desc_opportunity' ) );
			add_shortcode( 'property_desc_location', array( __CLASS__, 'property_desc_location' ) );

			self::$add_package = self::getAddPackage();

		}
		/* add shortcode Function here */

		/*-------------------------------------------------------------------------------
				PROPERTY TITLE
		-------------------------------------------------------------------------------*/

		/**/
		public static function property_title() {

			$headline_select = get_field( 'headline_select' );

			$standard_section = get_field( 'practice_type' ) . ' ' . get_field( 'building_type' );
			/* @TODO -------------------------------------------------------- LOGGING --------------------------------------------------- */
			if ( function_exists( '_log' ) ) {
				_log( array(
					'FILE_NAME'       => basename( __FILE__ ),
					'LINE'            => ( __LINE__ ),
					'HEADLINE_SELECT' => $headline_select,
					'STANDARD'        => $standard_section,
					'ADD_PACKAGE'     => self::$add_package,
					'POST_ID'         => get_the_ID()
				) );
			}
			/*--------------------------------------------------------- LOGGING ------------------------------------------------------------*/

			$custom_section = ( $headline_select == 'Custom Headline' )
				? get_field( 'custom_headline' )
				: $standard_section;

			$location = get_field( 'address_city' ) . ',' . get_field( 'address_state' );
			$headline = get_field( 'practice_is_for' ) . ' - ' . $custom_section . ' - ' . $location;

			$out = '<h3>' . $headline . '</h3>';

			return $out;
		}
		/**/

		/*-------------------------------------------------------------------------------
			PROPERTY ADDRESS
		-------------------------------------------------------------------------------*/

		/**/
		public static function property_address() {

			$out = '<h6>Business Name:</strong></h6>';
			$out .= '<p>' . get_field( 'practice_name' ) . '</p>';
			$out .= '<h6>Address:</h6>';
			$out .= '<p>' . get_field( 'address_street' ) . '<br/>';
			$out .= get_field( 'address_city' ) . ', ' . get_field( 'address_state' ) . ' ' . get_field( 'address_postcode' ) . '</p>';

			return $out;
		}
		/**/

		/*-------------------------------------------------------------------------------
			PROPERTY OVERVIEW DESCRIPTION
		-------------------------------------------------------------------------------*/

		/**/
		public static function property_overview_desc() {

			$short_description_1 = get_field( 'short_description_1' );
			$short_description_2 = get_field( 'short_description_2' );

			$out = '<h6>Overview Description:</h6>';
			$out .= '<p>';

			$out .= ( get_field( 'advertisement_package' ) == '165' )
				? $short_description_1
				: $short_description_2;

			$out .= '</p>';

			return $out;
		}
		/**/

		/*-------------------------------------------------------------------------------
			PROPERTY PRICE
		-------------------------------------------------------------------------------*/

		/**/
		public static function property_price() {

			$show_asking_price = get_field( 'show_asking_price' );
			$total_value       = get_field( 'total_value' );
			$practice_is_for   = get_field( 'practice_is_for' );

			$out = ( $show_asking_price == 'yes' )
				? '<h3 class="asking_price"> $' . $total_value . '</h3>'
				: '<h3 class="asking_price">P.O.A.</h3>';

			$out = ( $practice_is_for == 'For Lease' )
				? '<h3 class="asking_price">FOR LEASE</h3>'
				: $out;

			return $out;
		}

		/*-------------------------------------------------------------------------------
			PROPERTY OVERVIEW SNAPSHOT
		-------------------------------------------------------------------------------*/

		/**/
		public static function property_snapshot() {

			$practice_type       = get_field( 'practice_type' );
			$practice_type_label = ( $practice_type != 'other' )
				? $practice_type
				: get_field( 'other_type' );

			$out = '<ul>';
			$out .= '<li><em>Practice Type:</em> ' . $practice_type_label . '</li>';
			$out .= '<li><em>Building Type:</em> ' . get_field( 'building_type' ) . '</li>';
			$out .= '<li><em>Business:</em> ' . get_field( 'practice_is_for' ) . '</li>';
			$out .= '<li><em>Building:</em> ' . get_field( 'realestate_is_for' ) . '</li>';

			$valuvet_valuation = ( get_field( 'valuvet_valuation' ) ) ? 'Yes' : 'No';
			$out .= '<li><em>ValuVet Valuation:</em> ' . $valuvet_valuation . ' </li>';

			$valuvet_practice_report = ( get_field( 'valuvet_practice_report' ) ) ? 'Yes' : 'No';
			$out .= '<li><em>ValuVet Report:</em> ' . $valuvet_practice_report . ' </li>';

			$out .= '</ul>';

			return $out;
		}
		/**/

		/*-------------------------------------------------------------------------------
			TYPE OF PRACTICE
		-------------------------------------------------------------------------------*/

		/**/
		public static function property_type_of_practice() {

			$out = '<h4>Type of Practice</h4>';
			$out .= '<ul>';

			$practice_type       = get_field( 'practice_type' );
			$practice_type_label = ( $practice_type != 'other' )
				? $practice_type
				: get_field( 'other_type' );

			$out .= '<li><em>Practice Type:</em> ' . $practice_type_label . '</li>';

			$small_animal_treated       = get_field( 'small_animal_treated' );
			$equine_treated             = get_field( 'equine_treated' );
			$bovine_treated             = get_field( 'bovine_treated' );
			$other_treated              = get_field( 'other_treated' );
			$other_animals_treated_cont = get_field( 'other_animals_treated_cont' );


			if ( $small_animal_treated ) {
				$treated_small = get_field( 'small_animal_choices' );
				$small_choices = rtrim( implode( ', ', $treated_small ), ',' );
				$out .= '<li><em>' . $small_animal_treated . '&#37; - Small</em> &#40; ' . $small_choices . ' &#41;</li>';
			}

			if ( $equine_treated ) {
				$treated_equine = get_field( 'equine_choices' );
				$equine_choices = rtrim( implode( ', ', $treated_equine ), ',' );
				$out .= '<li><em>' . $equine_treated . '&#37; - Equine</em> &#40; ' . $equine_choices . ' &#41;</li>';
			}

			if ( $bovine_treated ) {
				$treated_bovine = get_field( 'bovine_choices' );
				$bovine_choices = rtrim( implode( ', ', $treated_bovine ), ',' );
				$out .= '<li><em>' . $bovine_treated . '&#37; - Bovine</em> &#40; ' . $bovine_choices . ' &#41;</li>';
			}

			if ( $other_treated ) {
				$out .= '<li><em>' . $other_treated . '&#37; - Other</em> &#40; ' . $other_animals_treated_cont . '&#41;</li>';
			}

			$out .= '</ul>';

			return $out;
		}
		/**/

		/*-------------------------------------------------------------------------------
			STAFF
		-------------------------------------------------------------------------------*/

		/**/
		public static function property_staff() {

			$full_time_vets       = get_field_object( 'full_time_vets' );
			$full_time_vets_value = get_field( 'full_time_vets' );
			$full_time_vets_label = $full_time_vets['choices'][ $full_time_vets_value ];

			$full_time_nurses = get_field( 'full_time_nurses' );

			$out = '<h4>Staff</h4>';

			$out .= '<ul>';

			$out .= '<li><em>Full-time Vets:</em> ' . $full_time_vets_label . '</li>';
			$out .= '<li><em>Full-Time Nurses:</em> ' . $full_time_nurses . '</li>';

			if ( get_field( 'practice_manager' ) == 'TRUE' ) {
				$out .= '<li><em>Practice Manager:</em> Yes </li>';
			} else {
				$out .= '<li><em>Practice Manager:</em> No </li>';
			}
			$out .= '</ul>';

			return $out;
		}
		/**/

		/*-------------------------------------------------------------------------------
			FACILITIES
		-------------------------------------------------------------------------------*/

		/**/
		public static function property_facilities() {

			$building_area      = get_field( 'building_area' );
			$branch_clinics     = get_field( 'branch_clinics' );
			$days_open          = get_field( 'days_open' );
			$kennels            = get_field( 'kennels' );
			$stables            = get_field( 'stables' );
			$off_street_parking = get_field( 'off_street_parking' );
			$car_spaces         = get_field( 'car_spaces' );

			$number_of_computer = get_field( 'number_of_computer' );

			$ownership       = get_field_object( 'ownership' );
			$ownership_value = get_field( 'ownership' );
			$ownership_label = $ownership['choices'][ $ownership_value ];


			$out = '<h4>Facilities</h4>';
			$out .= '<ul>';
			$out .= '<li><em>Building is:</em> ' . $ownership_label . '</li>';


			$realestate_is_for  = get_field( 'realestate_is_for' );
			$building_ownership = get_field( 'ownership' );

			if ( $realestate_is_for == 'for_lease' || $building_ownership == 'rented' ) {
				$real_estate_lease_details = get_field( 'real_estate_lease_details' );
				$out .= '<li><em>Building is for Lease:</em> ' . $real_estate_lease_details . '</li>';
			} else if ( $realestate_is_for == 'for_lease' || $building_ownership == 'owned' ) {
				$out .= '';
			}

			/**
			 * ACF
			 *
			 * Practice is for : practice_is_for  = For Sale || For Lease || For Sale/Lease
			 * Practice Lease Details : practice_lease_details
			 *
			 *
			 * Real Estate is for : realestate_is_for =  for_sale : For Sale ||  for_lease : For Lease
			 * Real Estate Lease Details : real_estate_lease_details
			 *
			 * Ownership:  ownership  = owned : Owned || rented : Rented
			 *
			 *
			 * COMBINATIONS
			 *
			 * if ownership == owned || realestate_is_for == for_lease
			 * Real Estate is 'owned'  - is not part of the sale - but can be 'leased' = real_estate_lease_details
			 *
			 * if ownership == rented || realestate_is_for == for_lease
			 * Real Estate is 'leased' the lease details are = real_estate_lease_details
			 *
			 * if ownership == owned || realestate_is_for == for_sale
			 * Real Estate is 'owned' and is for sale = property_realestate_value
			 *
			 * if ownership == rented || realestate_is_for == for_sale
			 * Real Estate is 'leased'  - real estate owner is open to selling  =  Lessor is open to selling
			 *
			 *
			 * if practice_is_for  == For Sale
			 * total_value or P.O.A.
			 *
			 *
			 * if practice_is_for  == For Lease
			 * practice_lease_details
			 *
			 * if practice_is_for  == For Sale/Lease
			 * total_value or P.O.A. || practice_lease_details
			 *
			 *
			 * /**/


			$out .= '<li><em>Building Area:</em> ' . $building_area . ' sqm</li>';

			$out .= '<li><em>Facilities Include:</em> ';
			if ( $kennels || $stables ) {
				$out .= 'Kennels, Stables';
			} else if ( $kennels || ! $stables ) {
				$out .= 'Kennels';
			} else if ( ! $kennels || $stables ) {
				$out .= 'Stables';
			}
			$out .= '</li>';

			if ( $off_street_parking ) {
				$out .= '<li><em>Car Parks:</em> ' . $car_spaces . '</li>';
			}


			/**
			 * if (get_field('practice_type') == 'other') {
			 * $other_type = get_field('other_type');
			 * $practice_type_label = $other_type;
			 * } else {
			 * $practice_type = get_field_object('practice_type');
			 * $practice_type_value = get_field('practice_type');
			 * $practice_type_label = $practice_type['choices'][$practice_type_value];
			 * }
			 *
			 *
			 * /**/

			if ( get_field( 'computer_software' ) == 'Other' ) {
				$other_software          = get_field( 'other_software' );
				$computer_software_label = $other_software;
			} else {
				$computer_software       = get_field_object( 'computer_software' );
				$computer_software_value = get_field( 'computer_software' );
				$computer_software_label = $computer_software['choices'][ $computer_software_value ];
			}

			$out .= '<li><em>Computer Software:</em> ' . $computer_software_label . '</li>';


			if ( $number_of_computer ) {
				$out .= '<li><em>No. Computers:</em> ' . $number_of_computer . '</li>';
			}


			$out .= '</ul>';

			return $out;
		}
		/**/

		/*-------------------------------------------------------------------------------
			PROFESSIONAL SERVICES
		-------------------------------------------------------------------------------*/

		/**/
		public static function property_services_professional() {

			$out                         = '';
			$professional_services       = get_field_object( 'professional_services' );
			$professional_services_value = $professional_services['value'];
			$other_professional_services = get_field( 'other_professional_services' );

			if ( $professional_services_value ) {
				$out .= '<h4>Professional Services</h4>';
				$out .= '<ul>';

				foreach ( $professional_services_value as $professional_service ) {
					$out .= '<li>' . $professional_service . '</li>';
				}
			}

			if ( $other_professional_services ) {
				$out .= '<li>' . $other_professional_services . '</li>';
			}
			$out .= '</ul>';

			return $out;
		}
		/**/

		/*-------------------------------------------------------------------------------
			ANCILLARY SERVICES
		-------------------------------------------------------------------------------*/

		/**/
		public static function property_services_ancillary() {

			$out                      = '';
			$ancillary_service_field  = get_field( 'ancillary_services' );
			$ancillary_services       = get_field_object( 'ancillary_services' );
			$ancillary_services_value = $ancillary_services['value'];
			$other_ancillary_services = get_field( 'other_ancillary_services' );

			if ( $ancillary_services_value ) {
				$out .= '<h4>Ancillary Services</h4>';
				$out .= '<ul>';

				foreach ( $ancillary_services_value as $ancillary_service ) {
					$out .= '<li>' . $ancillary_service . '</li>';
				}
			}

			if ( $other_ancillary_services ) {
				$out .= '<li>' . $other_ancillary_services . '</li>';
			}
			$out .= '</ul>';

			return $out;
		}
		/**/

		/*-------------------------------------------------------------------------------
			THE BUSINESS
		-------------------------------------------------------------------------------*/

		/**/
		public static function property_desc_business() {

			return get_field( 'business_description' );
		}
		/**/

		/*-------------------------------------------------------------------------------
			THE OPPORTUNITY
		-------------------------------------------------------------------------------*/

		/**/
		public static function property_desc_opportunity() {

			return get_field( 'business_opportunity' );
		}
		/**/

		/*-------------------------------------------------------------------------------
			THE LOCATION
		-------------------------------------------------------------------------------*/

		/**/
		public static function property_desc_location() {

			return get_field( 'business_location' );
		}
		/**/

	}

	VALUVET_SHORTCODES::register_shortcodes();
