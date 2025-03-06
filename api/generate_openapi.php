<?php

$apiData = include("api_documentation.php");

$openapi = [
    "openapi" => "3.0.0",
    "info" => [
        "title" => "My PHP API",
        "version" => "1.0.0",
        "description" => "API documentation"
    ],
    "servers" => [
        ["url" => $apiData["base_url"], "description" => "Local Server"]
    ],
    "paths" => [],
    "tags" => []
];

foreach ($apiData["apis"] as $group) {
    $groupName = $group["group"];

    $openapi["tags"][] = [
        "name" => $groupName,
        "description" => "APIs related to $groupName"
    ];

    foreach ($group["endpoints"] as $api) {
        $method = strtolower($api["method"]);
        $path = str_replace(".php", ".php", $api["url"]); // Remove .php extension

        $parameters = [];
        foreach ($api["parameters"] as $param) {
            $parameters[] = [
                "name" => $param["name"],
                "in" => $method === "get" ? "query" : "body",
                "required" => $param["required"],
                "schema" => ["type" => $param["type"]],
                "description" => $param["description"]
            ];
        }

        $openapi["paths"][$path][$method] = [
            "tags" => [$groupName],
            "summary" => $api["description"],
            "parameters" => $parameters,
            "responses" => [
                "200" => [
                    "description" => "Successful response",
                    "content" => [
                        "application/json" => [
                            "example" => ["message" => "Response from $path"]
                        ]
                    ]
                ]
            ]
        ];
    }
}

file_put_contents("openapi.json", json_encode($openapi, JSON_PRETTY_PRINT));

echo "✅ OpenAPI JSON updated!";
?>
