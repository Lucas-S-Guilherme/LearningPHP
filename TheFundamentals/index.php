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
    <h1>
        <?php 
            echo "Hello, PHP";
        ?>
    </h1>
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
    ?>

    <h2>
        You are read "<?php echo $name; ?>."
    </h2>

</body>
</html>