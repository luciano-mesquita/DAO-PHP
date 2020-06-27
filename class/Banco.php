<?php

// Classe que trata questões relacionadas ao banco de dados
// Herda da classe PDO

class Banco extends PDO {

	private $conn;

	// Método construtor. Inicia a conexão no ato da instância
	public function __construct() {

		// Configurações do banco de dados
		$this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", "root", "");
	}

	// Método que recebe vários parametros de uma vez
	private function setParams($statement, $parameters = array()) {

		foreach ($parameters as $key => $value) {

			$this->setParam($statement, $key, $value);
		}
	}

	// Método que recebe um parametro por vez e associa com bindParam
	private function setParam($statement, $key, $value) {

		$statement->bindParam($key, $value);
	}

	// Método que executa a ação no banco de dados e retorna
	public function query($rawQuery, $params = array()) {

		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);

		$stmt->execute();

		return $stmt;
	}

	// Método que seleciona dados no banco
	public function	select($rawQuery, $params = array()):array {

		$stmt = $this->query($rawQuery, $params);

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}