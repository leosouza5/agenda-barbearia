<?php

use App\Router\Router;

require '../vendor/autoload.php';


// $router = new Router();

// $controller;

// $router->add('agendamentos',function() use ($controller){
//     //chama metodo do controller
// });
// $router->add('clientes',function() use ($controller){
//     //chama metodo do controller
// });

$requestedPath = parse_url($_SERVER["REQUEST_URI"],PHP_URL_PATH);
$pathItems = explode("/",$requestedPath);
$requestedPath ="/" . $pathItems[3] . "/" . $pathItems[4];

echo $requestedPath;