<?php

/**
 * ./endpoints.php
 * 
 * - $endPoints array contains a list of all endpoints being monitored
 * - $endPoints array can have 0 or more endpoints
 * - an endpoint MUST have base_url, method, content_type and data keys
 * 
 * --- base_url      >> the URL being pinged (string)
 * --- method        >> the request method (GET|POST)
 * --- content_type  >> the media type of the content being posted (null | application/x-www-form-urlencoded | application/json)
 * --- data          >> holds data to be posted (for POST requests) or query params to be used (for GET requests)
 * 
 */
$endPoints = [
    [
        // https://jsonplaceholder.typicode.com/comments?postId=1
        'base_url' => "https://jsonplaceholder.typicode.com/comments",
        'method' => 'GET',
        'content_type' => null,
        'data' => [
            "postId" => "1"
        ]
    ],
    [
        'base_url' => "https://example.com",
        'method' => 'POST',
        'content_type' => 'application/x-www-form-urlencoded',
        'data' => [
            "key1" => "value1",
            "key2" => "value2"
        ]
    ],
    [
        'base_url' => "https://example2.com/path",
        'method' => 'POST',
        'content_type' => 'application/json',
        'data' => [
            "key1" => "value1",
            "key2" => "value2"
        ]
    ],
];
echo 'running.. please wait...';
error_log(print_r($endPoints, true), 3, "/var/tmp/pricingAppDebug.log");
return $endPoints;
