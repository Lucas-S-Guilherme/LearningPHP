# Teste de Mesa

## index.php
Toda a aplicação começa aqui.

Linha 1: abertura da tag php com <?php
Linha 3: função nativa do PHP session_start() inicia a sessão de navegação.
Linha 5: defini constante BASE_PATH que recebe o valor da constante mágica __DIR__ concatenado (.) com o valor '/../'; Valor de saída será LearningPHP/6_RefactoringTechniques/public/index.php/../ , o sistema interpretará /../ como voltar um nível, fazendo com que BASE_PATH tenha o valor de LearningPHP/6_RefactoringTechniques/.
linha 7: declaração require torna acessível código de /Core/function.php.

linha 9:

## /views/index.view.php

Linha 1: Declaração require faz a inclusão do escopo de variáveis do arquivo em partials/head.php e retorna essa view.
Linha 2: Declaração require faz a inclusão do escopo de variáveis do arquivo em partials/nav.php e retorna essa view.
Linha 3: Declaração require faz a inclusão do escopo de variáveis do arquivo em partials/banner.php e retorna essa view.
Linha 7: Aberta tag PHP dentro da tag html <p>, operador de Covalescência Nula ?? verifica se $_SESSION há uma chave/valor 'user' e 'email', em caso positivo(true) retorna esses dados, caso negativo retorna 'Guest'. Sempre em um acesso sem login, retornará 'Guest'.

## /views/partials/head.php

Nada de código PHP aqui, somente html.

## /views/partials/nav.php

Linha 12: tag html <a> é aberta e atributo href indica o destino "/".
Linha 13: atributo class"" comporta abertura de tag PHP, que chama a função urlIs($value.). Essa função atribuí $value ao array $_SERVER na chave 'REQUEST_URI'.