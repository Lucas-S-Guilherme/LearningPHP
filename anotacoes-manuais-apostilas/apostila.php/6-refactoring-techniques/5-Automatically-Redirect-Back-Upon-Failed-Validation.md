# Laracasts: Refactoring Techniques (5)
## 5. Automatically Redirect Back Upon Failed Validation

Nesta aula, o Jeffrey Way ensina uma técnica avançada para limpar drasticamente os Controllers: usar **Exceptions** para automatizar o redirecionamento e o preenchimento de erros na sessão.

---

### 1. A Motivação do Refactoring
Em aplicações reais, você terá dezenas de formulários (login, registro, perfil, comentários). Repetir a lógica de `if (falhou) { flash errors; redirect; }` em todos os controllers torna o código repetitivo e difícil de manter. 

**O objetivo:** Fazer com que o Controller apenas diga "Valide isso". Se falhar, o sistema cuida do resto automaticamente.

---

### 2. Mudando a API: Validação Estática
O instrutor transforma o método `validate` em um "construtor estático". Em vez de instanciar o formulário manualmente, fazemos tudo em uma linha passando um array de atributos.

**No arquivo `Http/Forms/LoginForm.php`:**
~~~PHP
<?php

namespace Http\Forms;

use Core\ValidationException;
// ... outras importações

class LoginForm
{
    protected $errors = [];

    public function __construct(public array $attributes)
    {
        // A validação acontece no momento da criação do objeto
        if (!Validator::email($attributes['email'])) {
            $this->errors['email'] = 'E-mail inválido.';
        }
        // ... outras regras
    }

    public static function validate($attributes)
    {
        $instance = new static($attributes);

        // Se falhar, chamamos um método que lança uma exceção personalizada
        return $instance->failed() ? $instance->throw() : $instance;
    }

    public function failed()
    {
        return count($this->errors);
    }

    public function throw()
    {
        // Lançamos a exceção passando os erros e os dados antigos (attributes)
        ValidationException::throw($this->errors, $this->attributes);
    }
    
    public function error($field, $message)
    {
        $this->errors[$field] = $message;
        return $this; // Permite encadeamento (chaining)
    }

    public function errors()
    {
        return $this->errors;
    }
}
~~~

---

### 3. A Exceção Personalizada (`ValidationException`)
Criamos uma exceção que herda da classe base do PHP, mas que consegue carregar nossos erros e dados antigos.

**No arquivo `Core/ValidationException.php`:**
~~~PHP
<?php

namespace Core;

class ValidationException extends \Exception
{
    protected $errors = [];
    protected $old = [];

    public static function throw($errors, $old)
    {
        $instance = new static;
        $instance->errors = $errors;
        $instance->old = $old;

        throw $instance;
    }

    public function getErrors() { return $this->errors; }
    public function getOld() { return $this->old; }
}
~~~

---

### 4. O "Pulo do Gato": Try-Catch no Front Controller
Em vez de colocar `try-catch` em cada controller, movemos essa lógica para o `public/index.php`. Assim, **qualquer** controller que lançar uma `ValidationException` causará um redirecionamento automático.



**No arquivo `public/index.php`:**
~~~PHP
try {
    $router->route($uri, $method);
} catch (Core\ValidationException $exception) {
    // Se qualquer parte da aplicação lançar um erro de validação:
    Core\Session::flash('errors', $exception->getErrors());
    Core\Session::flash('old', $exception->getOld());

    // Redireciona de volta para a página anterior usando o Referer do servidor
    return redirect($router->previousUrl());
}
~~~

---

### 5. O Controller Refatorado (`SessionController@store`)
Compare como o código ficou limpo. Não há mais condicionais de erro para a validação inicial.

~~~PHP
<?php

use Http\Forms\LoginForm;
use Core\Authenticator;

// 1. Valida (Se falhar, a exceção é lançada e o index.php intercepta)
$form = LoginForm::validate($attributes = [
    'email' => $_POST['email'],
    'password' => $_POST['password']
]);

// 2. Tenta autenticar
$signedIn = (new Authenticator)->attempt(
    $attributes['email'], 
    $attributes['password']
);

// 3. Se a senha estiver errada, adicionamos o erro manualmente e lançamos a exceção
if (! $signedIn) {
    $form->error('email', 'Credenciais inválidas.')
         ->throw();
}

// 4. Se chegou aqui, deu tudo certo
redirect('/');
~~~

---

### Resumo Técnico:
1.  **Delegar, não Microgerenciar:** O Controller agora é um "gerente". Ele delega a validação e a autenticação. Se algo der errado, as classes lançam exceções.
2.  **Uso de `HTTP_REFERER`:** No Router, criamos o método `previousUrl()` para saber de onde o usuário veio e mandá-lo de volta para lá.
3.  **Encadeamento de Métodos:** O uso de `return $this` no método `error()` permite fazer `$form->error(...)->throw()`.

---
*Dica: Essa estrutura aproxima muito o seu código do que o Laravel faz com os "Form Requests".*