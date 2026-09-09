<?php
require_once("core/vendor/autoload.php");

use GuzzleHttp\Psr7\Utils;

if(empty($_GET['url'])) die('error');

$client = new GuzzleHttp\Client();
$url = base64_decode($_GET['url']);

// Download the video as a stream
try {
    $response = $client->request('GET', $url, ['stream' => true]);
    $body = $response->getBody();
    $extension = explode('/', $response->getHeaderLine('Content-Type'))[1];

    header("Content-Type:application/octet-stream");
    header('Content-Disposition: attachment; filename="'.sprintf('Instagram.%s', $extension).'"');

    while (!$body->eof()) {
        echo Utils::readline($body);
        ob_flush();
        flush();
    }
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    http_response_code(403);
}