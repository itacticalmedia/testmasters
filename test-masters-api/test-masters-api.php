<?php
/*
Plugin Name: Test Masters API
Plugin URI: http://www.testmasters.net/
Description: Plugin for fetching states and cities information with API
Version: 1.0
Author: Test Masters
Author URI: http://www.testmasters.net/
License: GPL2
*/

include 'admin/functions.php'; // add functions file for backend

include 'frontend/functions.php'; // add functions file for frontend


function test_masters_api_include_style() { // enqueue plugin style

    $my_style_url = WP_PLUGIN_URL . '/test-masters-api/css/style.css';
	wp_enqueue_style('test-masters-api-style', $my_style_url);
	
}
add_action('wp_enqueue_scripts', 'test_masters_api_include_style');
