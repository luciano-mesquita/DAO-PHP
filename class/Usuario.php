<?php

class Usuario {

	private $id;
	private $nome;
	private $email;
	private $senha;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getNome() {
		return $this->nome;
	}

	public function setNome($nome) {
		$this->nome = $nome;
	}

	public function getEmail() {
		return $this->email;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function getSenha() {
		return $this->senha;
	}

	public function setSenha($senha) {
		$this->senha = $senha;
	}

	// Pega os dados de um usuário no banco e carrega a classe
	public function loadById($id) {

		$banco = new Banco();

		$results = $banco->select("SELECT * FROM usuario WHERE id = :ID", array(
			":ID"=>$id
		));

		if (count($results) > 0) {
			
			$row = $results[0];

			$this->setId($row['id']);
			$this->setNome($row['nome']);
			$this->setEmail($row['email']);
			$this->setSenha($row['senha']);
		}
	}

	// Retorna todos os usuários do banco
	public static function getList() {

		$banco = new Banco;

		return $banco->select("SELECT * FROM usuario");
	}

	// Retorna um usuário, filtrando pelo EMAIL
	public static function search($email) {

		$banco = new Banco;

		return $banco->select("SELECT * FROM usuario WHERE email LIKE :SEARCH ORDER BY email", array(
			':SEARCH'=>"%".$email."%"
		));
	}

	// Retorna os dados verificando o login e senha
	public function login($email, $senha) {

		$banco = new Banco();

		$results = $banco->select("SELECT * FROM usuario WHERE email = :EMAIL AND senha = :SENHA", array(
			":EMAIL"=>$email,
			":SENHA"=>$senha
		));

		if (count($results) > 0) {
			
			$row = $results[0];

			$this->setId($row['id']);
			$this->setNome($row['nome']);
			$this->setEmail($row['email']);
			$this->setSenha($row['senha']);
		
		} else {

			throw new Exception("Login e/ou senha inválidos");	
		}
	}

	// Insere dados e chama procedure
	public function insert() {

		$banco = new Banco();

		$results = $banco->select("CALL sp_usuario_insert(:NOME, :EMAIL, :SENHA)", array(
			':NOME'=>$this->getNome(),
			':EMAIL'=>$this->getEmail(),
			':SENHA'=>$this->getSenha()
		));
	}

	// Atualiza um registro
	public function update($email, $senha) {

		$this->setEmail($email);
		$this->setSenha($senha);

		$banco = new Banco();

		$banco->query("UPDATE usuario SET nome = :NOME, email = :EMAIL, senha = :SENHA WHERE id = :ID", array(
			':ID'=>$this->getId(),
			':NOME'=>$this->getNome(),
			':EMAIL'=>$this->getEmail(),
			':SENHA'=>$this->getSenha()
		));
	}

	// Retorna um JSON com os dados de um determinado usuário
	public function __toString() {

		$dados = json_encode(array(
			"id"=>$this->getId(),
			"nome"=>$this->getNome(),
			"email"=>$this->getEmail(),
			"senha"=>$this->getSenha()
		));

		return $dados;
	}

	// Remove um registro do banco
	public function delete() {

		$banco = new Banco();

		$banco->query("DELETE FROM usuario WHERE id = :ID", array(

			':ID'=>$this->getId()
		));

		$this->setId(0);
		$this->setNome("");
		$this->setEmail("");
		$this->setSenha("");
	}
}