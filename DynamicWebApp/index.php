<?php

require 'functions.php';
//require 'router.php';
require 'Database.php';

$config = require 'config.php';

//instância do DB
$db = new Database($config['database']);

$id = $_GET['id'];

//isso permite SQL INjetction:
// $query = "select * from posts where id = {$id}";

//pode ser feito assim evitando SQL Injetction
$query = 'select * from posts where id = ?';

$posts =$db->query($query, [$id])->fetch();

// ou fazer assim
// $query = 'select * from posts where id = :id';
// $posts = $db->query($query, [':id' => $id]) -> fetch();

dd($posts);
