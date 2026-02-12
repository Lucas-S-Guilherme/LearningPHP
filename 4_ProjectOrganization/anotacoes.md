# Project Organization

## Resourceful Naming Conventions

Tudo relacionado à uma entidade, deve ser organizado em um diretório próprio. 

NOTE: lembrar de atualizar rota.

Controlador ou ação para exibir todos os recursos ou lista páginada de rescursos é comummente chamada de índice. Então renomear para index.php

Criado o diretório em /controllers/notes (fazer o mesmo para views)
    arquivos renomeados para:
        create.hp
        show.php
        index.php

Seguir essa abordagem para cada recurso da aplicação.

## PHP Autoloading and Extraction

1. Segurança e Diretório

*Problema:* Configurar o projeto para que arquivos de configuração não fiquem acessíveis pelo navegador. Como por exemplo ao tentar e conseguir acessar seusite.com/config.php.

*Solução:* Criar uma pasta /public e definir o *Document Root* do servidor nela. Assim, somente o index.hp e arquivos estáticos (CSS/JS) ficam acessíveis.

2. Gerenciamento de Caminhos (Base Path)

*Problema:* Ao organizar o projeto para diferentes diretórios, os require começam a quebrar.

*Solução:* Usar a constante global BASE_PATH que armazena o caminho absoluto para a raiz do projeto. Ou, declarar uma função simples que aceita um caminho e o anexo ao basePath, tornando as incluções de arquivos muito mais limpas e menos propensas a erros.

3. Melhoria na Renderização de Views

Criada a função view() para chamar uma view de maneira mais amigável.

4. Autoloading de Classes (SPL Autoload)

`spl_autoload_register()` função que escuta quando vocẽ tenta instanciar uma classe que ainda não foi carregada.

Com ela o PHP busca e carrega automaticamente um arquivo da classe apenas quando ele é necessário, economizando recursos e limpnaod o arquivo de entrada.

5. Separação de Preocupações (Pasta Core)

Separação do que é infraestrutura do que é aplicação.

Core: classes genéricas que podem ser usadas em qualquer parte da aplicação.

Após as mudanças rodar o servidor com:
`php -S localhost:8888 -t public`


## Namespacing: What, Why, How?

Declarando namespaces.

1. O que é Namespacing? (O "O quê")

Imagine que você tem duas pessoas chamadas "Lucas" na sua empresa. Para diferenciá-las, você usa o sobrenome: "Lucas Silva" e "Lucas Oliveira".

    No PHP, um Namespace é como o sobrenome de uma classe.

    Ele agrupa classes relacionadas e evita conflitos. Se você criar uma classe Database e usar uma biblioteca de terceiros que também tem uma classe Database, o PHP saberá qual é qual pelo namespace.

2. Por que usar? (O "Porquê")

Sem namespaces, todas as suas classes vivem no "espaço global". Conforme o projeto cresce:

    Conflitos de nomes tornam-se inevitáveis.

    Organização: Fica difícil saber quais classes são do "Core" do sistema e quais são da "Aplicação".

    Autoloading Moderno: Os namespaces permitem que o seu autoloader encontre arquivos baseando-se na estrutura de pastas (Padrão PSR-4).

3. Como implementar? (O "Como")

A aula mostrou três passos práticos para refatorar seu código:
A. Declarando o Namespace

No topo de cada arquivo de classe (como o Database.php), você define a sua "família":

~~~PHP
<?php
namespace Core; // Agora o nome completo desta classe é Core\Database

class Database { ... }
~~~

B. Usando a Classe (O comando use)

Quando você estiver em um Controller e precisar da Database, você tem duas opções:

    Caminho completo: $db = new \Core\Database();

    Importação (mais limpa):

        ~~~PHP
            use Core\Database;
            $db = new Database(); // O PHP já sabe que é o do Core
        ~~~

C. O "Escopo Global" (A barra invertida \)

Esta é uma lição técnica vital: Quando você define um namespace no topo do arquivo (ex: namespace Core), o PHP assume que tudo o que você chamar ali dentro pertence ao Core.

    O Problema: Se você tentar usar a classe nativa do PHP PDO, o PHP vai procurar por Core\PDO e dar erro.

    A Solução: Use \PDO (com a barra) para dizer ao PHP: "Ei, procure isso na raiz do PHP, não no meu namespace atual". Ou, melhor ainda, adicione use PDO; no topo.

4. Evolução do Autoloader

A aula mostrou como transformar o autoloader para lidar com esses "sobrenomes":

    Troca de barras: Namespaces usam backslashes (\), mas sistemas de arquivos (como o seu Ubuntu) usam forward slashes (/).

    str_replace: O autoloader agora pega Core\Database, troca a \ por / e resulta no caminho Core/Database.php.

    DIRECTORY_SEPARATOR: Uma boa prática para que seu código funcione tanto no Linux quanto no Windows.

Exemplo do novo Autoloader:

~~~PHP
spl_autoload_register(function ($class) {
    // Troca Core\Database por Core/Database
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    require base_path("{$class}.php");
});
~~~

Resumo Técnico:
Conceito	Descrição
namespace	Define a "pasta lógica" da classe. Deve ser a primeira linha do PHP.
use	Importa uma classe de outro namespace (como um import em outras linguagens).
\ (Backslash)	No início de uma classe (ex: \PDO), aponta para o diretório raiz global do PHP.

## Handle Multiple Request Methods From a Controller Action?

O Porquê guia o refatoramento.

## Build a Better Router


## One Request, One Controller


## Make Your First Service Container

Na maioria dos casos, utilizaremos ferramentas para controllers e roteamento.

O mesmo para criar um container.

bootstrap = Por que esse nome? 
    O termo vem da expressão em inglês "pulling oneself up by one's bootstraps" (erguer-se pelas próprias botas), referindo-se à ideia de que o sistema/framework prepara a si mesmo para funcionar.

