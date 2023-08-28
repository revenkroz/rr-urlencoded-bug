<?php

require __DIR__ . '/vendor/autoload.php';

use Nyholm\Psr7\Response;
use Nyholm\Psr7\Factory\Psr17Factory;
use Spiral\RoadRunner\Worker;
use Spiral\RoadRunner\Http\PSR7Worker;

$worker = Worker::create();
$factory = new Psr17Factory();
$psr7 = new PSR7Worker($worker, $factory, $factory, $factory);

while (true) {
    try {
        $request = $psr7->waitRequest();
    } catch (\Throwable $e) {
        $psr7->respond(new Response(400));
        continue;
    }

    try {
        //$decodedBody = $request->getParsedBody();
        // OR
        $decodedBody = [];
        parse_str((string)$request->getBody(), $decodedBody);

        file_put_contents('test_downloaded.png', $decodedBody['attachments'][0]['data']);

        $psr7->respond(new Response(
            body: (string)$request->getBody(),
        ));
    } catch (\Throwable $e) {
        $psr7->respond(new Response(500, [], $e->getMessage()));
        $psr7->getWorker()->error((string)$e);
    }
}
