# Meu Manual de PHP

## Sintaxe Básica

## Tipos

## Variáveis

## Constantes

## Expressões

## Operadores

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
