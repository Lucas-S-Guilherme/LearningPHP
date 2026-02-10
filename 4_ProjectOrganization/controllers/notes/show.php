<?php
use Core\Database;

$config = require base_path('config.php');
$db = new Database($config['database']);

$currentUserId = 1;


// será refatorado para uma abordagem mais limpa no episódio 33

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $note = $db->query('SELECT * FROM notes WHERE id = :id', [
        'id' => $_GET['id']
    ])->findOrFail();

    authorize($note['fk_user_id'] === $currentUserId);
    
    $db->query('DELETE FROM notes WHERE id = :id', [
        'id' => $_GET['id']
    ]);

    header('location: /notes');
    exit();
} else {
    $note = $db->query('SELECT * FROM notes WHERE id = :id', [
        'id' => $_GET['id']
    ])->findOrFail();

    authorize($note['fk_user_id'] === $currentUserId);

    view('notes/show.view.php', [
        'heading' => 'Note',
        'note' => $note
    ]);
}

?>
