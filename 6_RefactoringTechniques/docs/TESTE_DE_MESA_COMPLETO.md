# 📋 Teste de Mesa Completo - Sistema de Notas

**Data:** 3 de março de 2026  
**Projeto:** 6_RefactoringTechniques  
**Objetivo:** Entender completamente como o sistema funciona em uma operação de CRIAR, VISUALIZAR e DELETAR uma nota

---

## 📚 Índice

1. [Visão Geral da Arquitetura](#visão-geral-da-arquitetura)
2. [Pré-requisitos e Configuração](#pré-requisitos-e-configuração)
3. [Fluxo de Requisição (REQUEST LIFECYCLE)](#fluxo-de-requisição)
4. [Teste de Mesa - CRIAR UMA NOTA](#teste-de-mesa---criar-uma-nota)
5. [Teste de Mesa - VISUALIZAR UMA NOTA](#teste-de-mesa---visualizar-uma-nota)
6. [Teste de Mesa - DELETAR UMA NOTA](#teste-de-mesa---deletar-uma-nota)
7. [Resumo Visual](#resumo-visual)

---

## 🏗️ Visão Geral da Arquitetura

Este projeto segue o padrão **MVC (Model-View-Controller)** com **Front Controller** pattern.

### Componentes Principais:

```
┌─────────────────────────────────────────────────────────┐
│                   BROWSER / CLIENT                      │
│              (Faz requisição HTTP)                      │
└──────────────────────┬──────────────────────────────────┘
                       │ Requisição HTTP
                       ↓
┌─────────────────────────────────────────────────────────┐
│         /public/index.php (FRONT CONTROLLER)            │
│       ← ENTRADA ÚNICA para todas as requisições →       │
└──────────────────────┬──────────────────────────────────┘
                       │
                       ↓
        ┌──────────────────────────────────┐
        │   ROUTER (Core\Router)           │
        │  - Verifica a URI                │
        │  - Verifica o Método HTTP        │
        │  - Encontra a rota correspondente│
        └──────────────────────┬───────────┘
                               │
                               ↓
        ┌──────────────────────────────────┐
        │   CONTROLLER (Http\controllers)  │
        │  - Processa a lógica             │
        │  - Valida dados                  │
        │  - Acessa o banco de dados       │
        └──────────────────────┬───────────┘
                               │
                               ↓
        ┌──────────────────────────────────┐
        │   VIEW (views/)                  │
        │  - Exibe o resultado             │
        │  - HTML renderizado              │
        └──────────────────────┬───────────┘
                               │
                               ↓
┌─────────────────────────────────────────────────────────┐
│              RESPOSTA HTML ao BROWSER                   │
└─────────────────────────────────────────────────────────┘
```

---

## 🔧 Pré-requisitos e Configuração

### Banco de Dados
```sql
-- Tabela de notas (notes)
CREATE TABLE notes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    body TEXT NOT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Configuração do Projeto
- **Banco de dados:** myApp
- **Host:** localhost
- **Porta:** 3306
- **Charset:** utf8mb4
- **Usuário atual (simulado):** ID = 1

---

## 🔄 Fluxo de Requisição

### O que acontece quando você acessa uma URL?

```
1. Browser envia: GET /notes
   ↓
2. Servidor redireciona para: /public/index.php
   ↓
3. index.php executa:
   - Inicia a sessão
   - Carrega o autoloader
   - Extrai URI e METHOD de $_SERVER
   ↓
4. Router.php recebe:
   - URI: "/notes"
   - METHOD: "GET"
   ↓
5. Router percorre todas as rotas registradas e encontra:
   $router->get('/notes', 'notes/index.php')
   ↓
6. Controller /Http/controllers/notes/index.php é executado
   ↓
7. View /views/notes/index.view.php é renderizada
   ↓
8. HTML é enviado de volta ao browser
```

---

## 🎯 Teste de Mesa - CRIAR UMA NOTA

Vamos acompanhar passo a passo o que acontece quando um usuário clica em "Criar Nota".

### ETAPA 1: Exibir Formulário de Criação

**O que o usuário faz:** Acessa `http://localhost/notes/create`

#### 1.1 → Browser envia a requisição
```
HTTP GET /notes/create
```

#### 1.2 → Chega em `/public/index.php`
```php
<?php
session_start();                    // Inicia a sessão do usuário
const BASE_PATH = __DIR__.'/../';  // Define BASE_PATH = /.../ 6_RefactoringTechniques/

require BASE_PATH.'Core/functions.php'; // Carrega funções auxiliares

spl_autoload_register(function ($class) { // Autoloader
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    require base_path("{$class}.php");
});

require base_path('bootstrap.php'); // Carrega o container e DB

$router = new \Core\Router();       // Cria o roteador
$routes = require base_path('routes.php'); // Carrega as rotas

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];  // Extrai: "/notes/create"
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD']; // Extrai: "GET"

$router->route($uri, $method); // Passa para o router
```

**O que foi feito:**
- ✅ Sessão iniciada
- ✅ Autoloader pronto (quando precisarmos carregar uma classe, ele faz automaticamente)
- ✅ Container criado (permite injeção de dependência)
- ✅ URI extraída: `/notes/create`
- ✅ Método HTTP extraído: `GET`

#### 1.3 → Router processa a requisição
```php
// Em Core/Router.php - método route()
public function route($uri, $method)
{
    foreach ($this->routes as $route) {
        if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
            // Encontrou a rota!
            Middleware::resolve($route['middleware']);
            return require base_path('Http/controllers/' . $route['controller']);
        }
    }
    $this->abort(); // Se não encontrar, aborta com 404
}
```

**O router procura em todas as rotas registradas:**

```php
// routes.php
$router->get('/notes/create', 'notes/create.php');  // ← ENCONTRADA!
```

**Detalhes técnicos:**
- `$route['uri']` = `"/notes/create"`
- `$uri` = `"/notes/create"`
- `strtoupper($method)` = `"GET"`
- `$route['method']` = `"GET"`
- ✅ Condição atende! Executa o controller

#### 1.4 → Controller é executado
```php
// Http/controllers/notes/create.php
<?php
view("notes/create.view.php", [
    'heading' => 'Create Note'
]);
```

**O que acontece:**
```php
function view($path, $attributes = [])
{
    extract($attributes); // $heading = "Create Note"
    require base_path('views/' . $path); // Carrega a view
}
```

A view `views/notes/create.view.php` recebe a variável `$heading` e renderiza o HTML com um formulário.

#### 1.5 → HTML é enviado ao browser
```html
<form method="POST" action="/notes">
    <textarea name="body" placeholder="Escreva sua nota..."></textarea>
    <button type="submit">Salvar Nota</button>
</form>
```

**Resultado:** ✅ Usuário vê o formulário vazio pronto para digitar

---

### ETAPA 2: Submeter o Formulário

**O que o usuário faz:** Digita "Minha primeira nota!" e clica em "Salvar Nota"

#### 2.1 → Browser envia os dados
```
HTTP POST /notes
Content-Type: application/x-www-form-urlencoded

body=Minha+primeira+nota%21
```

Nos termos do PHP:
```php
$_POST['body'] = "Minha primeira nota!"
```

#### 2.2 → Chega em `/public/index.php`
```php
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];  // Extrai: "/notes"
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD']; // Extrai: "POST"
```

#### 2.3 → Router processa
```php
// routes.php
$router->post('/notes', 'notes/store.php'); // ← ENCONTRADA!
```

O router encontra a rota:
- `$route['uri']` = `"/notes"`
- `$uri` = `"/notes"`
- `$route['method']` = `"POST"`
- `strtoupper($method)` = `"POST"`
- ✅ Condição atende!

#### 2.4 → Controller `/Http/controllers/notes/store.php` é executado

```php
<?php
use Core\App;
use Core\Validator;
use Core\Database;

$db = App::resolve(Database::class); // Obtém instância do banco
$errors = [];

// ===== VALIDAÇÃO =====
if (! Validator::string($_POST['body'], 1, 1000)) {
    $errors['body'] = 'A body of no more than 1,000 characters is required.';
}

// Se houver erros, volta para o formulário
if (! empty($errors)) {
    return view("notes/create.view.php", [
        'heading' => 'Create Note',
        'errors' => $errors
    ]);
}

// ===== INSERÇÃO NO BANCO DE DADOS =====
$db->query('INSERT INTO notes(body, user_id) VALUES(:body, :user_id)', [
    'body' => $_POST['body'],        // "Minha primeira nota!"
    'user_id' => 1                   // ID do usuário logado
]);

// ===== REDIRECIONAMENTO =====
header('location: /notes');  // Redireciona para listar as notas
die();
```

**Vamos detalhar cada parte:**

##### 2.4.1 Obter o banco de dados
```php
$db = App::resolve(Database::class);
```

O que acontece internamente:
```php
// bootstrap.php
$container = new Container();
$container->bind('Core\Database', function () {
    $config = require base_path('config.php');
    return new Database($config['database']);
});
App::setContainer($container);
```

Resultado: `$db` é uma instância da classe `Database` conectada ao MySQL.

##### 2.4.2 Validar os dados
```php
if (! Validator::string($_POST['body'], 1, 1000)) {
    $errors['body'] = 'A body of no more than 1,000 characters is required.';
}
```

**Nosso caso:** `"Minha primeira nota!"` tem 22 caracteres
- ✅ Está entre 1 e 1000 caracteres
- ✅ É uma string
- ✅ Validação passa!

`$errors` continua vazio: `[]`

##### 2.4.3 Inserir no banco de dados
```php
$db->query(
    'INSERT INTO notes(body, user_id) VALUES(:body, :user_id)', 
    [
        'body' => $_POST['body'],
        'user_id' => 1
    ]
);
```

**O que acontece em `Database::query()`:**
```php
public function query($query, $params = [])
{
    // $query = "INSERT INTO notes(body, user_id) VALUES(:body, :user_id)"
    // $params = ['body' => 'Minha primeira nota!', 'user_id' => 1]
    
    $this->statement = $this->connection->prepare($query);
    // PDO prepara a query (proteção contra SQL Injection)
    
    $this->statement->execute($params);
    // Executa com os parâmetros substituídos
    
    return $this;
}
```

**SQL executado no banco:**
```sql
INSERT INTO notes(body, user_id) VALUES('Minha primeira nota!', 1)
```

**Resultado no banco:**
```
id │ body                    │ user_id │ created_at
───┼─────────────────────────┼─────────┼──────────────────────
 1 │ Minha primeira nota!    │ 1       │ 2026-03-03 14:30:00
```

##### 2.4.4 Redirecionar o usuário
```php
header('location: /notes');
die();
```

O servidor envia uma resposta HTTP:
```
HTTP 302 Found
Location: /notes
```

O browser automaticamente acessa `/notes` (nova requisição GET).

**Resultado:** ✅ Nota inserida no banco, usuário vê a lista de notas

---

## 🎯 Teste de Mesa - VISUALIZAR UMA NOTA

**O que o usuário faz:** Clica na nota que acabou de criar

### ETAPA 1: Browser acessa
```
HTTP GET /note?id=1
```

### ETAPA 2: Chega em `/public/index.php`
```php
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
// Resultado: "/note"
// Nota: o ?id=1 é REMOVIDO por parse_url

$method = $_SERVER['REQUEST_METHOD']; // "GET"
```

### ETAPA 3: Router encontra a rota
```php
// routes.php
$router->get('/note', 'notes/show.php'); // ← ENCONTRADA!
```

### ETAPA 4: Controller `/Http/controllers/notes/show.php` executa
```php
<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$currentUserId = 1; // ID do usuário logado

// ===== BUSCAR A NOTA NO BANCO =====
$note = $db->query('select * from notes where id = :id', [
    'id' => $_GET['id'] // $_GET['id'] = "1"
])->findOrFail();

// Resultado da query:
// $note = [
//     'id' => 1,
//     'body' => 'Minha primeira nota!',
//     'user_id' => 1,
//     'created_at' => '2026-03-03 14:30:00'
// ]

// ===== VERIFICAR AUTORIZAÇÃO =====
authorize($note['user_id'] === $currentUserId);
// $note['user_id'] = 1
// $currentUserId = 1
// 1 === 1 → true
// ✅ Autorizado! Continua a execução
```

**O que a função `authorize()` faz:**
```php
function authorize($condition, $status = Response::FORBIDDEN)
{
    if (! $condition) {
        abort($status); // Se false, aborta com código 403 (Acesso Negado)
    }
    return true;
}
```

No nosso caso, como o usuário é o dono da nota, ele tem permissão.

### ETAPA 5: Mostrar a nota
```php
view("notes/show.view.php", [
    'heading' => 'Note',
    'note' => $note
]);
```

A view recebe `$note` e renderiza:
```html
<h1>Note</h1>
<p><?= htmlspecialchars($note['body']); ?></p>
<p>Criado em: <?= $note['created_at']; ?></p>
<!-- Botão para deletar -->
<form method="POST" action="/note">
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="id" value="<?= $note['id']; ?>">
    <button type="submit">Deletar Nota</button>
</form>
```

**Resultado:** ✅ Usuário vê o conteúdo da nota e um botão para deletar

---

## 🎯 Teste de Mesa - DELETAR UMA NOTA

**O que o usuário faz:** Clica no botão "Deletar Nota"

### ETAPA 1: Browser submete o formulário
```
HTTP POST /note

_method=DELETE
id=1
```

### ETAPA 2: Chega em `/public/index.php`
```php
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
// Resultado: "/note"

$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
// $_POST['_method'] existe? SIM! = "DELETE"
// $method = "DELETE"
```

**Explicação do `??` (Null Coalescing Operator):**
```
valor_esquerda ?? valor_direita

Se valor_esquerda é null ou não existe, usa valor_direita.
Caso contrário, usa valor_esquerda.

Exemplo:
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

Se $_POST['_method'] = "DELETE" → $method = "DELETE"
Se $_POST['_method'] não existe → $method = $_SERVER['REQUEST_METHOD']
```

### ETAPA 3: Router encontra a rota
```php
// routes.php
$router->delete('/note', 'notes/destroy.php'); // ← ENCONTRADA!
```

O router verifica:
- `$route['uri']` = `"/note"`
- `$uri` = `"/note"`
- `strtoupper($method)` = `strtoupper("DELETE")` = `"DELETE"`
- `$route['method']` = `"DELETE"`
- ✅ Tudo coincide!

### ETAPA 4: Controller `/Http/controllers/notes/destroy.php` executa
```php
<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$currentUserId = 1; // ID do usuário logado

// ===== BUSCAR A NOTA PARA VERIFICAR A AUTORIZAÇÃO =====
$note = $db->query('select * from notes where id = :id', [
    'id' => $_POST['id'] // $_POST['id'] = "1"
])->findOrFail();

// Resultado:
// $note = [
//     'id' => 1,
//     'body' => 'Minha primeira nota!',
//     'user_id' => 1,
//     'created_at' => '2026-03-03 14:30:00'
// ]

// ===== VERIFICAR SE O USUÁRIO É O DONO DA NOTA =====
authorize($note['user_id'] === $currentUserId);
// 1 === 1 → true
// ✅ Autorizado! Pode deletar

// ===== DELETAR A NOTA DO BANCO =====
$db->query('delete from notes where id = :id', [
    'id' => $_POST['id'] // $_POST['id'] = "1"
]);

// SQL executado:
// DELETE FROM notes WHERE id = 1

// Resultado no banco:
// A linha com id=1 é removida
```

**Estado do banco antes:**
```
id │ body                    │ user_id
───┼─────────────────────────┼─────────
 1 │ Minha primeira nota!    │ 1
```

**Estado do banco depois:**
```
id │ body │ user_id
───┼──────┼─────────
(vazio)
```

### ETAPA 5: Redirecionar o usuário
```php
header('location: /notes');
exit();
```

O servidor envia:
```
HTTP 302 Found
Location: /notes
```

Browser acessa `/notes` (lista de notas).

**Resultado:** ✅ Nota deletada do banco, usuário redireciona para a lista (agora vazia)

---

## 📊 Resumo Visual

### Fluxo Completo de Uma Transação

```
┌──────────────────────────────────────────────────────────────────┐
│                    CRIAR UMA NOTA                                 │
└──────────────────────────────────────────────────────────────────┘

1️⃣  GET /notes/create
    ↓
    Browser vê: Formulário vazio
    $_GET = []
    $_POST = []

2️⃣  Usuário preenche: "Minha primeira nota!"
    POST /notes
    $_POST = ['body' => 'Minha primeira nota!', '_method' => null]
    ↓
    Validação: ✅ Strings válidas (1-1000 caracteres)
    ↓
    INSERT INTO notes(body, user_id) VALUES('Minha primeira nota!', 1)
    ↓
    Banco: id=1 criado com sucesso
    ↓
    Redireciona para: /notes
    Browser vê: Lista de notas (agora com 1 nota)

┌──────────────────────────────────────────────────────────────────┐
│                    VISUALIZAR UMA NOTA                            │
└──────────────────────────────────────────────────────────────────┘

3️⃣  GET /note?id=1
    ↓
    Query: SELECT * FROM notes WHERE id = 1
    ↓
    Resultado: $note = [id => 1, body => 'Minha primeira nota!', ...]
    ↓
    Autorização: user_id (1) === currentUserId (1) ✅
    ↓
    Browser vê: Conteúdo da nota + Botão deletar

┌──────────────────────────────────────────────────────────────────┐
│                    DELETAR UMA NOTA                               │
└──────────────────────────────────────────────────────────────────┘

4️⃣  POST /note com _method=DELETE
    $_POST = ['_method' => 'DELETE', 'id' => 1]
    ↓
    $method = "DELETE"
    ↓
    Query: SELECT * FROM notes WHERE id = 1 (verificar dono)
    ↓
    Autorização: user_id (1) === currentUserId (1) ✅
    ↓
    Query: DELETE FROM notes WHERE id = 1
    ↓
    Banco: Nota deletada com sucesso
    ↓
    Redireciona para: /notes
    Browser vê: Lista vazia (nota foi deletada)
```

---

## 🔑 Conceitos-Chave Explicados

### 1. **Front Controller**
Significa que **TODAS** as requisições passam por um único arquivo (`/public/index.php`). Isso centraliza:
- Inicialização
- Validação de segurança
- Roteamento

### 2. **Roteamento**
O Router recebe a URI e o método HTTP e encontra qual controller deve executar.

```php
$router->get('/notes', 'notes/index.php');
// Significa: "Se vier GET para /notes, execute o controller notes/index.php"
```

### 3. **Validação**
Antes de inserir dados no banco, sempre validamos:
```php
if (! Validator::string($_POST['body'], 1, 1000)) {
    // Rejeita se não for uma string entre 1 e 1000 caracteres
}
```

### 4. **Autorização**
Verificamos se o usuário tem permissão para acessar/modificar um recurso:
```php
authorize($note['user_id'] === $currentUserId);
// Só o dono da nota pode deletá-la
```

### 5. **Injeção de Dependência (Dependency Injection)**
```php
$db = App::resolve(Database::class);
// Em vez de criar o banco aqui, pedimos para o Container nos fornecer
```

Vantagens:
- Fácil testar (pode substituir por versão fake)
- Fácil mudar a configuração em um lugar
- Desacoplamento

### 6. **Prepared Statements (Query Parametrizada)**
```php
$db->query('INSERT INTO notes(body, user_id) VALUES(:body, :user_id)', [
    'body' => $_POST['body'],
    'user_id' => 1
]);
```

Por que é importante:
- Protege contra **SQL Injection**
- O banco sabe exatamente o que é dado e o que é comando SQL

---

## 🎓 Diagrama de Classes

```
┌────────────────────────────────────────────┐
│         Core\Container                     │
│  - Armazena dependências                   │
│  + bind(name, callback)                    │
│  + resolve(name)                           │
└────────────────────────────────────────────┘
                    ↓
        (Dentro do Container)
                    ↓
┌────────────────────────────────────────────┐
│         Core\Database                      │
│  - Conecta ao MySQL via PDO                │
│  + query(sql, params)                      │
│  + get() → retorna array de resultados     │
│  + find() → retorna um resultado           │
│  + findOrFail() → ou lance erro            │
└────────────────────────────────────────────┘

┌────────────────────────────────────────────┐
│         Core\Router                        │
│  - Roteia requisições para controllers     │
│  + get(uri, controller)                    │
│  + post(uri, controller)                   │
│  + delete(uri, controller)                 │
│  + patch(uri, controller)                  │
│  + put(uri, controller)                    │
│  + route(uri, method)                      │
│  + only(middleware)                        │
└────────────────────────────────────────────┘

┌────────────────────────────────────────────┐
│         Core\Validator                     │
│  - Valida entrada de dados                 │
│  + string(value, min, max)                 │
│  + email(value)                            │
│  + (e outros métodos de validação)         │
└────────────────────────────────────────────┘
```

---

## 💾 Exemplo de Dados no Banco

**Tabela: notes**

| id | body                    | user_id | created_at          |
|----|-------------------------|---------|---------------------|
| 1  | Minha primeira nota!    | 1       | 2026-03-03 14:30:00 |
| 2  | Segunda nota            | 1       | 2026-03-03 14:35:15 |
| 3  | Nota de outro usuário   | 2       | 2026-03-03 14:40:30 |

**Se o usuário com ID 1 tenta deletar a nota 3:**
```php
authorize($note['user_id'] === $currentUserId);
// 2 === 1 → false
// ❌ Acesso negado! Aborta com erro 403
```

---

## 🧪 Teste Prático

Se você quiser testar na prática, aqui está o passo a passo:

### 1. Criar uma nota
```
URL: http://localhost/notes/create
Método: GET
Esperado: Formulário aparece
```

### 2. Submeter a nota
```
URL: http://localhost/notes
Método: POST
Dados: body = "Teste de nota"
Esperado: Redireciona para /notes
         Nota aparece na lista
```

### 3. Visualizar a nota
```
URL: http://localhost/note?id=1
Método: GET
Esperado: Conteúdo da nota aparece
         Botão deletar disponível
```

### 4. Deletar a nota
```
URL: http://localhost/note
Método: POST com _method=DELETE
Dados: id = 1
Esperado: Redireciona para /notes
         Nota desaparece da lista
         Banco atualizado
```

---

## 🚀 Fluxo Resumido (TL;DR)

| Ação | URL | Método | Controller | O que faz |
|------|-----|--------|-----------|-----------|
| Ver formulário | `/notes/create` | GET | `notes/create.php` | Mostra formulário vazio |
| Criar nota | `/notes` | POST | `notes/store.php` | Valida e insere no banco |
| Visualizar nota | `/note?id=1` | GET | `notes/show.php` | Busca no banco e mostra |
| Deletar nota | `/note` | POST(DELETE) | `notes/destroy.php` | Valida dono e deleta |

---

## 📝 Notas Importantes

1. **Autoloader automático:** Quando você usa `new \Core\Router()`, o autoloader (linha 9 do index.php) carrega automaticamente o arquivo `Core/Router.php`.

2. **O `??` operator:** Muito usado para fornecer valores padrão. Muito importante entender em PHP moderno.

3. **Prepared Statements:** SEMPRE use `:param` em queries para evitar SQL Injection.

4. **Autorização é crítica:** Nunca confie em dados do cliente. Sempre verifique se o usuário tem permissão.

5. **HTTP 302 Redirect:** Quando você faz `header('location: ...')`, o servidor envia um código 302 que faz o browser fazer uma nova requisição.

---

## 🎯 Conclusão

Este projeto demonstra os **fundamentos essenciais** de uma aplicação web moderna:

✅ **Separação de responsabilidades** (MVC)  
✅ **Roteamento centralizado** (Front Controller)  
✅ **Validação de entrada** (Validator)  
✅ **Proteção contra SQL Injection** (Prepared Statements)  
✅ **Controle de acesso** (Autorização)  
✅ **Injeção de dependência** (Container)  

Parabéns! Você agora entende como uma aplicação PHP moderna funciona! 🎉

---

**Criado em:** 3 de março de 2026  
**Última atualização:** Este documento
