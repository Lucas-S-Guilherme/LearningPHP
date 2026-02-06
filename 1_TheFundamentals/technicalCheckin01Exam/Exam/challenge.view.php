<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Filmes Filtrados</h1>
    <ul>
        <?php
        foreach ($filteredMovies as $movie) {
            echo "<li>" . $movie['title'] . " - " . $movie['releaseYear'] . "</li>";
        }     
        ?>
        
        <!-- Feito de outra forma -->
        <p>Feito com sintaxe alternativa de foreach e com tag curta de echo </p>
       
        <?php foreach ($filteredMovies as $movie) : ?>
            <li><?= $movie['title'] ?> (<?= $movie['releaseYear'] ?>)</li>
        <?php endforeach; ?>

        <p>Lambda Function</p>
        
        
            <?php foreach ($lambdaFilteredMovies as $movie) : ?>
                <li>
                    <a href="<?= $book['purchaseUrl'] ?>" >
                        <?= $movie['title']; ?> (<?= $movie['releaseYear'] ?>) - By <?= $movie['director'] ?>
                    </a>
                </li>
            <?php endforeach; ?>
        

    </ul>
</body>
</html>     