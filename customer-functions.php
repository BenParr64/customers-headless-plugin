<?php

function kegthat_orders_callback( $request ) {
    // Get the current user ID
    $user_id = get_current_user_id();
    if ( ! $user_id ) {
        return new WP_Error( 'rest_not_logged_in', __( 'You are not currently logged in.' ), array( 'status' => 401 ) );
    }

    // Get the orders for the current user
    $orders = wc_get_orders( array( 'customer_id' => $user_id ) );

    if ( empty( $orders ) ) {
        $orders = array();
    }

    // Initialize the response array
    $response = array();

    // Loop through the orders and add the order data to the response array
    foreach ( $orders as $order ) {
        $response[] = array(
            'order_id' => $order->get_id(),
            'order_total' => $order->get_total(),
            'line_items' => $order->get_items(),
            'order_date' => $order->get_date_created(),
        );
    }

    // Return the response array
    return $response;
}

function kegthat_customer_callback( $request ) {
    // Get the current user ID
    $user_id = get_current_user_id();
    if ( ! $user_id ) {
        return new WP_Error( 'rest_not_logged_in', __( 'You are not currently logged in.' ), array( 'status' => 401 ) );
    }

    // Get the customer data for the current user
    $customer = new WC_Customer( $user_id );

    // Return the customer data in the response
    return array(
        'customer_id' => $customer->get_id(),
        'first_name' => $customer->get_first_name(),
        'last_name' => $customer->get_last_name(),
        'email' => $customer->get_email(),
        'billing_address' => array(
            'first_name' => $customer->get_billing_first_name(),
            'last_name' => $customer->get_billing_last_name(),
            'company' => $customer->get_billing_company(),
            'address_1' => $customer->get_billing_address_1(),
            'address_2' => $customer->get_billing_address_2(),
            'city' => $customer->get_billing_city(),
            'state' => $customer->get_billing_state(),
            'postcode' => $customer->get_billing_postcode(),
            'country' => $customer->get_billing_country(),
            'email' => $customer->get_billing_email(),
            'phone' => $customer->get_billing_phone(),
        ),
        'shipping_address' => array(
            'first_name' => $customer->get_shipping_first_name(),
            'last_name' => $customer->get_shipping_last_name(),
            'company' => $customer->get_shipping_company(),
            'address_1' => $customer->get_shipping_address_1(),
            'address_2' => $customer->get_shipping_address_2(),
            'city' => $customer->get_shipping_city(),
            'state' => $customer->get_shipping_state(),
            'postcode' => $customer->get_shipping_postcode(),
            'country' => $customer->get_shipping_country(),
        ),
    );
}

function kegthat_order_callback( WP_REST_Request $request ) {
    // Get the current user ID
    $user_id = get_current_user_id();
    if ( ! $user_id ) {
        return new WP_Error( 'rest_not_logged_in', __( 'You are not currently logged in.' ), array( 'status' => 401 ) );
    }

    // Get the order ID from the request
    $order_id = $request['id'];

    // Get the order
    $order = wc_get_order( $order_id );
    if ( ! $order ) {
        return new WP_Error( 'invalid_order', 'Invalid order', array( 'status' => 404 ) );
    }

    // Make sure the order belongs to the current user
    if ( $order->get_customer_id() !== $user_id ) {
        return new WP_Error( 'unauthorized_order', 'Unauthorized order', array( 'status' => 401 ) );
    }

    $response = array(
        'order_id' => $order->get_id(),
        'order_total' => $order->get_total(),
        'line_items' => $order->get_items(),
        'order_date' => $order->get_date_created(),
    );
    
    return $response;
    
}

function kegthat_authentication( $user, $token, $auth_data ) {
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
