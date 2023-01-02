<?php
/*
* Plugin Name: Customers Headless Plugin
* Plugin URI:
* Description: A plugin that allows customers to access their own orders and customer data using the WooCommerce REST API.
* Version: 1.0.0
* Author: Ben Parr
* Author URI:
* License: GPL2
*/

require_once plugin_dir_path( __FILE__ ) . 'functions.php';
require_once plugin_dir_path( __FILE__ ) . 'customer-functions.php';
require_once plugin_dir_path( __FILE__ ) . 'customer-rest-endpoints.php';

add_action( 'rest_api_init', 'custom_orders_endpoint' );
add_action( 'rest_api_init', 'custom_customer_endpoint' );
add_filter( 'jwt_auth_validate_token', 'customer_authentication', 10, 3 );

