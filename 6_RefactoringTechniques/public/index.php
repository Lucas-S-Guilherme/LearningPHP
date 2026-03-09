<?php

use Core\Session;

session_start();

const BASE_PATH = __DIR__.'/../';

require BASE_PATH.'Core/functions.php';

spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    require base_path("{$class}.php");
});

require base_path('bootstrap.php');

$router = new \Core\Router(); //Classe router inicializa o array $routes como array vazio.
$routes = require base_path('routes.php'); // aqui o array é preenchido com as rotas definidas em routes.php

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);
// acessa a função route do objeto $router, passando os parâmetros $uri e $method, que são a URI da requisição e o método HTTP utilizado. A função route é responsável por encontrar a rota correspondente e executar o controlador associado a essa rota.

Session::unflash();