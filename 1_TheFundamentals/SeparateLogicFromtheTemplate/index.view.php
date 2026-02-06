<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        body {
            display: grid;
            place-items: center;
            height: 100vh;
            margin: 0;
            font-family: sans-serif;            
        }
    </style>
</head>
<body>
    


    
    <ul>
        <?php foreach ($filteredBooks2 as $book) : ?>
            <li>
                <a href="<?= $book['purchaseUrl'] ?>" >
                    <?= $book['name']; ?> (<?= $book['releaseYear'] ?>) - By <?= $book['author'] ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>


</body>

</html>