<?php

//função nativa do PHP que separa o caminho solicitado da query

function routeToController($uri, $routes) {
    if (array_key_exists($uri, $routes)) {
        require $routes[$uri];
    } else {
        abort();
    }
}

// função para se a rota/caminho não existir
function abort($code = 404) {
    http_response_code($code);
    
    require "views/{$code}.php";

    die();
}

$routes = require ('routes.php');
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

routeToController($uri, $routes);