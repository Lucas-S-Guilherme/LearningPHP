# Introdução geral

PHP é uma linguagem de script open source, muito utilizada para desenvolvimento web.

# instalação no Linux

Pode-se instalar o PHP por meio do comando:

~~~
apt install php-common libapache2-mod-php php-cli
~~~

Mas preferi o HomeBrew para gestão da versão utilizada, com o comando: 

~~~
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
~~~

# Primeira TAG PHP

para iniciar um código PHP, é necessário que ele esteja em uma tag PHP:
~~~
<?php ?>
~~~

Em alguns momentos, utiliza-se o PHP para retornar alguma string, como abaixo:

~~~
<?php 
    echo "Hello World";
?>
~~~

Quando se quer somente imprimir algum valor, pode-se utilizar a tag PHP curta:
~~~
<?= 
"Hello World 
?>
~~~

# Operador de concatenação

Utilizamos o .

~~~
 <?php 
            echo "Hello, " . "Universe";
 ?>
~~~

Tudo dentro de aspas duplas também é impresso:
~~~
    <?php 
        $name = "Universe"
        echo "Hello $name";
    ?>
~~~

NOTE: aspas simples ' ' não faz o mesmo.

## Variáveis PHP
Todas começam com $nomeVariavél

## Array

~~~
$nomeArray = [] // um array de uma dimensão
~~~

## Array Associativos ou matrizes?

## Funções

~~~
function nameOfFunction (parameters) {
    logic
    return things;
}
~~~

## funções lambdas

## Separate Logic From the Template


