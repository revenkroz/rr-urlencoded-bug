<?php

//$data = file_get_contents('php://input');
//$result = [];
//parse_str($data, $result);

// OR

$result = $_POST;

file_put_contents('test_downloaded.png', $result['attachments'][0]['data']);

echo 'ok';
