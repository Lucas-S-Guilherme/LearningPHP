# Dynamic Web App

## PHP Partials

diminuir a repetição de HTML reutilizável.

Extrair partes parciais para reduzir duplicação e utilizar variáveis para deixar dinâmica as partes que assim necessitam.

## Superglobals and Currente Page Styling

Superglobal são variáveis acessíveis em qualquer lugar em qualquer arquivo do projeto.

Foi utilizado:

$_SERVER
    Para capturar a uri solicitada como caminho de uma página

## Make a PHP Router

    Criamos um roteador que captura a uri da superglobal $_SERVER de uma solicitação get, e separa os dados da query do caminho/página solicitado com parse_url.


## Create a MySQL Database

Criado um DB com o TablePlus

## PDO First Steps

Criando instância de classe no PHP
~~~
class Person {
    public $name;
    public $age;

    public function breathe() {
        echo $this->name . " is breathing!";
    }
}

$person = new Person();

$person->name = 'John Doe';
$person->age = 25;

$person->breathe();
~~~

## Extract a PHP Database Class

Convenções para arquivos que são somente uma classe: Inicial Maiúscula.

Criado uma classe Database.php para conexão ao banco de dados, com método para query.

## Environments and Configuration Flexibility

Separar credenciais de configurações de banco de dados, para acessos, ou tokens de APIs, de maneira separada das Classes que iniciam um serviço.

## SQL Injection Vulnerabilities Explained

Nunca inclua uma string de consulta direto em um código SQL.

Usar declarações preparadas com parâmetros vinculados ?, não deixar em aberto.

Sempre use ? para inserir o parâmetro.
