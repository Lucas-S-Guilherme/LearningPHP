# Meu Manual de PHP

## Sintaxe Básica

## Tipos

## Variáveis

## Constantes

## Expressões

## Operadores

### Operador de convalescência nula (??)

É uma expressão, e ele não é avaliado para uma variável, mas para o resultado de uma expressão.

~~~PHP
<?php 
// Exemplo do operador Null Coalesce
$action = $_POST['action'] ?? 'default';

//O conteúdo acima é idêntico à essa declaração if/else:
if (isset($_POST['action'])) {
    $action = $_POST['action'];
} else {
    $action = 'default';
}
?>
~~~

(expre1) ?? (expr2)

Se (expre1) não for nulo retorna a expressão 1.
Se (expre1) for nulo retorna a expressão 2. 

#### Diferença entre Operador Ternário (?) e Operador de Coalescência Nula (??)

A confusão é super comum porque o ?? (Coalescência Nula) é, na verdade, um "primo especializado" do operador ternário.

A principal diferença está no critério de avaliação: o que o PHP considera como "vazio" ou "falso" para decidir qual valor usar.
1. Operador Ternário (?:)

O ternário checa se um valor é verdadeiro (truthy). No PHP, muitas coisas são consideradas "falsas" (falsy), como o número 0, uma string vazia "", um array vazio [], ou o booleano false.

~~~PHP
$action = $_POST['action'] ? $_POST['action'] : 'default';
~~~

    Se $_POST['action'] for 0: Ele retorna 'default'.

    Se $_POST['action'] for "" (vazio): Ele retorna 'default'.

    Problema: Se a variável não existir, ele gera um erro de "Notice: Undefined index".

2. Operador de Coalescência Nula (??)

Ele foi criado especificamente para lidar com arrays e objetos. Ele só olha para duas coisas: "A variável existe?" e "Ela é diferente de NULL?".

~~~PHP
$action = $_POST['action'] ?? 'default';
~~~

    Se $_POST['action'] for 0: Ele retorna 0 (porque 0 existe e não é nulo).

    Se $_POST['action'] for "": Ele retorna "" (porque uma string vazia não é nula).

    Vantagem: Se a variável não existir, ele não gera erro e retorna 'default'.

## Estruturas de Controle

## Funções

## Clases e Objetos

### Operador de Resolução de Escopo (::)

O Operador de Resolução de Escopo (dois pontos) ::, é um símbolo que permite acesso a uma *constante*, a uma propriedade *estática*, ou a um método *estático* de uma classe ou a um dos pais dessa classe.

Para referenciar estes itens do lado de fora da definição da classe, use o nome da classe.

Também é possível referenciar a classe usando uma variável.

~~~PHP
<?php
class MyClass {
    const CONST_VALUE = "Um valor constante';
}

$classname = "MyClass";

echo $classname::CONST_VALUE;

echo MyClass::CONST_VALUE;

?>
~~~


## Namespaces

## Enumerações

## Erros

## Exceções

## Fibers

## Geradores

## Atributos

## Referências

## Variáveis predefinidas

### Superglobals

## Exceções predefinidas

## Interfaces e Classes predefinidas

## Atributos Predefinidos

## Opções e parâmetros de contexto

## Protocolos e empacotadores suportados
