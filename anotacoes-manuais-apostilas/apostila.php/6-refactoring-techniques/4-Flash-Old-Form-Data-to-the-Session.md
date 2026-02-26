# Laracasts: Refactoring Techniques (5)
## 4. Flash Old Form Data to the Session

Nesta aula, resolvemos o problema de "limpeza" do formulário após uma falha de validação. Com o padrão **PRG (Post-Redirect-Get)**, os dados do `$_POST` são perdidos no redirecionamento, o que prejudica a experiência do usuário (UX), pois ele teria que digitar tudo de novo.

---

### 1. O Problema: O Desaparecimento dos Dados
Anteriormente, como retornávamos a `view` diretamente no `POST`, podíamos acessar `$_POST['email']` para repopular o campo. Agora, com o **Redirect**, a requisição seguinte é um **GET**, e o array `$_POST` está vazio.

---

### 2. A Solução: Flashing "Old" Input
A estratégia é salvar os dados enviados no formulário dentro da sessão temporária (`_flash`) antes de redirecionar.

#### No Controller (`SessionController@store`)
Antes de redirecionar o usuário de volta por erro de validação, salvamos o que ele digitou:

~~~PHP
if (! $form->validate($email, $password)) {
    // Salvamos os erros (visto na aula anterior)
    Session::flash('errors', $form->errors());
    
    // NOVIDADE: Salvamos os dados antigos (exceto a senha, por segurança)
    Session::flash('old', [
        'email' => $_POST['email']
    ]);

    return redirect('/login');
}
~~~

---

### 3. Criando o Helper `old()`
Para facilitar o acesso a esses dados na View sem ter que escrever caminhos longos da sessão, o instrutor cria uma função global de ajuda.

**No arquivo `functions.php`:**
~~~PHP
function old($key, $default = '')
{
    // Busca na sessão o que foi guardado na chave 'old'
    // Se não existir, retorna o valor padrão (geralmente vazio)
    return Core\Session::get('old')[$key] ?? $default;
}
~~~

---

### 4. Atualizando a View
Agora, a nossa View fica muito mais limpa e legível. Utilizamos a função `old()` diretamente no atributo `value` dos inputs.

**No arquivo `login.view.php`:**
~~~PHP
<input 
    type="email" 
    name="email" 
    id="email" 
    value="<?= old('email') ?>" 
    class="..." 
    required
>
~~~

---

### 5. Caso de Uso: Valores Padrão no `old()`
O instrutor menciona que o segundo parâmetro da função `old()` é útil para formulários de **edição**, onde você quer mostrar o dado que já está no banco de dados, a menos que o usuário tenha tentado alterar e a validação tenha falhado.

**Exemplo teórico:**
~~~PHP
// Se houver dado antigo de uma tentativa falha, usa ele. 
// Caso contrário, usa o e-mail do usuário que veio do banco.
<input value="<?= old('email', $user->email) ?>">
~~~

---

### Resumo Técnico:
1. **UX (User Experience):** Evitamos que o usuário perca o trabalho de digitação em campos longos.
2. **Abstração:** A função `old()` esconde a complexidade de onde o dado está vindo (se é da sessão ou de um valor padrão).
3. **Padrão Laravel:** Esse é exatamente o comportamento da função `old()` no framework Laravel profissional.



---
*Dica: No seu projeto de registro de militares, essa função será essencial para o campo de "Observações" ou "Endereço", que são textos longos e frustrantes de digitar novamente.*
