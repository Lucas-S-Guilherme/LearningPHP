# Laracasts: Refactoring Techniques (5)
## 1-Extract-a-Form-Validation-Object

Este episódio foca em mover a lógica de validação, que muitas vezes "polui" os nossos controllers, para uma classe dedicada (um **Form Object**). Isso melhora a clareza do código e separa as responsabilidades.

---

### 1. Filosofia do Refactoring: Clareza e Criatividade
O instrutor (Jeffrey Way) começa discutindo que programar é um ato de comunicação. 
* Se você mostrar seu código para outra pessoa, ela entenderá sua intenção?
* O código reflete sua criatividade ou é apenas procedural?
* Refatorar é o processo de experimentar caminhos para tornar o código mais expressivo para o "seu eu do futuro" e para sua equipe.

---

### 2. Reorganização de Pastas: O diretório `Http`
Antes de criar o objeto de formulário, o instrutor decide organizar melhor a estrutura do projeto. 
* **O Problema:** A pasta `core` deve conter código de infraestrutura (roteador, banco de dados, container) que poderia ser usado em qualquer projeto.
* **A Solução:** Coisas específicas da aplicação (como Controllers e Forms) devem morar em um lugar próprio. Ele cria a pasta `Http`.

**Nova estrutura sugerida:**
* `Http/controllers/`
* `Http/Forms/`

---

### 3. Ajustando o Router (Convenções)
Ao mover os controllers para `Http/controllers`, as rotas quebrariam. Em vez de atualizar o caminho completo em cada rota, ele altera o `router.php` para assumir esse caminho por padrão.

No arquivo de rotas (`routes.php`), removemos o prefixo repetitivo:
~~~PHP
$router->get('/', 'index.php');
$router->get('/about', 'about.php');
~~~

E no `router.php`, injetamos o caminho base:
~~~PHP
public function route($uri, $method) {
    foreach ($this->routes as $route) {
        if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
            // Adicionando o caminho base 'Http/controllers/' automaticamente
            return require base_path('Http/controllers/' . $route['controller']);
        }
    }
    // ... abort
}
~~~

---

### 4. Criando a Classe `LoginForm`
A ideia é encapsular a validação do login. O instrutor discute se essa classe deveria retornar uma `view`, mas decide que não: a responsabilidade do Form Object é apenas **validar** e **informar erros**.

**Localização:** `Http/Forms/LoginForm.php`

~~~PHP
<?php

namespace Http\Forms;

use Core\Validator;

class LoginForm
{
    protected $errors = [];

    public function validate($email, $password)
    {
        if (!Validator::email($email)) {
            $this->errors['email'] = 'Por favor, forneça um endereço de e-mail válido.';
        }

        if (!Validator::string($password)) {
            $this->errors['password'] = 'Por favor, forneça uma senha válida.';
        }

        // Retorna true se não houver erros
        return empty($this->errors);
    }

    // "Getter" para acessar os erros de fora da classe
    public function errors()
    {
        return $this->errors;
    }
}
~~~

---

### 5. Refatorando o Controller (`SessionController@store`)
Agora, o controller fica muito mais limpo. Ele não precisa saber *como* validar, apenas pede para o formulário fazer isso.

~~~PHP
<?php

use Http\Forms\LoginForm;

$email = $_POST['email'];
$password = $_POST['password'];

// 1. Instancia o objeto de formulário
$form = new LoginForm();

// 2. Tenta validar
if (! $form->validate($email, $password)) {
    // 3. Se falhar, retorna a view com os erros obtidos pelo getter
    return view('sessions/create.view.php', [
        'errors' => $form->errors()
    ]);
}

// 4. Se passar, segue com a tentativa de login...
// (Lógica de autenticação aqui)
~~~

---

### Conceitos Chave Aprendidos:

1.  **Separação de Preocupações (Separation of Concerns):** O Controller decide *o que* fazer (redirecionar ou mostrar erro), mas o Form Object decide *se* os dados são válidos.
2.  **Getters:** O uso do método `errors()` para acessar uma propriedade `protected`. Isso dá controle sobre como os dados saem da classe.
3.  **Flexibilidade:** Se amanhã você precisar mudar a regra de validação da senha, você muda em um único lugar (`LoginForm.php`) e todos os controllers que usam esse form serão atualizados.

---