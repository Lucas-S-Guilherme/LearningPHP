# Notes Mini-Project

Iremos contruir um pequeno aplicativo de notas.

## Database Tables and Indexes

Pequena explicação sobre banco de dados.

## Render the Notes and Note Page

Busca do dado no Banco de Dados e exibição em uma página simples.

## Introduction to Authorization

Configurado verificação de permissões do usuário atual, para exibição ou não de páginas ao qual possuí permissão.

## Programming is Rewriting

## Intro to Forms and Request Methods

Arquivos editados:
view: 
    notes
    note-create.view

Separado rotas para o arquivo routes.php, retirado de router.

routes:
    /notes/create

controller:
    note-create.php

## Always Escape Untrusted Input

Utilizado instruções preparadas para evitar o risco de injeção de SQL. 
Utilizado instrução de entidades especiais html para não permitir injeção de HTML.

Próximo passo será a validação dos formulários.

retorna no note-create.php

Preocupação de segurança, sanitização e filtragem de dados:

Editar notes.view.php:

Processar todos valores e dados enviados pelo usuário.

note.view:
    também precisa ser sanitizado.

## Intro to Form Validation

aplicado atributo da tag form required no formulário, mas ele não resolve, é possível contornar com curl pelo terminal. Para resolver é necessário a validação por meio do servidor.

Editado:
    note-create.php
    note-create.view.php




