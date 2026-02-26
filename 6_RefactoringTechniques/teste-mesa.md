# Teste de Mesa

## /public/index.php
Toda a aplicação começa aqui. Chamado de Front Controller, Todas as requisições chegam aqui primeiro e depois são distribuídas.

Linha 1: abertura da tag php com <?php

Linha 3: função nativa do PHP session_start() inicia a sessão de navegação. Permite utilizar a superglobal $_SESSION para salvar dados da sessão do usuário.

*Linha 5:* 
    const : define uma constante.
    
    BASE_PATH : nome da constante, por convenção constantes são em maiúsculas.
    
    __DIR__ : constante mágica do PHP. retorna o local exato onde este arquivo atual está salvo.
    
    . (ponto) : operador de concatenação de strings. 
    
    '/../' : comando de navegação para voltar um nível de diretório. 
    BASE_PATH retorna o valor = LearningPHP/6_RefactoringTechniques/.

Linha 7: declaração require inclui e torna acessível código em /Core/functions.php.

Linha 9:
    spol_autoload_register(...) : registra uma função nativa que o PHP executará automaticamente sempre que tentar usar uma classe que ainda não foi carregada.

    function ($class) { ... } : função anônima ou closure, a variável $class recebera automaticamente o nome da classe que o código esta tentando chamar.

    str_replace(...) : função nativa do PHP que recebe 3 argumentos $search, $replace, $subject. O que procurar (\), pelo que trocar (DERECTORY_SEPARATIR) e onde procurar ($class). 
   
    '\\' : O php utiliza \ como caractere de escape, como \ é utilizada em namespaces no PHP, é necessário escapar o \ para ela ser procurada. 
    
    DIRECTORY_SEPARATOR é uma constante pré-definida do PHP que muda de valor automaticamente dependendo de onde o código está rodando, isso faz com que o código seja portátil (linux usa /var/www windows usa \var\www). 
    
    $class contém o nome da classe que o autoloader está tentando carregar no momento. No PHP, os Namespaces são separados por barra invertida. Exemplo de valor chegando aqui "Core\Router" 

    No final a função str_replace atribuiria o valor "Core/Router" à variável $class.

Linha 12:
    require base_path(...) : importa o retorno da função base_path, que foi definida em functions.php, essa função aceita um argumento $path, e tem como retorno BASE_PATH . $path.
    
    "{$Class}.php" : "..." as aspas duplas no PHP são especiais, elas dizem: "se houver uma variável aqui dentro, troque pelo valor dela". {} as chaves servem para isolar a variável $class, fazendo com que exatamente seja passado o valor da variável e depois adicionado o .php. 
    Continuando o exemplo anterior, se "Core/Router" for o valor de $class, será passado como $path (parâmetro da função base_path) o valor Core/Router.php.
    *Dentro da função base_path* é então concatenado o diretório raiz definido atribuído à constante BASE_PATH com o valor passado como argumento "Core/Router.php". 
    require então importa o arquivo com o caminho retornado por base_path. Exe.: var/www/meu-site/Core/Router.php

Linha 15:
    É feito algo semelhante ao passo anterior, só dessa vez para um arquivo específico 'bootstrap.php'.
    require torna todo código de bootstrap acessível ao index.php.


Próximas Linhas do projeto:

5. Bootstrap e Rotas
PHP

require base_path('bootstrap.php');

$router = new \Core\Router();
$routes = require base_path('routes.php');

    require base_path('bootstrap.php'): Carrega configurações iniciais (como conexão com banco de dados ou injeção de dependência).

    $router: Cria uma variável.

    =: Operador de atribuição.

    new: Palavra-chave para instanciar (criar um objeto) a partir de uma classe.

    \Core\Router(): Chama a classe Router que está dentro do namespace Core. O autoloader (passo 4) entra em ação aqui para carregar o arquivo dessa classe.

    $routes = require ...: Curiosidade do PHP: o comando require pode retornar valores se o arquivo incluído tiver um return. Aqui, ele está carregando as definições de rotas e guardando na variável $routes (embora, neste código específico, a variável $routes não pareça ser usada nas linhas seguintes, o que sugere que o arquivo routes.php talvez popule o $router diretamente ou seja apenas um efeito colateral).

6. Obtendo a URI e o Método
PHP

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

    $_SERVER: Uma superglobal (array) contendo informações do servidor e da execução.

    ['REQUEST_URI']: A chave que contém o endereço acessado (ex: /contato?origem=google).

    parse_url( ... ): Função que quebra a URL em partes (host, path, query, etc.).

    ['path']: Acessamos apenas a parte do caminho do array retornado por parse_url.

        Por que isso? Se o usuário acessar /contato?id=1, nós queremos rotear apenas para /contato. O parse_url remove o ?id=1.

PHP

$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

Esta linha é muito importante para formulários HTML.

    $_POST['_method']: Procura por um campo escondido (hidden input) no formulário chamado _method. HTML só suporta nativamente GET e POST. Para fazer um DELETE ou PUT (comum em APIs ou frameworks modernos), costuma-se enviar um POST com um campo extra dizendo "trate isso como DELETE".

    ?? (Null Coalescing Operator): Este operador significa "Se o valor da esquerda existir e não for nulo, use-o. Caso contrário, use o da direita".

    $_SERVER['REQUEST_METHOD']: O método HTTP real da requisição (GET, POST, etc.).

        Resumo: "Se alguém enviou um método falso via POST, use ele. Se não, use o método real do navegador".

7. Roteamento Final
PHP

$router->route($uri, $method);

    $router: O objeto que criamos no passo 5.

    -> (Seta simples): Operador de acesso a objetos. Serve para acessar propriedades ou métodos dentro de um objeto. Equivalente ao . em linguagens como Java ou JavaScript.

    route(...): Chama o método (função) route dentro da classe Router.

    ($uri, $method): Passa a URL limpa e o método HTTP correto para o roteador decidir qual controlador (Controller) deve ser carregado e qual visualização (View) exibir.

Resumo do Fluxo (Teste de Mesa)

    Usuário acessa /notas.

    index.php (este arquivo) carrega as ferramentas básicas e classes.

    Ele limpa a URL para obter apenas /notas.

    Ele verifica se é um GET ou POST.

    Ele entrega esses dados (/notas, GET) para o objeto $router.

    O $router olha sua lista interna, encontra quem cuida de /notas e aciona o código correspondente.




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