<?php

return [
    "base_url" => "http://localhost/camp/api",

    "apis" => [

        [
            "group" => "Banks",
            "endpoints" => [
                [
                    "url" => "/bank/add-bank.php",
                    "method" => "POST",
                    "requestBody" => [
                        "description" => "Bank details",
                        "required" => true,
                        "content" => [
                            "application/json" => [
                                "schema" => [
                                    "type" => "object",
                                    "properties" => [
                                        "name" => [
                                            "type" => "string",
                                            "description" => "Bank Name",
                                            "example" => "Bank of PHP"
                                        ]
                                    ],
                                    "required" => ["name"]
                                ]
                            ]
                        ]
                    ],
                    "description" => "Add Banks"
                ],
                [
                    "url" => "/bank/fetch-banks.php",
                    "method" => "GET",
                    "parameters" => [],
                    "description" => "Fetch all Banks"
                ],
            ]
        ],

    ]
];
