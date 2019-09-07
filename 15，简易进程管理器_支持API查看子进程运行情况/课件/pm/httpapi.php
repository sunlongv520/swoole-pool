<?php
$http=new Swoole\Http\Server("0.0.0.0","80");
$http->set([
    'worker_num' => 1,    //worker process num
]);

$http->on('request', function ($request, \Swoole\Http\Response $response) {
   $p=file_get_contents(__DIR__."/p.data");
   $response->header("Content-type","application/json");
   $response->end($p);

});
$http->start();
