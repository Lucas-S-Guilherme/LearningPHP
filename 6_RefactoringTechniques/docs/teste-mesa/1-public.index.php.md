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

Linha 17:
    Cria a variável $router que recebe o valor de uma nova instância da classe Router.

Linha 18: 
    Função base_path(...) é usada para apontar a raiz do projeto e assim incluir o código de routes.php e passar à $routes como um array.

Linha 20:
    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];

    $_SERVER: Uma superglobal (array) contendo informações do servidor e da execução.

    ['REQUEST_URI']: A chave que contém o endereço acessado (ex: /contato?origem=google).

    parse_url( ... ): Função nativa PHP que converte e retorna componentes de uma URL (host, path, query, etc.).

    ['path']: Acessamos apenas a parte do caminho do array retornado por parse_url.

        Por que isso? Se o usuário acessar /contato?id=1, nós queremos rotear apenas para /contato. O parse_url remove o ?id=1.

Linha 21:
    $method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

    $_POST['_method']: Procura por um campo escondido (hidden input) no formulário chamado _method. HTML só suporta nativamente GET e POST. Para fazer um DELETE ou PUT (comum em APIs ou frameworks modernos), costuma-se enviar um POST com um campo extra dizendo "trate isso como DELETE".

    ?? (Null Coalescing Operator): Este operador significa "Se o valor da esquerda existir e não for nulo, use-o. Caso contrário, use o da direita".

    $_SERVER['REQUEST_METHOD']: O método HTTP real da requisição (GET, POST, etc.).

        Resumo: "Se alguém enviou um método falso via POST, use ele. Se não, use o método real do navegador".

Linha 23:
    $router->route($uri, $method);

    $router: O objeto que criado na linha 17.

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

