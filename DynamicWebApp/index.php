<?php

require 'functions.php';
//require 'router.php';
require 'Database.php';

$config = require 'config.php';

//instância do DB
$db = new Database($config['database']);

$posts =$db->query('select * from posts')->fetchAll();

dd($posts);
