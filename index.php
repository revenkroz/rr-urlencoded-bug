<?php

$data = file_get_contents('php://input');
$result = [];
parse_str($data, $result);

// OR

//$result = $_POST;

$filepath = __DIR__ . '/results/result_php.png';
file_put_contents($filepath, $result['attachments'][0]['data']);

echo json_encode([
    'file' => $filepath,
]) . PHP_EOL;
