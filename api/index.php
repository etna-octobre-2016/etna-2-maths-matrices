<?php
require 'vendors'.DIRECTORY_SEPARATOR.'autoload.php';

header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS')
{
    header('Access-Control-Allow-Headers: Content-Type');
    header('Access-Control-Allow-Methods: GET,POST');
    header('Access-Control-Max-Age: 3600');
}
else
{
    $app = new App\Application();
    $app->run();
}
