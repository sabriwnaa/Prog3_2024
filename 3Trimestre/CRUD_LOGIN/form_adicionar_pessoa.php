<?php
    //Verifica se o botão foi clicado
    if(isset($_POST['botao'])){
        
        //Sanitiza as variáveis recebidas
        $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
        //existe validate também, para verificar se o email existe
        $senha = htmlspecialchars($_POST['senha']);
        //torna todo caractere especial em código ascci 
        
        //Conecta com o banco
        $db = new mysqli('localhost','root','','colecao_livros');
        
        //Gera uma variável criptografada
        $password_hash = password_hash($_POST['senha'],PASSWORD_BCRYPT);
        //criptografias mais usadas: bcrypy,  argon2I e argon2D

        //Prepara a query, colocando interrogações para preparar e colocar os valores depois
        $stmt = $db->prepare("insert into pessoas (email,senha) values (?,?)");
        
        /* Insere as variáveis de forma segura
          ss é String String
          https://www.php.net/manual/pt_BR/mysqli-stmt.bind-param.php
        */
         $stmt->bind_param("ss",$email,$password_hash);

        //Executa o statement
        $stmt->execute();

        //Redireciona
        header("location: index.php");
    }   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Pessoa</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
    <div class='container'>
        <div class='box'>
            <h1>Adicionar pessoa</h1>
            <form method='post' action='form_adicionar_pessoa.php'>
                <label>E-mail:</label>
                <input type='text' name='email' require>
                <label>Senha:</label>
                <input type='password' name='senha' require>
                <div class='grupo_botao'>
                    <input type='submit' name='botao' value='Adicionar'>
                </div>
                <a href='index.php'>Voltar</a>
            </form>
        </div>
    </div>
</body>
</html>