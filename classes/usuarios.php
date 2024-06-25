<?php

class Usuario 
{

	function cadastrar ($nome,$telefone,$email,$senha,$pdo)
	{
		
		$sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e");
		$sql->bindvalue(":e",$email);
		$sql->execute();
		if($sql->rowCount() > 0){
			return false;
		}else{

			$sql = $pdo -> prepare("INSERT INTO usuarios(nome,telefone,email,senha) VALUES
			(:n,:t,:e,:s) ");
			$sql->bindvalue(":n",$nome);
			$sql->bindvalue(":t",$telefone);
			$sql->bindvalue(":e",$email);
			$sql->bindvalue(":s",md5($senha));
			$sql->execute();
			return true;
		}
	}


	function logar ($email,$senha,$pdo)
	{
		
		$sql = $pdo->prepare("SELECT id_usuario FROM usuarios 
			WHERE email = :e AND senha = :s");
		$sql->bindvalue(":e",$email);
		$sql->bindvalue(":s",md5($senha));
		$sql->execute();
		if($sql->rowCount() > 0){
			$dado = $sql->fetch();
			session_start();
			$_SESSION['id_usuario'] = $dado['id_usuario'];
			return true;
		}else{
			return false;
		}
	}
}

?>