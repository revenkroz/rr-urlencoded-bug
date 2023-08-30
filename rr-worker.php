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
        // case when raw_body: true
        $decodedBody = $request->getParsedBody();
        if (null !== $decodedBody) {
            $filename = __DIR__ . '/results/result_raw_body_false.png';
        } else {
            // case when raw_body: false
            $decodedBody = [];
            parse_str((string)$request->getBody(), $decodedBody);

            $filename = __DIR__ . '/results/result_raw_body_true.png';
        }

        file_put_contents($filename, $decodedBody['attachments'][0]['data']);

        $psr7->respond(new Response(
            body: json_encode([
                'file' => $filename,
            ], JSON_THROW_ON_ERROR) . PHP_EOL,
        ));
    } catch (\Throwable $e) {
        $psr7->respond(new Response(500, [], $e->getMessage()));
        $psr7->getWorker()->error((string)$e);
    }
}
