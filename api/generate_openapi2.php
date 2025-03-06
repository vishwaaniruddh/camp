<?php
$base_url = "http://localhost/camp/api";
$folders = ["bank"]; // Add more as needed

$openapi = [
    "openapi" => "3.0.0",
    "info" => [
        "title" => "My PHP API",
        "version" => "1.0.0",
        "description" => "Auto-generated API documentation"
    ],
    "servers" => [
        ["url" => $base_url, "description" => "Local Server"]
    ],
    "paths" => [],
    "tags" => []
];

// Function to detect HTTP method
function detectMethod($filePath) {
    $content = file_get_contents($filePath);
    if (strpos($content, '$_POST') !== false) return 'post';
    if (strpos($content, '$_GET') !== false) return 'get';
    if (strpos($content, '$_PUT') !== false) return 'put';
    if (strpos($content, '$_DELETE') !== false) return 'delete';
    return 'get'; // Default to GET if nothing is found
}

foreach ($folders as $folder) {
    $dir = __DIR__ . "/$folder/";

    $openapi["tags"][] = [
        "name" => $folder,
        "description" => "APIs related to $folder"
    ];

    if (is_dir($dir)) {
        foreach (scandir($dir) as $file) {
            if (strpos($file, ".php") !== false) {
                $route = "/$folder/" . basename($file);
                $method = detectMethod($dir . $file);

                $openapi["paths"][$route] = [
                    $method => [
                        "tags" => [$folder],
                        "summary" => "Auto-generated endpoint for $route",
                        "requestBody" => [
                            "required" => true,
                            "content" => [
                                "application/json" => [
                                    "schema" => [
                                        "type" => "object",
                                        "example" => ["param1" => "value1", "param2" => "value2"]
                                    ]
                                ]
                            ]
                        ],
                        "responses" => [
                            "200" => [
                                "description" => "Successful response",
                                "content" => [
                                    "application/json" => [
                                        "example" => ["message" => "Response from $route"]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ];
            }
        }
    }
}

file_put_contents(__DIR__ . "/../openapi.json", json_encode($openapi, JSON_PRETTY_PRINT));

echo "✅ OpenAPI JSON updated with correct HTTP methods!";
?>
