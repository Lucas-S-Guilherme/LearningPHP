<?php

//função nativa do PHP que separa o caminho solicitado da query
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

//maneira ruim de se fazer:
// if ($uri === '/') {
//     require 'controllers/index.php';
// } else if ($uri === '/about') {
//     require 'controllers/about.php';
// } else if ($uri === '/contact') {
//     require 'controllers/contact.php';
// }

//refatorando abaixo:

//criamos um array para armazenar as rotas
$routes = [
    '/' => 'controllers/index.php',
    '/about' => 'controllers/about.php',
    '/contact' => 'controllers/contact.php'
];

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

routeToController($uri, $routes);


