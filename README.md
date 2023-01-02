﻿# Customers Headless Plugin
 
 This plugin is used to fetch the customer data assosiated with the authenticated user.
 
 The user is authenticated by passing in the JWT token in as a bearer token with the new rest endpoints added:
 
 `/orders/mine`
 `/customer/mine`
 
 
 An example customer response looks like:
 
 ```
 {
    "customer_id": 507,
    "first_name": "ben",
    "last_name": "parr",
    "email": "email@test.com",
    "billing_address": {
        "first_name": "ben",
        "last_name": "parr",
        "company": "",
        "address_1": "xxx",
        "address_2": "xxx",
        "city": "xxx",
        "state": "Please Select",
        "postcode": "xxxx",
        "country": "",
        "email": "email@test.com",
        "phone": ""
    },
    "shipping_address": {
        "first_name": "ben",
        "last_name": "parr",
        "company": "",
        "address_1": "xxx",
        "address_2": "xxx",
        "city": "xxx",
        "state": "Please Select",
        "postcode": "xxx",
        "country": ""
    }
}
 
 
 ```
