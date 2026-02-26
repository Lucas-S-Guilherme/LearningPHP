# Laracasts: Refactoring Techniques (5)
## 3. The PRG Pattern (and Session Flashing)

Nesta aula, resolvemos um problema comum em formulários: o reenvio de dados ao atualizar a página e a persistência de erros antigos.

---

### 1. O Problema: Retornar View em requisições POST
Quando a validação falha e fazemos um `view('login.view.php')` dentro de um método `POST`, o navegador permanece em uma requisição POST. 
* **Problema 1:** Se o usuário der F5, o navegador pergunta: "Deseja reenviar os dados do formulário?".
* **Problema 2:** Se ele navegar para outra página e voltar, pode ver a mensagem "Documento Expirado".
* **Problema 3:** Os erros ficam "presos" naquela resposta específica.

---

### 2. O Padrão PRG (Post-Redirect-Get)
Para resolver isso, usamos o padrão PRG:
1. **P (POST):** O usuário envia o formulário.
2. **R (Redirect):** O servidor processa e, em vez de mostrar a página, envia um redirecionamento.
3. **G (GET):** O navegador faz uma nova requisição GET para a página de destino.



---

### 3. O Desafio: Persistência de Erros (Session Flashing)
Ao redirecionar (Redirect), perdemos os dados da requisição anterior (os erros de validação). A solução é usar a **Sessão**, mas de forma temporária.
* **Flash Data:** Dados que vivem na sessão por apenas **uma** requisição e depois são excluídos automaticamente.

---

### 4. Criando a Classe de Ajuda `Session`
O instrutor cria uma classe `Core\Session` para encapsular a manipulação da superglobal `$_SESSION`.

**Localização:** `Core/Session.php`

~~~PHP
<?php

namespace Core;

class Session
{
    // Adiciona um dado normal à sessão
    public static function put($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    // Busca um dado (procura primeiro nos "flashed", depois no topo)
    public static function get($key, $default = null)
    {
        return $_SESSION['_flash'][$key] ?? $_SESSION[$key] ?? $default;
    }

    // Verifica se existe a chave
    public static function has($key)
    {
        return (bool) static::get($key);
    }

    // Armazena um dado que deve durar apenas um redirect
    public static function flash($key, $value)
    {
        $_SESSION['_flash'][$key] = $value;
    }

    // Limpa os dados flashed (deve ser chamado no fim do index.php)
    public static function unflash()
    {
        unset($_SESSION['_flash']);
    }

    // Limpa toda a sessão (Logout)
    public static function flush()
    {
        $_SESSION = [];
    }

    // Destrói a sessão completamente (Cookie inclusive)
    public static function destroy()
    {
        static::flush();
        session_destroy();

        $params = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
}
~~~

---

### 5. Implementação no Fluxo da Aplicação

#### No Controller (`SessionController@store`)
Agora, em vez de retornar a view com erros, nós "flashamos" os erros e redirecionamos.

~~~PHP
if (! $form->validate($email, $password)) {
    // Armazena os erros na sessão temporária
    Session::flash('errors', $form->errors());
    
    // Redireciona via GET para a página de login
    return redirect('/login'); 
}
~~~

#### No Ponto de Entrada (`public/index.php`)
Para que o "Flash" funcione, precisamos limpar os dados ao final de cada ciclo de vida da aplicação.

~~~PHP
// ... final do arquivo index.php, após o roteamento
Core\Session::unflash();
~~~



---

### 6. Refatorando o `Authenticator`
Com a nova classe `Session`, o método de logout no Authenticator fica muito mais simples, delegando a responsabilidade de "destruir" para a classe correta.

~~~PHP
// Dentro de Authenticator.php
public function logout()
{
    Session::destroy();
}
~~~

---

### Resumo Técnico:
1. **Separação:** A lógica de como a sessão funciona agora está na classe `Session`, não espalhada pelo código.
2. **Experiência do Usuário (UX):** O usuário pode atualizar a página sem erros de "reenvio de formulário".
3. **Segurança e Organização:** O uso do prefixo `_flash` na sessão evita conflitos com chaves normais de usuário.

---
*Dica para o seu projeto CBMRO: Use o `Session::flash()` para enviar "Mensagens de Sucesso" após cadastrar um militar, como: "Militar cadastrado com sucesso!".*