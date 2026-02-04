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