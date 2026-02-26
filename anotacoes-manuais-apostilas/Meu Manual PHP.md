# Meu Manual de PHP

# Referência da Linguagem

## Sintaxe Básica

## Tipos

### Arrays

Um array em PHP pode ser uma coleção de vários itens diferentes

pode ser declaro com array (); ou na sintaxe curta [].

Elementos de um array pode ser acessado com a sintaxe array[chave].

## Variáveis

## Constantes

### Constantes Mágicas

#### __DIR__


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

### Require

    Declaração que incluíu um código de um arquivo em outro, tornando o escopo de variáveis do código incluído acessível a partir daquela linha.

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

# Refeência das Funções

    Afetando o comportamento do PHP
    Manipulação de Formatos de Áudio
    Serviços de Autenticação
    Extensões Específicas para Linha de Comando
    Extensões de Arquivo e Compressão
    Extensões para Criptografia
    Extensões de Banco de Dados
    Extensões Relacionadas a Data e Horário
    Extensões Relacionadas a Sistema de Arquivo
    Linguagem Humana e Suporte a Codificação de Caracteres
    Processamento e Geração de Imagem
    Extensões Relacionadas a Correio Eletrônico
    Extensões Matemáticas
    Saída de MIME Não-Texto
    Extensões para Controle de Processo

## Outras Extensões Básicas

### Biblioteca Padrão SPL

#### spl_autoloader_register()

Encarregado de encontrar e carregar classes não importados no código por require.

    Outros Serviços
    Extensões de Motor de Busca
    Extensões Específicas para Servidor
    Extensões de Sessão
    Processamento de Texto
    Extensões Relacionadas a Variáveis e Tipos
    Serviços para Web
    Extensões Somente para Windows
    Manipulação de XML
    Extensões GUI