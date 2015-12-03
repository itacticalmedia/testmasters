<?php

function admin_api_settings_function() // admin menu page
{
    add_menu_page( 'Test Master', 'Test Master', 'manage_options', 'test-masters-api', 'admin_api_settings_page_function', 'dashicons-admin-network', 82 );
}
add_action( 'admin_menu', 'admin_api_settings_function' );

function admin_api_settings_page_function() // callback function
{
    require_once("admin_api_settings.php");
}
