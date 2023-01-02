# Customers Headless Plugin
This plugin allows customers to access their own orders and customer data using the WooCommerce REST API. This plugin also uses JWT tokens which are often obtained from the [JWT Authentication for WP-API](https://wordpress.org/plugins/jwt-authentication-for-wp-rest-api/) plugin.

## Installation
1. Download the plugin files and upload them to your WordPress site.
2. Activate the plugin from the Plugins menu in the WordPress admin dashboard.
3. Download and activate the [JWT Authentication for WP-API](https://wordpress.org/plugins/jwt-authentication-for-wp-rest-api/)

## Usage
To use the plugin, you must send a JWT token in the Authorization header of your request. The token must be signed with the secret key that you have configured in the plugin settings.

## Orders Endpoint
To access the orders endpoint, send a GET request to `/wp-json/wc/v3/orders/mine`. The response will contain an array of objects, each representing an order placed by the customer.

## Customer Endpoint
To access the customer endpoint, send a GET request to `/wp-json/wc/v3/customers/mine`. The response will contain an object with the customer's data, including their billing and shipping addresses.

## Support
If you have any issues with the plugin, please contact me for support.

## License 📜
License: GPL v2

- GPLv2