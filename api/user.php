<?php
header("Content-Type: application/json");

/**
 * @OA\Info(title="My PHP API", version="1.0")
 */

/**
 * @OA\Get(
 *     path="/api/user",
 *     summary="Get user details",
 *     @OA\Response(
 *         response=200,
 *         description="Successful response",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="name", type="string")
 *         )
 *     )
 * )
 */
function getUser() {
    echo json_encode(["id" => 1, "name" => "John Doe"]);
}

getUser();
