# Sessions and Authentication

## PHP Sessions 101

Pesquisar sobre cookies sobre a sessão do lado do cliente.
Onde esse arquivo está sendo salvo.
Como encontar esse arquivo.

No meu pc está em Versão Snap (Padrão do Ubuntu):
~/snap/firefox/common/.mozilla/firefox/[nome-do-perfil(hashAlearótorio)]/cookies.sqlite

## Register a New User

Rodar o servidor com: 

~~~
php -S localhost:8888 -t public -d session.save_path="$(pwd)/storage/sessions"
~~~

Criado storage/sessions para visualizar os arquivos de sessão gerados com o servidor PHP.

## Introduction to Middleware

O que é um Middleware?

Uma ponte para o núcleo da aplicação, para levar da solicitação atual para o núcleo da aplicação.

## Password

Classe PHP que criptografa em hash de senha.

PASSWORD_BCRYPT

## Log In and Log Out

