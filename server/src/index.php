<?php
require_once '../vendor/autoload.php';

use App\Controllers\AgendamentoController;
use App\Controllers\ClienteController;
use App\Router\Router;


require_once './config/db.php';
header("Content-type: application/json; charset=UTF-8");
$router = new Router();
$agendamentoController = new AgendamentoController($pdo);
$clienteController = new ClienteController($pdo);

$router->add('GET', '/cliente', [$clienteController, 'list']);
$router->add('POST', '/cliente', [$clienteController, 'create']);
$router->add('GET', '/cliente/{id}', [$clienteController, 'getById']);
$router->add('PUT', '/cliente/{id}', [$clienteController, 'update']);
$router->add('DELETE', '/cliente/{id}', [$clienteController, 'delete']);


$router->add('GET', '/agendamento', [$agendamentoController, 'list']);
$router->add('GET', '/agendamento/{id}', [$agendamentoController, 'getById']);
$router->add('POST', '/agendamento', [$agendamentoController, 'create']);
$router->add('DELETE', '/agendamento/{id}', [$agendamentoController, 'delete']);
$router->add('PUT', '/agendamento/{id}', [$agendamentoController, 'update']);

$requestedPath = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$pathItems = explode("/", $requestedPath);

$requestedPath = "/" . ($pathItems[3] ?? '') . (!empty($pathItems[4]) ? "/" . $pathItems[4] : "");


$router->dispatch($requestedPath);
