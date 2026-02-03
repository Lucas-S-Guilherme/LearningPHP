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
    <!-- TAG php -->
    <h1>TAG PHP, concatenação, impressão de strings</h1>
    <h2>
        <?php 
            echo "Hello, PHP";
        ?>
    </h2>
    <!-- operador de concatenação . (ponto) -->
    <p>
        <?php 
            echo "Hello, " . "Universe";
        ?>
    </p>

    <!-- variáveis iniciam com $ -->
    <p>
        <?php 
            $greenting = "Hello, Variable";

            echo $greenting . " Everybody";
        ?>
    </p>
    <!-- É possível imprimir variáveis e strings juntas entre aspas " " utilizando echo -->
    <p>
        <?php
            $greetings = "Hello";

            echo "$greetings Mundão Sem porteira";

        ?>
    </p>

    <h1>Conditionals and Booleans</h1>

    <?php 
        $name = "Dark Matter";
        $read = true;

        if($read){
            $message = "You have read $name";

        } else {
            $message = "You have NOT read $name";
        }
    ?> 

    <h2>
        <?php echo $message; ?>
        <!-- o código abaixo é igual <?php echo "string ou variável"; ?> -->
         <?= $message ?>
    </h2>

    <h1> Arrays </h1>

    <?php 
        $books = [
            "Do Androids Dream of Eletric Sheep",
            "The Langoliers",
            "Hail Mary"
        ];
    ?>

    <ul>
        <h2>Utilizando foreach</h2>
        
    <!-- envolver uma variável entre chaves {} isola ela para a execução -->
        <?php foreach ($books as $book) {
            echo "<li>{$book}™</li>";
        }        
        ?>

        <h2>Feito manualmente </h2>

        <li>Do Androids Dream of Eletric Sheep</li>
        <li>The Langoliers</li>
        <li>Hail Mary</li>

        <h2>Sintase abreviada do foreach</h2>
        <!-- Essa sintase não requer o uso de chaves e echo -->
        
            <?php foreach ($books as $book) : ?>
                <li><?= $book ?></li>
            <?php endforeach; ?>
        

    </ul>

    <h1>Arrays associativo</h1>

    <p>Um array de arrays</p>

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

        function filterByAuthor($books2, $author) {
            $filteredBooks = [];
            
            foreach ($books2 as $book) {
                if ($book['author'] === $author) {
                    $filteredBooks[] = $book;
                }
            }
            return $filteredBooks;

        }

    ?>

    <ul>
        <?php foreach ($books2 as $book) : ?>
            <li> 
                <a href=" <?= $book['purchaseUrl'] ?>">
                <?= $book['name']; ?> 
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <h1>Functions and Filters</h1>

        <h2>Filtragem manual</h2>
        
    <ul>
        <?php foreach ($books2 as $book) : ?>
             <?php if ($book['author'] === 'Andy Weir') : ?>
                <li>
                    <a href="<?= $book['purchaseUrl'] ?>" >
                        <?= $book['name']; ?> (<?= $book['releaseYear'] ?>)
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>        
    </ul>

    <h2>Filtragem por função</h2>

    <ul>
        <?php foreach (filterByAuthor($books2, 'Andy Weir') as $book) : ?>
            <li>
                <a href="<?= $book['purchaseUrl'] ?>" >
                    <?= $book['name']; ?> (<?= $book['releaseYear'] ?>) - By <?= $book['author'] ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <h1>Lambda Functions</h1>

    <p>Também conhecida como função anônima, é uma função que não é nomeada, mas possuíve parâmetros e está atribuída a uma variável</p>

    <!-- Faremos aqui uma função mais genérica, para ser mais flexível e filtrar o que quiser do Array -->
    <?php 
        //defini a função que receberá dois parâmetros, um item e uma fução
      function filter ($items, $fn)
        {
            // crirei um array
            $filteredItems = [];

            //itereção sobre o array passado, a função recebe 
            foreach ($items as $item) {
                if ($fn($item)) {
                    $filteredItems[] = $item;
                }
            }
            //retorna os itens filtrados em forma de array
            return $filteredItems;
        };
            
            // com a generalização acima, posso criar chamadas filtrando o que eu quiser, com a condição que eu quiser
            // atribuí o que é filtrado a um array
            $filteredBooks = filter ($books2, function ($book) {
                return $book['releaseYear'] <= 2000;
            });

    ?>

    <ul>
        <?php foreach ($filteredBooks as $book) : ?>
            <li>
                <a href="<?= $book['purchaseUrl'] ?>" >
                    <?= $book['name']; ?> (<?= $book['releaseYear'] ?>) - By <?= $book['author'] ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>


    <p>Todas as funções acima possuem uma função nativa do PHP chamada array_filter</p>
    <?php
    $filteredBooks2 = array_filter ($books2, function ($book) {
                return $book['releaseYear'] >= 2000;
            });
    ?>

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