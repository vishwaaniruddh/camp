<?php

return [
    "base_url" => "http://localhost/camp/api",

    "apis" => [

        [
            "group" => "Banks",
            "endpoints" => [
                [
                    "url" => "/bank/fetch-banks.php",
                    "method" => "GET",
                    "parameters" => [],
                    "description" => "Fetch all Banks"
                ],
                [
                    "url" => "/customer-purchase-order/create-purchase-order.php",
                    "method" => "POST",
                    "parameters" => [
                        ["name" => "customer_id", "type" => "integer", "required" => true, "description" => "Customer ID"],
                        ["name" => "order_items", "type" => "array", "required" => true, "description" => "List of items"]
                    ],
                    "description" => "Create a new purchase order"
                ]
            ]
        ],

        [
            "group" => "Customer Purchase Order",
            "endpoints" => [
                [
                    "url" => "/customer-purchase-order/fetch-customer-purchase-orders.php",
                    "method" => "GET",
                    "parameters" => [
                        ["name" => "customer_id", "type" => "integer", "required" => true, "description" => "Customer ID"]
                    ],
                    "description" => "Fetch all customer purchase orders"
                ],
                [
                    "url" => "/customer-purchase-order/create-purchase-order.php",
                    "method" => "POST",
                    "parameters" => [
                        ["name" => "customer_id", "type" => "integer", "required" => true, "description" => "Customer ID"],
                        ["name" => "order_items", "type" => "array", "required" => true, "description" => "List of items"]
                    ],
                    "description" => "Create a new purchase order"
                ]
            ]
        ],
        [
            "group" => "Inventory",
            "endpoints" => [
                [
                    "url" => "/inventory/get-stock.php",
                    "method" => "GET",
                    "parameters" => [],
                    "description" => "Get stock details"
                ],
                [
                    "url" => "/inventory/update-stock.php",
                    "method" => "POST",
                    "parameters" => [
                        ["name" => "item_id", "type" => "integer", "required" => true, "description" => "Item ID"],
                        ["name" => "quantity", "type" => "integer", "required" => true, "description" => "New stock quantity"]
                    ],
                    "description" => "Update stock"
                ]
            ]
        ]
    ]
];
