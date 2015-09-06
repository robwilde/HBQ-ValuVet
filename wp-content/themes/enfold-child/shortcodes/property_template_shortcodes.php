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
    public static function property_address ($atts) {
		extract( shortcode_atts( array(
		'post_id' => get_the_ID()
		), $atts ) );
        $out = '<h6>Business Name:</strong></h6>';
        $out .= '<p>' . get_field( 'practice_name') . '</p>';
        $out .= '<h6>Address:</h6>';
        $out .= '<p>' . get_field('address_street') . '<br/>';
        $out .=  get_field( 'address_city' ) . ', ' . get_field( 'address_state' ) . ' ' . get_field( 'address_postcode' ) . '</p>';       
        return $out;
     }
    /**/   

    /* PROPERTY OVERVIEW DESCRIPTION */

    /**/
    public static function property_overview_desc ($atts) {
		extract( shortcode_atts( array(
		'post_id' => get_the_ID()
		), $atts ) );
		


        $out = '<h6>Overview Description:</h6>';
        $out .= '<p>';
    
        $upgrade_option_one = get_field('upgrade_option_one');
        $upgrade_option_two = get_field('upgrade_option_two');
        $short_description_1 = get_field('short_description_1');
        $short_description_2 = get_field('short_description_2');
        
        /* check package upgrade level and display approprate shot desctiption */
       /**
       if ($upgrade_option_one) { 
        $short_description_1 = get_field('short_description_1');
        $out .= $short_description_1;
        } else if ($upgrade_option_two) {
        $short_description_2 = get_field('short_description_2');
        $out .= $short_description_2;
        }  
       /**/ 
        $out .= $short_description_1;              
        $out .= $short_description_2; 
        
        $out .= '</p>';
        
        return $out;
        }
    /**/


    /* PROPERTY PRICE */

    /**/
    public static function property_price ($atts) {
		extract( shortcode_atts( array(
		'post_id' => get_the_ID()
		), $atts ) );
		


		if (get_field('show_asking_price') == 'poa') {
		
		$out = '<h3 class="asking_price">P.O.A.</h3>';
		
		} else if (get_field('show_asking_price') == 'yes')  {
		
		$asking_price = get_field('total_value');
		$out = '<h3 class="asking_price"> $' . $asking_price . '</h3>';
		}
        
        return $out;
        }
    /**/

    /* PROPERTY OVERVIEW SNAPSHOT */

    /**/
    public static function property_snapshot ($atts) {
		extract( shortcode_atts( array(
		'post_id' => get_the_ID()
		), $atts ) );
		




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
		
		
		$full_time_vets = get_field_object('full_time_vets');
		$full_time_vets_value = get_field('full_time_vets');
		$full_time_vets_label = $full_time_vets['choices'][$full_time_vets_value];
		
		
		$full_time_nurses = get_field_object('full_time_nurses');   
		
		$out  = '<ul>';
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
		
		$out .= '<li><em>Full-time Vets:</em> ' . $full_time_vets_label . '</li>';
		$out .= '<li><em>Full-Time Nurses:</em> ' . $full_time_nurses. '</li>';
		
		if (get_field('practice_manager') == 'TRUE') {
		$out .= '<li><em>Practice Manager:</em> Yes </li>';
		} else {
		$out .= '<li><em>Practice Manager:</em> No </li>';
		}
		
		$out .= '</ul>';

        return $out;
        }
    /**/

    /* TYPE OF PRACTICE */

    /**/
    public static function property_type_of_practice ($atts) {

		extract( shortcode_atts( array(
		'post_id' => get_the_ID()
		), $atts ) );

	
		
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
		
		
		
		//$small_animal_choices = the_field('small_animal_choices', $post_id);

		


		if ($small_animal_treated){
		$out .= '<li><em>' . $small_animal_treated . '&#37;</em> &#40; choices here please  - For some reason the array is outputting to the top of the screen' . the_field('small_animal_choices') . '&#41;</li>';
		} else {
		$out .='';
		}

		if ($equine_treated){
		$out .= '<li><em>' . $equine_treated . '&#37;</em> &#40; choices here please  - For some reason the array is outputting to the top of the screen' . the_field('equine_choices') . '&#41;</li>';
		} else {
		$out .='';
		}
		
		if ($bovine_treated){
		$out .= '<li><em>' . $bovine_treated . '&#37;</em> &#40; choices here please  - For some reason the array is outputting to the top of the screen' . the_field('bovine_choices') . '&#41;</li>';
		} else {
		$out .='';
		}		
		
		if ($other_treated){
		$out .= '<li><em>' . $other_treated . '&#37;</em> &#40; choices here please  - For some reason the array is outputting to the top of the screen' . the_field('other_choices') . '&#41;</li>';
		
		   if ($other_animals_treated_cont) {
		   $out .= '<li><em>Other: </em>' . $other_animals_treated_cont . '</li>';
		   }
		
		} else {
		$out .='';
		}
        return $out;
        }
    /**/
    
    /* STAFF */
    
    /**/
    public static function property_staff ($atts) {
		extract( shortcode_atts( array(
		'post_id' => get_the_ID()
		), $atts ) );
		
		$out = '<h4>Staff</h4>';	
        return $out;
        }
    /**/

    /* FACILITIES */
    
    /**/
    public static function property_facilities ($atts) {
		extract( shortcode_atts( array(
		'post_id' => get_the_ID()
		), $atts ) );
		
		$out = '<h4>Facilities</h4>';
        return $out;
        }
    /**/

    /* PROFESSIONAL SERVICES */
    
    /**/
    public static function property_services_professional ($atts) {
		extract( shortcode_atts( array(
		'post_id' => get_the_ID()
		), $atts ) );
		
		$professional_services = get_field_object('professional_services');
		$professional_services_value = $professional_services['value'];
		$professional_services_choices = $professional_services['choices'];
		$other_professional_services = get_field('other_professional_services');

        if ( $professional_services_value ) {	        
		$out .= '<h4>Professional Services</h4>';		
		$out .= '<ul>';

		foreach ( $professional_services_value as $professional_service ) {
		$out .= '<li>' . $professional_services_choices[ $professional_service ] . '</li>';
		} 		
		}		
		
		if ( $other_professional_services ) {
		$out .='<li>' . $other_professional_services . '</li>';
		}             
		$out .= '</ul>';	
        return $out;        
        }
    /**/

    /* ANCILLARY SERVICES */

    /**/
    public static function property_services_ancillary ($atts) {
		extract( shortcode_atts( array(
		'post_id' => get_the_ID()
		), $atts ) );
				
        $ancillary_services = get_field_object('ancillary_services');
		$ancillary_services_value = $ancillary_services['value'];
		$ancillary_services_choices = $ancillary_services['choices'];
		$other_ancillary_services = get_field('other_ancillary_services');

        if ( $ancillary_services_value ) {	        
		$out .= '<h4>Ancillary Services</h4>';		
		$out .= '<ul>';

		foreach ( $ancillary_services_value as $ancillary_service ) {
		$out .= '<li>' . $ancillary_services_choices[ $ancillary_service ] . '</li>';
		} 		
		}		
		
		if ( $other_ancillary_services ) {
		$out .='<li>' . $other_ancillary_services . '</li>';
		}             
		$out .= '</ul>';	
        return $out;     
        }
    /**/
    
        /* THE BUSINESS */

    /**/
    public static function property_desc_business ($atts) {
		extract( shortcode_atts( array(
		'post_id' => get_the_ID()
		), $atts ) );
		
		$out = get_field('business_description');
        
        return $out;
        }
    /**/

        /* THE OPPORTUNITY */

    /**/
    public static function property_desc_opportunity ($atts) {
		extract( shortcode_atts( array(
		'post_id' => get_the_ID()
		), $atts ) );
		
		$out = get_field('business_opportunity');
        
        return $out;
        }
    /**/


        /* THE LOCATION */

    /**/
    public static function property_desc_location ($atts) {
		extract( shortcode_atts( array(
		'post_id' => get_the_ID()
		), $atts ) );
		
		$out = get_field('business_location');
        
        return $out;
        }
    /**/






    

}

VALUVET_SHORTCODES ::register_shortcodes();
