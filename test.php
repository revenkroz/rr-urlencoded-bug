<?php

$file = 'test.png';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'http://localhost:58080/');
//curl_setopt($ch, CURLOPT_URL, 'http://localhost:58080/php-server.php');
//curl_setopt($ch, CURLOPT_URL, 'http://localhost:3000/upload');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'attachments[0][name]' => 'test.png',
    'attachments[0][type]' => 'image/png',
    'attachments[0][data]' => file_get_contents($file),
    //'attachments[0][data]' => 'aa=1&bb=2&cc[0]=3&dd=1=2&e1=&&e2=e3=e4=e5'.PHP_EOL.'&12312\"\n\"&te=as&1=&===    &&=dsfdsf=ds=fsd=fsd=f=sdfdf&FSD',
], encoding_type: PHP_QUERY_RFC3986));

curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded; charset=UTF-8']);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

curl_close($ch);

echo $result;
