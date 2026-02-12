<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::Class);

$currentUserId = 1;

$note = $db->query('SELECT * FROM notes WHERE id = :id', [
    'id' => $_POST['id']
    ])->findOrFail();

    authorize($note['fk_user_id'] === $currentUserId);

    $db->query('DELETE FROM notes WHERE id = :id', [
        'id' => $_POST['id']
    ]);

    header('location: /notes');
    exit();

?>
