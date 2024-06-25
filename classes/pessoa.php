<?php

class Pessoa{
	private $id;
	private $nomeCompleto;
	private $identidade;
	private $dataDeNascimento;
	private $enderecos;

	public function __construct(){
		$this->enderecos = array();
	}

	public function getEnderecos(){
		 return $this->enderecos;
	}

	public function setEnderecos($endereco){
		 $this->enderecos = $endereco;
	}

	public function getID(){
		return $this->id;
	}

	public function setID($id){
		$this->id = $id;
	}

	public function getNomeCompleto(){
		return $this->nomeCompleto;
	}

	public function setNomeCompleto($nome){
		$this->nomeCompleto = $nome;
	}

	public function getIdentidade(){
		return $this->identidade;
	}

	public function setIdentidade($id){
		$this->identidade = $id;
	}

	public function getDataDeNascimento(){
		return $this->dataDeNascimento;
	}
	public function setDataDeNascimento($data){
		$this->dataDeNascimento = $data;
	}

	function cadastrarPessoa ($nomeCompleto,$identidade,$dataNascimento,$pdo)
	{

		$sql = $pdo->prepare("SELECT id_pessoa FROM pessoa WHERE identidade = :i");
		$sql->bindvalue(":i",$identidade);
		$sql->execute();
		if($sql->rowCount() > 0){
			return false;
		}else{

			$sql = $pdo -> prepare("INSERT INTO pessoa(nome,identidade,data_nascimento) VALUES
			(:n,:i,:d)");
			$sql->bindvalue(":n",$nomeCompleto);
			$sql->bindvalue(":i",$identidade);
			$sql->bindvalue(":d",$dataNascimento);
			$sql->execute();
			return true;
		}
	}


}

?>