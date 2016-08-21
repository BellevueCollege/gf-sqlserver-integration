<?php
/*
Plugin Name: Gravity Forms SQL Server Data Integration for Bellevue College
Plugin URI: https://github.com/BellevueCollege/gf-sqlserver-integration
Description: Moves Gravity Forms data to SQL Server for defined models
Author: Bellevue College Integration Team
Version: 0.0.1
Author URI: http://www.bellevuecollege.edu
GitHub Plugin URI: bellevuecollege/gf-sqlserver-integration
*/

defined ( 'ABSPATH' ) OR exit;

require_once('config.php');
require_once( 'classes/Transaction.php' );
require_once( 'classes/AppliedAccounting_BAS.php');
require_once( 'classes/DataAnalytics_BAS.php' );
require_once( 'classes/InteriorDesignBA.php' );
require_once( 'classes/IST_BAS.php' );

//attach processing to post payment action
add_action('gform_post_payment_action', 'gfsi_process_submission', 10, 2);

//add settings submenu page to form settings
add_filter('gform_form_settings_menu', 'gfsi_add_custom_form_settings_menu_item');

//set content for custom settings menu page
add_action('gform_form_settings_page_gfsi_custom_form_settings_page', 'gfsi_custom_form_settings_page' );

//save custom setting
//add_filter('gform_form_settings_before_save', 'gfsi_save_custom_form_setting');
//add_action('gform_after_submission', 'gfsi_process_submission', 10, 2);

function gfsi_process_submission($entry, $action) {

    /*echo '<pre>';
	var_dump($entry);
	echo '</pre>';*/
    GFCommon::log_debug( 'gform_post_payment_action: action =>' . print_r( $action, true ) );
    $this_form = GFAPI::get_form(rgar($entry, 'form_id'));
    $model_type = rgar($this_form, 'gfsi_model');

    $model = null;
    switch ($model_type) {
        case 'InteriorDesignBA':
            $model = new InteriorDesignBA();
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
        default:
            # code...
            break;
    }

    try {
        $model->build($entry);
        $model->save();
        echo '<pre>';
        var_dump($model);
        echo '</pre>';
    } catch (Exception $e) {
        //some sort of datab
    }
    /*$list_data = unserialize(rgar( $entry, '8'));
    echo '<pre>';
    var_dump($list_data);
    echo '</pre>';*/

    GFCommon::log_debug( 'gform_post_payment_action: entry =>' . print_r( $entry, true ) );
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
    
    if ( current_user_can('manage_site') ) {
        $form_id = isset( $_GET['id'] ) ? $_GET['id'] : null;
        if ( $form = GFFormsModel::get_form_meta( $form_id ) ) {
            //echo '<pre>'; var_dump($form); echo '</pre>';
            GFFormSettings::page_header();
        
            include dirname( __FILE__ ) . '/content/sqlserver-integration-menu-page.php';

            GFFormSettings::page_footer();

        }
    } else {
        echo __("You do not have the correct permissions to update this setting.");
    }
    
}