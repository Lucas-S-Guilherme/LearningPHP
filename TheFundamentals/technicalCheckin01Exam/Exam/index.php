<?php

$movies = [
    [
        'title' => 'Star wars rebels',
        'director' => 'Luke Sky walker',
        'releaseYear' => 1977
    ],
    [
        'title' => 'Star wars 2',
        'director' => 'Obiwan Kenobi',
        'releaseYear' => 1980
    ],  
    [
        'title' => 'Star wars 3',
        'director' => 'Dark Vador',
        'releaseYear' => 1983
    ]
    
];

function filterByDirector ($movies, $director) {
    $filteredMovies = [];

    foreach ($movies as $movie) {
        if($movie['director'] === $director) {
            $filteredMovies[] = $movie;
        }
    }
    return $filteredMovies;
}

$filteredMovies = filterByDirector($movies, 'Luke Sky walker');

// lambda function - não é nomeada, mas é atribuída a uma variável

$filter_movies = function ($items, $fn) {
    $filteredItems =[];

    foreach ($items as $item) {
        if ($fn($item)) {
            $filteredItems[] = $item;
        }    
    }
    return $filteredItems;
};

$lambdaFilteredMovies = $filter_movies($movies, function ($movie) {
    return $movie['releaseYear'] >= 1980;
});


require "challenge.view.php";

?>