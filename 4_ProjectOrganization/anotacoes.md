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

