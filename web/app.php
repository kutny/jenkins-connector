<?php

use Symfony\Component\HttpFoundation\Request;

$kernel = require(__DIR__ . '/../app/configure.php');
$kernel->loadClassCache();
// $kernel = new AppCache($kernel);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
