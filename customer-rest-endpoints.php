<?php

function custom_customer_endpoint() {
    register_rest_route( 'wc/v3', '/customer/mine', array(
        'methods' => 'GET',
        'callback' => 'custom_customer_callback',
    ) );
}

function custom_orders_endpoint() {
    register_rest_route( 'wc/v3', '/orders/mine', array(
        'methods' => 'GET',
        'callback' => 'custom_orders_callback',
    ) );
}