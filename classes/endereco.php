<?php

class Endereco{

	private $rua;
	private $cep;
	private $cidade;
	private $UF;


	public function getRua(){
		return $this->rua;
	}

	public function setRua($rua){
		$this->rua = $rua;
	}

	public function getCep(){
		return $this->cep;
	}

	public function setCep($cep){
		$this->cep = $cep;
	}

	public function getCidade(){
		return $this->cidade;
	}

	public function setCidade($cidade){
		$this->cidade = $cidade;
	}

	public function getUf(){
		return $this->UF;
	}

	public function setUf($UF){
		$this->UF = $UF;
	}

	function cadastrarEndereco ($rua,$cidade,$cep,$UF,$identidade,$pdo)
	{
		$sql = $pdo->prepare("SELECT id_pessoa FROM pessoa WHERE identidade = :i");
		$sql->bindvalue(":i",$identidade);
		$sql->execute();
		$id_pessoa = $sql->fetch();


			$sql = $pdo -> prepare("INSERT INTO endereco(rua,cidade,cep,uf,id_pessoa) VALUES
			(:r,:c,:cep,:u,:id)");
			$sql->bindvalue(":r",$rua);
			$sql->bindvalue(":c",$cidade);
			$sql->bindvalue(":cep",$cep);
			$sql->bindvalue(":u",$UF);
			$sql->bindvalue(":id",$id_pessoa[0]);
			$sql->execute();
			return true;
	}

	function cadastrarNovoEndereco ($rua,$cidade,$cep,$UF,$id_pessoa,$pdo)
	{
	
			$sql = $pdo -> prepare("INSERT INTO endereco(rua,cidade,cep,uf,id_pessoa) VALUES
			(:r,:c,:cep,:u,:id)");
			$sql->bindvalue(":r",$rua);
			$sql->bindvalue(":c",$cidade);
			$sql->bindvalue(":cep",$cep);
			$sql->bindvalue(":u",$UF);
			$sql->bindvalue(":id",$id_pessoa);
			$sql->execute();
	}

}

?>