<?php

function kegthat_customer_endpoint() {
    register_rest_route( 'wc/v3', '/customer/mine', array(
        'methods' => 'GET',
        'callback' => 'kegthat_customer_callback',
    ) );
}

function kegthat_orders_endpoint() {
    register_rest_route( 'wc/v3', '/orders/mine', array(
        'methods' => 'GET',
        'callback' => 'kegthat_orders_callback',
    ) );
}

function kegthat_order_endpoint() {
    register_rest_route( 'wc/v3', '/orders/mine/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'kegthat_order_callback',
    ) );
}