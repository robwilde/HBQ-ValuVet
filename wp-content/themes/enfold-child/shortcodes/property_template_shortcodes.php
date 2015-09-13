<?php

/**
 * Class VALUVET_SHORTCODES
 * Warranty Form Shortcode
 */
class VALUVET_SHORTCODES
{

    public static function register_shortcodes()
    {
        /* Add list of Shortcode here  - function is below */
        add_shortcode('property_address', array(__CLASS__, 'property_address'));
        add_shortcode('property_overview_desc', array(__CLASS__, 'property_overview_desc'));
        add_shortcode('property_price', array(__CLASS__, 'property_price'));
        add_shortcode('property_snapshot', array(__CLASS__, 'property_snapshot'));
        add_shortcode('property_type_of_practice', array(__CLASS__, 'property_type_of_practice'));
        add_shortcode('property_staff', array(__CLASS__, 'property_staff'));
        add_shortcode('property_facilities', array(__CLASS__, 'property_facilities'));
        add_shortcode('property_services_professional', array(__CLASS__, 'property_services_professional'));
        add_shortcode('property_services_ancillary', array(__CLASS__, 'property_services_ancillary'));
        add_shortcode('property_desc_business', array(__CLASS__, 'property_desc_business'));
        add_shortcode('property_desc_opportunity', array(__CLASS__, 'property_desc_opportunity'));
        add_shortcode('property_desc_location', array(__CLASS__, 'property_desc_location'));
    }
    /* add shortcode Function here */


    /* PROPERTY ADDRESS */

    /**/
    public static function property_address($atts)
    {
//		extract( shortcode_atts( array(
//		'post_id' => get_the_ID()
//		), $atts ) );

        $out = '<h6>Business Name:</strong></h6>';
        $out .= '<p>' . get_field('practice_name') . '</p>';
        $out .= '<h6>Address:</h6>';
        $out .= '<p>' . get_field('address_street') . '<br/>';
        $out .= get_field('address_city') . ', ' . get_field('address_state') . ' ' . get_field('address_postcode') . '</p>';
        return $out;
    }
    /**/

    /* PROPERTY OVERVIEW DESCRIPTION */

    /**/
    public static function property_overview_desc($atts)
    {
        extract(shortcode_atts(array(
            'post_id' => get_the_ID()
        ), $atts));


        $out = '<h6>Overview Description:</h6>';
        $out .= '<p>';

        $upgrade_option_one = get_field('upgrade_option_one');
        $upgrade_option_two = get_field('upgrade_option_two');
        $short_description_1 = get_field('short_description_1');
        $short_description_2 = get_field('short_description_2');

        /* check package upgrade level and display approprate shot desctiption */
        /**
         * if ($upgrade_option_one) {
         * $short_description_1 = get_field('short_description_1');
         * $out .= $short_description_1;
         * } else if ($upgrade_option_two) {
         * $short_description_2 = get_field('short_description_2');
         * $out .= $short_description_2;
         * }
         * /**/
        $out .= $short_description_1;
        $out .= $short_description_2;

        $out .= '</p>';

        return $out;
    }
    /**/


    /* PROPERTY PRICE */

    /**/
    public static function property_price($atts)
    {
        extract(shortcode_atts(array(
            'post_id' => get_the_ID()
        ), $atts));


        if (get_field('show_asking_price') == 'poa') {

            $out = '<h3 class="asking_price">P.O.A.</h3>';

        } else if (get_field('show_asking_price') == 'yes') {

            $asking_price = get_field('total_value');
            $out = '<h3 class="asking_price"> $' . $asking_price . '</h3>';
        }

        return $out;
    }
    /**/

    /* PROPERTY OVERVIEW SNAPSHOT */

    /**/
    public static function property_snapshot($atts)
    {
        extract(shortcode_atts(array(
            'post_id' => get_the_ID()
        ), $atts));


        if (get_field('practice_type') == 'other') {
            $other_type = get_field('other_type');
            $practice_type_label = $other_type;
        } else {
            $practice_type = get_field_object('practice_type');
            $practice_type_value = get_field('practice_type');
            $practice_type_label = $practice_type['choices'][$practice_type_value];
        }

        $building_type = get_field_object('building_type');
        $building_type_value = get_field('building_type');
        $building_type_label = $building_type['choices'][$building_type_value];

        $practice_is_for = get_field_object('practice_is_for');
        $practice_is_for_value = get_field('practice_is_for');
        $practice_is_for_label = $practice_is_for['choices'][$practice_is_for_value];

        $realestate_is_for = get_field_object('realestate_is_for');
        $realestate_is_for_value = get_field('realestate_is_for');
        $realestate_is_for_label = $realestate_is_for['choices'][$realestate_is_for_value];


        $out = '<ul>';
        $out .= '<li><em>Practice Type:</em> ' . $practice_type_label . '</li>';
        $out .= '<li><em>Building Type:</em> ' . $building_type_label . '</li>';
        $out .= '<li><em>Business:</em> ' . $practice_is_for_label . '</li>';
        $out .= '<li><em>Building:</em> ' . $realestate_is_for_label . '</li>';

        if (get_field('valuvet_valuation') == 'TRUE') {
            $out .= '<li><em>ValuVet Valuation:</em> Yes </li>';
        } else {
            $out .= '<li><em>ValuVet Valuation:</em> No </li>';
        }

        if (get_field('valuvet_practice_report') == 'TRUE') {
            $out .= '<li><em>ValuVet Report:</em> Yes </li>';
        } else {
            $out .= '<li><em>ValuVet Report:</em> No </li>';
        }

        $out .= '</ul>';

        return $out;
    }
    /**/

    /* TYPE OF PRACTICE */

    /**/
    public static function property_type_of_practice($atts)
    {

        //       global $post;

        extract(shortcode_atts(array(
            'post_id' => get_the_ID()
        ), $atts));


        $out = '<h4>Type of Practice</h4>';
        $out .= '<ul>';

        $practice_type = get_field_object('practice_type');
        $practice_type_value = get_field('practice_type');
        $practice_type_label = $practice_type['choices'][$practice_type_value];

        $out .= '<li><em>Practice Type:</em> ' . $practice_type_label . '</li>';

        $small_animal_treated = get_field('small_animal_treated');
        $equine_treated = get_field('equine_treated');
        $bovine_treated = get_field('bovine_treated');
        $other_treated = get_field('other_treated');
        $other_animals_treated_cont = get_field('other_animals_treated_cont');


        if ($small_animal_treated) {
            $treated_small = get_field('small_animal_choices');
            $small_choices = rtrim(implode(', ', $treated_small), ',');
            $out .= '<li><em>' . $small_animal_treated . '&#37; - Small</em> &#40; ' . $small_choices . ' &#41;</li>';
        }

        if ($equine_treated) {
            $treated_equine = get_field('equine_choices');
            $equine_choices = rtrim(implode(', ', $treated_equine), ',');
            $out .= '<li><em>' . $equine_treated . '&#37; - Equine</em> &#40; ' . $equine_choices . ' &#41;</li>';
        }

        if ($bovine_treated) {
            $treated_bovine = get_field('bovine_choices');
            $bovine_choices = rtrim(implode(', ', $treated_bovine), ',');
            $out .= '<li><em>' . $bovine_treated . '&#37; - Bovine</em> &#40; ' . $bovine_choices . ' &#41;</li>';
        }

        if ($other_treated) {
            $out .= '<li><em>' . $other_treated . '&#37; - Other</em> &#40; ' . $other_animals_treated_cont . '&#41;</li>';
        }

        $out .= '</ul>';

        return $out;
    }
    /**/

    /* STAFF */

    /**/
    public static function property_staff($atts)
    {
        extract(shortcode_atts(array(
            'post_id' => get_the_ID()
        ), $atts));

        $full_time_vets = get_field_object('full_time_vets');
        $full_time_vets_value = get_field('full_time_vets');
        $full_time_vets_label = $full_time_vets['choices'][$full_time_vets_value];

        $full_time_nurses = get_field('full_time_nurses');

        $out = '<h4>Staff</h4>';

        $out .= '<ul>';

        $out .= '<li><em>Full-time Vets:</em> ' . $full_time_vets_label . '</li>';
        $out .= '<li><em>Full-Time Nurses:</em> ' . $full_time_nurses . '</li>';

        if (get_field('practice_manager') == 'TRUE') {
            $out .= '<li><em>Practice Manager:</em> Yes </li>';
        } else {
            $out .= '<li><em>Practice Manager:</em> No </li>';
        }
        $out .= '</ul>';

        return $out;
    }
    /**/

    /* FACILITIES */

    /**/
    public static function property_facilities($atts)
    {
        extract(shortcode_atts(array(
            'post_id' => get_the_ID()
        ), $atts));


        $building_area = get_field('building_area');
        $branch_clinics = get_field('branch_clinics');
        $days_open = get_field('days_open');
        $kennels = get_field('kennels');
        $stables = get_field('stables');
        $off_street_parking = get_field('off_street_parking');
        $car_spaces = get_field('car_spaces');

        $number_of_computer = get_field('number_of_computer');

        $ownership = get_field_object('ownership');
        $ownership_value = get_field('ownership');
        $ownership_label = $ownership['choices'][$ownership_value];


        $out = '<h4>Facilities</h4>';
        $out .= '<ul>';
        $out .= '<li><em>Building is:</em> ' . $ownership_label . '</li>';


        $realestate_is_for = get_field('realestate_is_for');
        $building_ownership = get_field('ownership');

        if ($realestate_is_for == 'for_lease' || $building_ownership == 'rented') {
            $real_estate_lease_details = get_field('real_estate_lease_details');
            $out .= '<li><em>Building is for Lease:</em> ' . $real_estate_lease_details . '</li>';
        } else if ($realestate_is_for == 'for_lease' || $building_ownership == 'owned') {
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
        if ($kennels || $stables) {
            $out .= 'Kennels, Stables';
        } else if ($kennels || !$stables) {
            $out .= 'Kennels';
        } else if (!$kennels || $stables) {
            $out .= 'Stables';
        }
        $out .= '</li>';

        if ($off_street_parking) {
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

        if (get_field('computer_software') == 'Other') {
            $other_software = get_field('other_software');
            $computer_software_label = $other_software;
        } else {
            $computer_software = get_field_object('computer_software');
            $computer_software_value = get_field('computer_software');
            $computer_software_label = $computer_software['choices'][$computer_software_value];
        }

        $out .= '<li><em>Computer Software:</em> ' . $computer_software_label . '</li>';


        if ($number_of_computer) {
            $out .= '<li><em>No. Computers:</em> ' . $number_of_computer . '</li>';
        }


        $out .= '</ul>';

        return $out;
    }
    /**/

    /* PROFESSIONAL SERVICES */

    /**/
    public static function property_services_professional($atts)
    {
        extract(shortcode_atts(array(
            'post_id' => get_the_ID()
        ), $atts));

        $professional_services = get_field_object('professional_services');
        $professional_services_value = $professional_services['value'];
        $professional_services_choices = $professional_services['choices'];
        $other_professional_services = get_field('other_professional_services');

        if ($professional_services_value) {
            $out .= '<h4>Professional Services</h4>';
            $out .= '<ul>';

            foreach ($professional_services_value as $professional_service) {
                $out .= '<li>' . $professional_services_choices[$professional_service] . '</li>';
            }
        }

        if ($other_professional_services) {
            $out .= '<li>' . $other_professional_services . '</li>';
        }
        $out .= '</ul>';
        return $out;
    }
    /**/

    /* ANCILLARY SERVICES */

    /**/
    public static function property_services_ancillary($atts)
    {
        extract(shortcode_atts(array(
            'post_id' => get_the_ID()
        ), $atts));

        $ancillary_services = get_field_object('ancillary_services');
        $ancillary_services_value = $ancillary_services['value'];
        $ancillary_services_choices = $ancillary_services['choices'];
        $other_ancillary_services = get_field('other_ancillary_services');

        if ($ancillary_services_value) {
            $out .= '<h4>Ancillary Services</h4>';
            $out .= '<ul>';

            foreach ($ancillary_services_value as $ancillary_service) {
                $out .= '<li>' . $ancillary_services_choices[$ancillary_service] . '</li>';
            }
        }

        if ($other_ancillary_services) {
            $out .= '<li>' . $other_ancillary_services . '</li>';
        }
        $out .= '</ul>';
        return $out;
    }
    /**/

    /* THE BUSINESS */

    /**/
    public static function property_desc_business($atts)
    {
        extract(shortcode_atts(array(
            'post_id' => get_the_ID()
        ), $atts));

        $out = get_field('business_description');

        return $out;
    }
    /**/

    /* THE OPPORTUNITY */

    /**/
    public static function property_desc_opportunity($atts)
    {
        extract(shortcode_atts(array(
            'post_id' => get_the_ID()
        ), $atts));

        $out = get_field('business_opportunity');

        return $out;
    }
    /**/


    /* THE LOCATION */

    /**/
    public static function property_desc_location($atts)
    {

        $out = get_field('business_location');

        return $out;
    }
    /**/

}

VALUVET_SHORTCODES::register_shortcodes();
