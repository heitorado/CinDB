<?php

/**
*  CLASSE RESPONSAVEL POR CRIAR A CONEXÃO COM O BANCO DE DADOS, ABRIR E FECHAR CONEXÃO
**/
class Database
{
	// VARIAVEIS PRIVADAS, EVITANDO MANIPUÇÃO EM OUTRO LUGAR
	private $conexao;
	private $dsn;
	private $user;
	private $password;

	// INICIALIZA AS VARIAVEIS DA CONEXÃO. ESSES VALORES TAMBEM PODEM SER PASSADOS COMO PARAMETRO
	// NA HORA DE INSTANCIAR A CLASSE (PARA ISSO COLOCAR OS PARAMETROS NO __construct).
	public function __construct($dbname, $host = "127.0.0.1", $user = "root", $password = "")
	{
		$this->dsn = "mysql:dbname=$dbname;host=$host";
		$this->user = $user;
		$this->password = $password;

		$this->abrirConexao();
	}

	// ABRE A CONEXAO COM O BANCO DE DADOS
	public function abrirConexao()
	{
		if(is_null($this->conexao))
		{
			try {
				$this->conexao = new PDO($this->dsn, $this->user, $this->password);
				$this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				throw new Exception($e->getMessage());
			}
		}
	}

	// FECHA A CONEXÃO COM O BANCO DE DADOS
	public function fecharConexao()
	{
		$this->conexao = null;
	}

	public function select($query, $params = [], $fetchAll = true)
	{
		try
		{
			$stmt = $this->conexao->prepare($query);
			$stmt->execute($params);
			if ($fetchAll)
			{
				return $stmt->fetchAll();
			}else {
				return $stmt->fetch();
			}
		}
		catch (PDOException $e)
		{
			throw new Exception($e->getMessage());
		}
	}

	public function insert($query, $params = [])
	{
		if (strpos($query, "INSERT") !== false) {
			return $this->dataManager($query, $params);
		}else {
			die("Query não é um 'INSERT'");
		}
	}

	public function update($query, $params = [])
	{
		if (strpos($query, "UPDATE") !== false) {
			return $this->dataManager($query, $params);
		}else {
			die("Query não é um 'UPDATE'");
		}
	}

	public function delete($query, $params = [])
	{
		if (strpos($query, "DELETE") !== false) {
			return $this->dataManager($query, $params);
		}else {
			die("Query não é um 'DELETE'");
		}
	}

	private function dataManager($query, $params = [])
	{
		try
		{
			$stmt = $this->conexao->prepare($query);
			return $stmt->execute($params);
		}
		catch (PDOException $e)
		{
			throw new Exception($e->getMessage());
		}
	}

	public function transaction()
	{
		$this->conexao->beginTransaction();
	}

	public function commit()
	{
		$this->conexao->commit();
	}

	public function rollBack()
	{
		$this->conexao->rollBack();
	}
}

?>
