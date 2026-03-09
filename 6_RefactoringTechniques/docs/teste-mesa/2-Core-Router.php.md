Sua observação foi fantástica! Você acabou de esbarrar em um dos conceitos mais cruciais da Orientação a Objetos: o Estado do Objeto (Object State).

Você está certíssimo: o arquivo Router.php começa com um array totalmente vazio (protected $routes = [];). E o arquivo routes.php não envia nenhum array pronto para ele.

O segredo aqui é: o routes.php não cria as rotas por conta própria. Ele usa a variável $router para injetar os dados dentro daquele array vazio, um por um.

Vamos fazer o teste de mesa cronológico para você ver a mágica acontecendo. Tudo se resume a 3 passos antes de chegar na varredura:
Passo 1: A Criação do Objeto (A "Caixa Vazia")

Voltamos ao seu index.php. Olhe para esta linha:
PHP

$router = new \Core\Router();

Neste exato milissegundo, o PHP vai lá no arquivo Core/Router.php, lê a planta da casa e constrói o objeto na memória.
Nesse momento, a propriedade interna $this->routes é criada, e ela é de fato um array vazio [].

A variável $router no seu index.php agora segura esse objeto (imagine que $router é um carrinho de compras vazio).
Passo 2: O Escopo do require (Levando o carrinho para a loja)

A linha imediatamente abaixo no seu index.php é:
PHP

$routes = require base_path('routes.php');

No PHP, quando você usa o require, o arquivo que está sendo "puxado" herda todas as variáveis que existem naquele momento.
Isso significa que o arquivo routes.php consegue enxergar e usar a variável $router que você acabou de criar na linha de cima!
Passo 3: O Preenchimento (Colocando itens no carrinho)

Agora o PHP entra no arquivo routes.php. A primeira linha dele é:
PHP

$router->get('/', 'index.php');

Ele pega aquele mesmo objeto $router (que tem o array vazio dentro dele) e chama o método get().

Se você olhar lá no Core/Router.php, o método get() faz o seguinte:
PHP

public function get($uri, $controller)
{
    return $this->add('GET', $uri, $controller);
}

Ele simplesmente repassa a bola para o método add(), avisando que o método HTTP é 'GET'. E aqui está o "Pulo do Gato", o método add:
PHP

public function add($method, $uri, $controller)
{
    $this->routes[] = [
        'uri' => $uri,
        'controller' => $controller,
        'method' => $method,
        'middleware' => null
    ];

    return $this;
}

Preste muita atenção nesta sintaxe: $this->routes[] = [...]
Em PHP, quando você coloca colchetes vazios [] logo após o nome de um array e usa o sinal de igual =, você está fazendo um Push (adicionando um item no final da lista).

Então:

    O array $this->routes que estava vazio [], agora ganha a rota da página inicial /.

    O routes.php continua lendo a próxima linha: $router->get('/about', 'about.php');

    O método add é chamado de novo. O array ganha o segundo item.

    E isso se repete para cada linha do seu routes.php.

O Resultado Final

Quando o PHP termina de ler o arquivo routes.php inteiro e volta para o index.php, aquela variável $router original não é mais uma "caixa vazia". O array interno dela ($this->routes) agora é uma lista gigante cheia de arrays associativos com as URLs, Controllers e Métodos de todo o seu sistema.

É por isso que, lá na última linha do index.php, quando você roda:
PHP

$router->route($uri, $method);

O método route() pode fazer o foreach ($this->routes as $route). Ele está varrendo o array que o arquivo routes.php acabou de preencher!

Fez sentido como a variável $router serviu como uma "ponte" para popular o array interno da classe antes do loop acontecer? Quer que eu explique agora o que acontece quando a rota tem o modificador ->only('auth') pendurado no final dela?