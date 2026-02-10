<?php
use Core\Database;
use Core\Validator;

$config = require base_path('config.php');

$db = new Database($config['database']);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   //validação do lado do servidor

   $errors = [];

    if (! Validator::string($_POST['body'], 1, 1000)) {
        $errors['body'] = 'A body of no more than 1,000 characters is required.';
    }

    if(empty($errors)) {
        $db->query('INSERT INTO notes(body, fk_user_id) VALUES (:body, :fk_user_id)', [
            'body' => $_POST['body'],
            'fk_user_id' => 1
        ]);
    }
}

//    if (strlen($_POST['body']) === 0) {
//     $errors['body'] = "A body is required";
//    }

//     if (strlen($_POST['body']) > 1000) {
//         $errors['body'] = 'The body can not be more than 1,000 characters';
//     }

//     if (empty($errors)) {
//         $db->query('INSERT INTO notes(body, fk_user_id) VALUES(:body, :fk_user_id)', [
//             'body' => $_POST['body'],
//             'fk_user_id' => 1
//         ]);
//     }

view("notes/create.view.php", [
    'heading' => 'Create Note',
    'errors' => $errors,
]);

require 'views/notes/create.view.php';
