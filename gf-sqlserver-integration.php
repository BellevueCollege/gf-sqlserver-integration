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

//spl_autoload_register('gfsi_autoload');
require_once('config.php');
require_once( 'models/BaseModel.php' );
require_once( 'models/Transaction.php' );

//use Models\Transaction;
//use Models\BaseModel;

add_action('gform_post_payment_action', 'gfsi_process_submission', 10, 2);
//add_action('gform_after_submission', 'gfsi_process_submission', 10, 2);

function gfsi_process_submission($entry, $action) {

    /*echo '<pre>';
	var_dump($entry);
	echo '</pre>';*/
    GFCommon::log_debug( 'gform_post_payment_action: action =>' . print_r( $action, true ) );
    /*$list_data = unserialize(rgar( $entry, '8'));
    echo '<pre>';
    var_dump($list_data);
    echo '</pre>';*/

    $test = new BaseModel();
    echo '<pre>';
    var_dump($test->getDB());
    echo '</pre>';
    //$trans = new Transaction(1, 2, "Test", "Nicole" );
    //$this_entry = GFAPI::get_entry(rgar($entry, 'id'));
    //var_dump($this_entry);
    /*echo '<pre>';
    var_dump($form);
    echo '</pre>';*/
    //$entry = GFAPI::get_entry( $entry['id'] );
    GFCommon::log_debug( 'gform_post_payment_action: entry =>' . print_r( $entry, true ) );
    /*echo '<pre>';
    var_dump($entry);
    echo '</pre>';*/
}

/*function gfsi_autoload($class) 
{
    //see if the file exsists
    $class_path = "models/".$class.".php";
    echo $class_path;
    if(file_exists($class_path))
    {
        print_r($class);
        include($class_path);
        //only require the class once, so quit after to save effort (if you got more, then name them something else 
    }            
}*/