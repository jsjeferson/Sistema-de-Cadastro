<?php
require_once 'classes/usuarios.php';
$u = new Usuario;
require_once 'classes/conexaoBanco.php';
$conexao = new Conexao("projeto_funag", "localhost", "root", "");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8"/>
    <title>Cadastro usuario</title>
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="css/estilo.css">
    <style>
        *{
            margin: 0px;
            padding: 13px;
        }
    </style>
</head>
<!--<body style="background: #e3eaf5">-->
<body>
<div class="container-fluid">
    <center><h1>Cadastrar Usuário</h1></center>
    <form method="POST">
        <div class="row">
            <div class="col-md-6">
                <label for="nome">Nome</label>
                <input class="form-control" type="text" id="nome" name="nome" placeholder="Nome completo" maxlength="30">
            </div>
            <div class="col-md-6">
                <label for="email">Email</label>
                <input class="form-control" type="email" id="email" name="email" placeholder="Usuário" maxlength="50">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="telefone">Telefone</label>
                <input class="form-control" type="tel" id="telefone" name="telefone" placeholder="Telefone" maxlength="15">
            </div>
            <div class="col-md-4">
                <label for="senha">Senha</label>
                <input class="form-control" type="password" id="senha" name="senha" placeholder="Senha" maxlength="15">
            </div>
            <div class="col-md-4">
                <label for="confSenha">Confirmar Senha</label>
                <input class="form-control" type="password" id="confSenha" name="confSenha" placeholder="Confirmar senha"
                       maxlength="15">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <input type="submit" class="btn btn-success" value="CADASTRAR">
            </div>
        </div>

    </form>
    <?php
    if (isset($_POST['nome'])) {
        $nome = addslashes($_POST['nome']);
        $telefone = addslashes($_POST['telefone']);
        $email = addslashes($_POST['email']);
        $senha = addslashes($_POST['senha']);
        $confirmarSenha = addslashes($_POST['confSenha']);

        if (!empty($nome) && !empty($telefone) && !empty($email)
            && !empty($senha) && !empty($confirmarSenha)) {

            $conexao->conectar();
            if ($conexao->getMsgErro() == "") {
                if ($senha == $confirmarSenha) {

                    if ($u->cadastrar($nome, $telefone, $email, $senha, $conexao->getPdo())) {
                        ?>
                       <center><a style="color: #0000CC" href="index.php">Cadastro realizado com sucesso!&nbsp<strong>Faça o seu login</strong></a></center>
                        <?php
                    } else {
                         ?> <center><b><p style="color: red">Email já cadastrado!</p></b></center> <?php
                    }
                } else {
                    ?> <center><b><p style="color: red">Senha e confirmar senha não correspondem!</p></b></center> <?php
                }
            } else {
                echo "Erro" . $u->msgErro;
            }

        } else { ?>
            <center><b><p style="color: red">Preencha todos os campos!</p></b></center>
        <?php }
    }
    ?>

    <script>
        function mascara(o,f){
            v_obj=o
            v_fun=f
            setTimeout("execmascara()",1)
        }
        function execmascara(){
            v_obj.value=v_fun(v_obj.value)
        }
        function mtel(v){
            v=v.replace(/\D/g,""); //Remove tudo o que não é dígito
            v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
            v=v.replace(/(\d)(\d{4})$/,"$1-$2"); //Coloca hífen entre o quarto e o quinto dígitos
            return v;
        }
        function id( el ){
            return document.getElementById( el );
        }
        window.onload = function(){
            id('telefone').onkeyup = function(){
                mascara( this, mtel );
            }
        }
    </script>
</body>
</div>
</html>