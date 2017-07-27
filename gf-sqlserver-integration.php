<?php
/*
Plugin Name: Gravity Forms SQL Server Data Integration for Bellevue College
Plugin URI: https://github.com/BellevueCollege/gf-sqlserver-integration
Description: Moves Gravity Forms data to SQL Server for defined models
Author: Bellevue College Integration Team
Version: 1.7
Author URI: http://www.bellevuecollege.edu
GitHub Plugin URI: bellevuecollege/gf-sqlserver-integration
*/

defined ( 'ABSPATH' ) OR exit;

file_exists(plugin_dir_path(__FILE__).'/config.php') ? require_once('config.php') : die("For Plugin gf-sqlserver-integration :: Config file is missing");
require_once( 'classes/Transaction.php' );
require_once( 'classes/AppliedAccounting_BAS.php');
require_once( 'classes/ComputerScience_BS.php' );
require_once( 'classes/DataAnalytics_BAS.php' );
require_once( 'classes/HealthcareInformatics_BAS.php' );
require_once( 'classes/HealthcareManagement_BAS.php' );
require_once( 'classes/HealthcarePromotion_BAS.php' );
require_once( 'classes/InteriorDesign_BA.php' );
require_once( 'classes/IST_BAS.php' );
require_once( 'classes/MolecularBiosciences_BAS.php' );
require_once( 'classes/Nursing_RN_BSN.php' );
require_once( 'classes/RadiationImaging_BAS.php' );
require_once( 'classes/RadiationTherapyProgram_AA.php' );
require_once( 'classes/TechPrepPayment.php' );
require_once( 'classes/HealthCareInformaticsCertificate.php' );
require_once( 'classes/RadiologicTechnologyProgram_AA.php' );
require_once( 'classes/HealthCareDataAnalyticsCertificate.php' );
require_once( 'classes/DigitalMarketing_BAS.php');
require_once( 'classes/ASNConference.php');

//Remove Amex from accepted card types
add_filter("gform_creditcard_types", "remove_amex");
function remove_amex($cards){
    unset($cards[0]); // Removes AMEX from the list.
    return $cards;
}


//attach processing to post payment action
add_action('gform_post_payment_action', 'gfsi_process_submission', 10, 2);

//process post submission, handle case when no payment.
add_action( 'gform_after_submission', 'gfsi_after_submission', 10, 2 );

//add settings submenu page to form settings
add_filter('gform_form_settings_menu', 'gfsi_add_custom_form_settings_menu_item');

//set content for custom settings menu page
add_action('gform_form_settings_page_gfsi_custom_form_settings_page', 'gfsi_custom_form_settings_page' );

//process form submission
function gfsi_process_submission($entry, $action) {
    GFCommon::log_debug( 'gform_post_payment_action: action =>' . print_r( $action, true ) );

    // Get form info so we can get the model type assigned to it 
    $this_form = GFAPI::get_form(rgar($entry, 'form_id'));  
    $model_type = rgar($this_form, 'gfsi_model');
    //Instantiate model based on the model type set for the form
    $model = null;
    switch ($model_type) {
        case 'InteriorDesign_BA':
            $model = new InteriorDesign_BA();
            break;
        case 'IST_BAS':
            $model = new IST_BAS();
            break;
        case 'DataAnalytics_BAS':
            $model = new DataAnalytics_BAS();
            break;
        case 'AppliedAccounting_BAS':
            $model = new AppliedAccounting_BAS();
            break;
        case 'HealthcareInformatics_BAS':
            $model = new HealthcareInformatics_BAS();
            break;
        case 'HealthcarePromotion_BAS':
            $model = new HealthcarePromotion_BAS();
            break;
        case 'HealthcareManagement_BAS':
            $model = new HealthcareManagement_BAS();
            break;
        case 'RadiationImaging_BAS':           
            $model = new RadiationImaging_BAS();
            break;
        case 'MolecularBiosciences_BAS':
            $model = new MolecularBiosciences_BAS();
            break;
        case 'Nursing_RN_BSN':
            $model = new Nursing_RN_BSN();
            break;
        case 'ComputerScience_BS':
            $model = new ComputerScience_BS();
            break;
        case 'TechPrepPayment':
            $model = new TechPrepPayment();
            break;
        case 'HealthCareInformaticsCertificate':
            $model = new HealthCareInformaticsCertificate();
            break;
        case 'RadiationTherapyProgram_AA':
            $model = new RadiationTherapyProgram_AA();
            break;
        case 'RadiologicTechnologyProgram_AA':
            $model = new RadiologicTechnologyProgram_AA();
            break;
        case 'HealthCareDataAnalyticsCertificate':
            //error_log("Hello");
            $model = new HealthCareDataAnalyticsCertificate();
            break;
        case 'DigitalMarketing_BAS':
            $model = new DigitalMarketing_BAS();
            break;
//        case 'ASNConference':
//            error_log("Hello *********************************************");
//            $model = new ConferenceRegistration();
//            break;
        default:
            break;
    }

    //If defined, build the chosen model from the form entry data
    try {
        if ( !empty($model) ) {
            $model->build($entry);            
            $model->save();
           /*echo '<pre>';
            var_dump($model);
            echo '</pre>';*/
        } else {
            throw new Exception("Model is empty, likely no data model set for form " . $this_form["title"]);
        } 
    } catch ( Exception $e ) {
        error_log( print_r("GF SQL Server Integration plugin :: error building and saving model - " . $e->getMessage(), true) );
    }

    GFCommon::log_debug( 'gform_post_payment_action: entry =>' . print_r( $entry, true ) );
}

function gfsi_after_submission($entry,$form)
{
    // Get form info so we can get the model type assigned to it 
    $this_form = GFAPI::get_form(rgar($entry, 'form_id'));  
    $model_type = rgar($this_form, 'gfsi_model');
    
    //Instantiate model based on the model type set for the form
    $model = null;
    switch ($model_type) {
       case 'ASNConference':
            $model = new ASNConference();
            break;
        default:
            break; 
    }
    //If defined, build the chosen model from the form entry data
    try {
        if ( !empty($model) ) {
            $model->build($entry);
            //var_dump($model);
            $model->save();
           /*echo '<pre>';
            var_dump($model);
            echo '</pre>';*/
        } else {
            throw new Exception("After submission : Model is empty, likely no data model set for form " . $this_form["title"]);
        } 
    } catch ( Exception $e ) {
        error_log( print_r("GF SQL Server Integration plugin :: After submission : error building and saving model - " . $e->getMessage(), true) );
    }
}

// add a custom menu item to the Form Settings page menu
function gfsi_add_custom_form_settings_menu_item( $menu_items ) {
    
    $menu_items[] = array(
        'name' => 'gfsi_custom_form_settings_page',
        'label' => __( 'BC SQL Server Data Integration' )
        );
    
    return $menu_items;
}

// handle displaying content for our custom menu when selected
function gfsi_custom_form_settings_page() {

    //only provide our menu item if person has appropriate permissions    
    if ( current_user_can('manage_options') ) {
        $form_id = isset( $_GET['id'] ) ? $_GET['id'] : null;
        if ( $form = GFFormsModel::get_form_meta( $form_id ) ) {

            GFFormSettings::page_header();
        
            include dirname( __FILE__ ) . '/content/sqlserver-integration-menu-page.php';

            GFFormSettings::page_footer();

        }
    } else {
        echo __("You do not have the correct permissions to update this setting.");
    }
    
}
