<?php

//função nativa do PHP que separa o caminho solicitado da query
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];


//criamos um array para armazenar as rotas
$routes = [
    '/' => 'controllers/index.php',
    '/about' => 'controllers/about.php',
    '/notes' => 'controllers/notes.php',
    '/note' => 'controllers/note.php',
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


