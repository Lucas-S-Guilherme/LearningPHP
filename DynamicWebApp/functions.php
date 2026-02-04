<?php

// O que isso faz mesmo?
function dd($value) {
    //despejo de variável
echo "<pre>";
var_dump($value);
echo "</pre>";

die();
}


// if ($_SERVER['REQUEST_URI'] === '/') { 
//     echo 'bg-gray-900 text-white';
// } else { 
//         echo "text-gray-300 hover:bg-white/5 hover:text-white";
// }

// com operador ternário

// echo $_SERVER['REQUEST_URI'] === '/' ? 'bg-gray-900 text-white' :
//         "text-gray-300 hover:bg-white/5 hover:text-white";


function urlIs ($value) {
    return $_SERVER['REQUEST_URI'] === $value;
}