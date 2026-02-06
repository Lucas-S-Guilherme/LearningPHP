<?php

$books2 = [
    [
        'name' => 'Do Androids Dream of eletric Sheep',
        'author' => 'Philip K. Dick',
        'releaseYear' => 1968,
        'purchaseUrl' => 'https://example.com'
    ],

    [
        'name' => 'Project Hail Mary',
        'author' => 'Andy Weir',
        'releaseYear' => 2021,
        'purchaseUrl' => 'https://example.com'

    ],
    [
        'name' => 'The Martian',
        'author' => 'Andy Weir',
        'releaseYear' => 2011,
        'purchaseUrl' => 'https://example.com'

    ]
];


$filteredBooks2 = array_filter($books2, function ($book) {
    return $book['releaseYear'] >= 2000;
});

// requer a visualização, carrega os itens dessa página

require "index.view.php";