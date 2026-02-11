<?php

$router->get('/', 'controllers/index.php');
$router->get('/about', 'controllers/about.php');
$router->get('/notes', 'controllers/notes/index.php');
$router->get('/note', 'controllers/note/show.php');
$router->get('/notes/create', 'controllers/note/create.php');
$router->get('/contact', 'controllers/contact.php');


