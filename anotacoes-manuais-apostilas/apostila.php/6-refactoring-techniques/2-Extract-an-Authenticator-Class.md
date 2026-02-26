# Laracasts: Refactoring Techniques (5)
## 2-Extract-an-Authenticator-Class

Nesta aula, o objetivo é continuar limpando o Controller, extraindo a lógica de autenticação (verificar usuário e senha) para uma classe dedicada. Isso remove a responsabilidade de "saber como logar" do Controller.

---

### 1. Criando a Classe `Authenticator`
O instrutor identifica que o Controller está fazendo muitas coisas: buscando o usuário no banco, verificando a senha e gerenciando a sessão. Ele cria a classe `Authenticator` para centralizar isso.

**Localização:** `Core/Authenticator.php` (ou diretório similar de infraestrutura).

O método principal é o `attempt()`, que tenta autenticar o usuário e retorna um Booleano.

~~~PHP
<?php

namespace Core;

class Authenticator
{
    public function attempt($email, $password)
    {
        // Busca o usuário no banco de dados (o DB pode ser injetado ou acessado via App)
        $user = App::resolve(Database::class)->query('select * from users where email = :email', [
            'email' => $email
        ])->find();

        if ($user) {
            // Verifica se a senha fornecida bate com o hash no banco
            if (password_verify($password, $user['password'])) {
                $this->login([
                    'email' => $email
                ]);

                return true;
            }
        }

        return false;
    }

    public function login($user)
    {
        $_SESSION['user'] = [
            'email' => $user['email']
        ];

        session_regenerate_id(true);
    }

    public function logout()
    {
        $_SESSION = [];
        session_destroy();

        $params = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
}
~~~

---

### 2. Criando um Helper Global: `redirect()`
Para evitar repetir `header('location: ...'); exit;` toda vez, o instrutor cria uma função auxiliar simples no arquivo de funções globais.

~~~PHP
function redirect($path)
{
    header("location: {$path}");
    exit;
}
~~~

---

### 3. Melhorando a Classe `LoginForm`
Para evitar duplicação de código no Controller ao lidar com erros de validação vs. erros de autenticação, o instrutor adiciona um método `error()` na classe `LoginForm`. Isso permite adicionar erros manualmente após a validação inicial.

~~~PHP
// Dentro da classe LoginForm...
public function error($field, $message)
{
    $this->errors[$field] = $message;
}
~~~

---

### 4. O Controller Refatorado (`SessionController@store`)
Com as novas classes e helpers, o código do Controller se torna extremamente legível, quase como uma frase em inglês.



~~~PHP
<?php

use Core\Authenticator;
use Http\Forms\LoginForm;

$form = new LoginForm();

// 1. Valida os campos básicos (email e senha preenchidos)
if ($form->validate($_POST['email'], $_POST['password'])) {
    
    // 2. Tenta a autenticação real
    if ((new Authenticator)->attempt($_POST['email'], $_POST['password'])) {
        redirect('/');
    }

    // 3. Se a autenticação falhar, adiciona o erro manualmente ao objeto form
    $form->error('email', 'Nenhuma conta correspondente encontrada para este e-mail e senha.');
}

// 4. Se cair aqui (falha na validação OU na autenticação), volta para a view com os erros
return view('sessions/create.view.php', [
    'errors' => $form->errors()
]);
~~~

---

### Principais Lições deste Refactoring:

1.  **Identificação de Verbos e Substantivos:** "Encontrar o usuário" e "Tentar logar" são ações que pertencem a um `Authenticator` (um autenticador).
2.  **Responsabilidade Única:** O `Authenticator` não sabe nada sobre Views. Ele apenas autentica e retorna `true` ou `false`.
3.  **Tornando Códigos Identicos para Mesclá-los:** O instrutor ensina que, se você tem dois blocos de código quase iguais, tente mudá-los até que fiquem idênticos para que você possa combiná-los em um só fluxo.
4.  **Inlining:** Se você usa uma variável apenas uma vez (como a instância do `Authenticator`), você pode instanciar e chamar o método na mesma linha para limpar o código.

---
*Dica: Esse padrão de Authenticator é muito similar ao que o Laravel faz "por baixo dos panos" com o `Auth::attempt()`. Estudar isso ajuda a entender como frameworks modernos funcionam.*