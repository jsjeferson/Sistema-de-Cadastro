<?php
require_once 'classes/pessoa.php';

?>

<?php

//Alterarações para commit

class Conexao{
	private $pdo;
	private $msgErro="";
	private $nome;
	private $host;
	private $usuario;
	private $senha;

	public function __construct($nome,$host,$usuario,$senha){
		$this->nome = $nome;
		$this->host = $host;
		$this->usuario = $usuario;
		$this->senha = $senha;
	}

	public  function getPdo(){
		 return $this->pdo;
	}
	public  function getMsgErro(){
		 return $this->msgErro;
	}

	public  function conectar ()
	{
		try {
			$this->pdo = new PDO("mysql:dbname=".$this->nome.";host=".$this->host,$this->usuario,$this->senha);
		} catch (PDOException $e) {
			
			global $msgErro; 
			$msgErro = $e->getMessage();
		}
	}

    public  function queryBd ($pdo)
	{
		$buscaPessoa = $pdo->prepare("SELECT id_pessoa, nome FROM pessoa");
		$buscaPessoa->execute();
		$resultado = $buscaPessoa->fetchall(PDO::FETCH_ASSOC);

		foreach ($resultado as $_resultado) {

			$pessoa = new Pessoa;
			$pessoa->setID($_resultado["id_pessoa"]);
			$pessoa->setNomeCompleto($_resultado["nome"]);

			$buscaEndereco = $pdo->prepare("SELECT rua,cidade,cep,uf FROM endereco WHERE id_pessoa = :id");
			$buscaEndereco->bindvalue(":id",$_resultado["id_pessoa"]);
			$buscaEndereco->execute();
			$endereco = $buscaEndereco->fetchall(PDO::FETCH_ASSOC);
			$addEnderecos = $pessoa->getEnderecos();
			foreach ($endereco as $_endereco) {

				$addEnderecos[] = $_endereco;

			}
			$pessoa->setEnderecos($addEnderecos);
			$arrayDePessoas[] = $pessoa;
		}
		return $arrayDePessoas;
	}
}
?>