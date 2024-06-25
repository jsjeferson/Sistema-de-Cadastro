	<?php
		require_once 'classes/usuarios.php';
		$u = new Usuario;
		require_once 'classes/conexaoBanco.php';
		$conexao = new Conexao("projeto_funag","localhost","root","");
	?>

	<!DOCTYPE html>
	<html lang="pt-br">
	<head>
		<meta charset="utf-8"/>
		<title>Login usuario</title>
        <link rel="stylesheet" href="css/estilo.css">
        <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.css">


	</head>
	<body class="bg">
		<div id="corpo-form">
		<h1>Entrar</h1>
		<form method="POST">
			<input class="form-control" type="email" placeholder="E-mail" name="email" maxlength="50">
			<input class="form-control" type="password" placeholder="Senha" name="senha" maxlength="15">
			<input type="submit" class="btn btn-primary" value="ACESSAR">
			<a href="cadastro.php">Ainda não possui cadastro?<strong>&nbspCadastre-se
			</strong></a>
		</form>
		</div>

		    <?php

			if(isset($_POST['email']))
			{
				$email = addslashes($_POST['email']);
				$senha = addslashes($_POST['senha']);
			
				if(!empty($email) && !empty($senha)){
					$conexao->conectar();
					if($conexao->getMsgErro() == ""){
						if($u->logar($email,$senha,$conexao->getPdo())){
								header("location: telaDeCadastro.php");
						}else{
							?>
							<div class="msg-erro">
							Email e/ou senha incorretos!
							</div>
							<?php
						}
					}else{
						?>
							<div class="msg-erro">
								<?php echo "Erro".$conexao->getMsgErro();?>
							</div>
						<?php
					}
				}else{
						?>
							<div class="msg-erro">
								Preencha todos os campos!
							</div>
						<?php
				}
			}
		?>
	</body>
	</html>