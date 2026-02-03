<?php

//definindo variáveis
$name = 'Lucas';
$cost = 15;

//definindo array
$business = [
    'name' => 'Laracasts',
    'cost' => 15,
    'categories' => ["Testing", "PHP", 'Javascrip']
];

//chamando array
$business['name']; //Laracasts

//condicionais
if($business['cost'] > 99) {
    echo "Not interested";
}

//iterações
foreach ($business['categories'] as $category) {
    echo $category . "<br>";
}

//funções
function register ($user) {
    // create the user record in the db.
    // log them in.
    // Send a welcome email..
    // Rediret to their new dashboard.
}

require "index.view.php";
