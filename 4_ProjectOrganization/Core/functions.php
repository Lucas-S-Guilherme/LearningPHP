<?php

function dd($value) {
    
echo "<pre>"; //tag <pre> exibe o texto de saído do var_dump pré-formatado
var_dump($value); //função do PHP, despeja informações detalhadas sobre uma variável
echo "</pre>";

die();
}

//jeito mais manual de se fazer

// if ($_SERVER['REQUEST_URI'] === '/') { 
//     echo 'bg-gray-900 text-white';
// } else { 
//         echo "text-gray-300 hover:bg-white/5 hover:text-white";
// }

// com operador ternário

// echo $_SERVER['REQUEST_URI'] === '/' ? 'bg-gray-900 text-white' :
//         "text-gray-300 hover:bg-white/5 hover:text-white";

//com uma função
function urlIs ($value) {
    return $_SERVER['REQUEST_URI'] === $value;
}

function abort($code = 404)
{
    http_response_code($code);
    require base_path("views/{$code}.php");
    die();
}

function authorize($condition, $status = Response::FORBIDDEN) 
{
    if (! $condition) {
        abort($status);
    }
    return true;
}

function base_path($path) {
    return BASE_PATH . $path;
}

function view($path, $attributes = []) {
    extract($attributes);
    require base_path('views/' . $path);
}