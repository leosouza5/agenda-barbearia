<?php
require_once '../vendor/autoload.php';

use App\Controllers\AgendamentoController;
use App\Router\Router;


require_once './config/db.php';
header("Content-type: application/json; charset=UTF-8");
$router = new Router();
$agendamentoController = new AgendamentoController($pdo);

$router->add('GET', '/agendamento', [$agendamentoController, 'list']);
$router->add('GET', '/agendamento/{id}', [$agendamentoController, 'getById']);
$router->add('POST', '/agendamento', [$agendamentoController, 'create']);
$router->add('DELETE', '/agendamento/{id}', [$agendamentoController, 'delete']);
$router->add('PUT', '/agendamento/{id}', [$agendamentoController, 'update']);

$requestedPath = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$pathItems = explode("/", $requestedPath);
$requestedPath = "/" . $pathItems[3] . ($pathItems[4] ? "/" . $pathItems[4] : "");

$router->dispatch($requestedPath);
