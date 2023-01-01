<?php
/*
* Plugin Name: Customers Headless Plugin
* Plugin URI:
* Description: A plugin that allows customers to access their own orders using the WooCommerce REST API.
* Version: 1.0.0
* Author: Ben Parr
* Author URI:
* License: GPL2
*/

function custom_orders_endpoint() {
    register_rest_route( 'wc/v3', '/orders/mine', array(
        'methods' => 'GET',
        'callback' => 'custom_orders_callback',
    ) );
}
add_action( 'rest_api_init', 'custom_orders_endpoint' );

function custom_orders_callback( $request ) {
    // Get the current user ID
    $user_id = get_current_user_id();
    if ( ! $user_id ) {
        return new WP_Error( 'rest_not_logged_in', __( 'You are not currently logged in.' ), array( 'status' => 401 ) );
    }

    // Get the orders for the current user
    $orders = wc_get_orders( array( 'customer' => $user_id ) );
    if ( empty( $orders ) ) {
        return new WP_Error( 'rest_no_orders_found', __( 'No orders were found for the current user.' ), array( 'status' => 404 ) );
    }

    // Return the orders in the response
    return $orders;
}

function custom_orders_authentication( $user, $token, $auth_data ) {
    // Validate the JWT token
    try {
        // Decode the token and get the user data
        $decoded_token = JWT::decode( $token, SECRET_KEY, array( 'HS256' ) );
        $user_id = $decoded_token->data->user->id;
    } catch ( Exception $e ) {
        // Return an error if the token is not valid
        return new WP_Error( 'rest_invalid_token', __( 'Invalid JWT token.' ), array( 'status' => 401 ) );
    }

    // Check if the user exists
    $user = get_user_by( 'id', $user_id );
    if ( ! $user ) {
        return new WP_Error( 'rest_user_invalid', __( 'Invalid user.' ), array( 'status' => 401 ) );
    }

    // Return the user object
    return $user;
}
add_filter( 'jwt_auth_validate_token', 'custom_orders_authentication', 10, 3 );