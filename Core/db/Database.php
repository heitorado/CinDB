<?php

/**
*  CLASSE RESPONSAVEL POR CRIAR A CONEXÃO COM O BANCO DE DADOS, ABRIR E FECHAR CONEXÃO, E REALIZAR AÇÕES NO BANCO
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
	
	// REALIZA O SELECT. PARAMETROS:
	// $query = QUERY PARA O SELECT
	// $params = VALORES. SE A QUERY TIVER '?' COMO PARAMETRO, USAR ARRAY SEM KEY. SE TIVER ':parametro', USAR ARRAY COM KEY COM MESMO PARAMETRO
	// $fetchAll = POR PADRAO BUSCA TODOS. FALSE IRA BUSCAR APENAS 1 RESULTADO
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

	// REALIZA O INSERT. PARAMETROS:
	// $query = QUERY PARA O INSERT
	// $params = VALORES. SE A QUERY TIVER '?' COMO PARAMETRO, USAR ARRAY SEM KEY. SE TIVER ':parametro', USAR ARRAY COM KEY COM MESMO PARAMETRO
	public function insert($query, $params = [])
	{
		if (strpos($query, "INSERT") !== false) {
			return $this->dataManager($query, $params);
		}else {
			die("Query não é um 'INSERT'");
		}
	}

	// REALIZA O UPDATE. PARAMETROS:
	// $query = QUERY PARA O UPDATE
	// $params = VALORES. SE A QUERY TIVER '?' COMO PARAMETRO, USAR ARRAY SEM KEY. SE TIVER ':parametro', USAR ARRAY COM KEY COM MESMO PARAMETRO
	public function update($query, $params = [])
	{
		if (strpos($query, "UPDATE") !== false) {
			return $this->dataManager($query, $params);
		}else {
			die("Query não é um 'UPDATE'");
		}
	}

	// REALIZA O DELETE. PARAMETROS:
	// $query = QUERY PARA O DELETE
	// $params = VALORES. SE A QUERY TIVER '?' COMO PARAMETRO, USAR ARRAY SEM KEY. SE TIVER ':parametro', USAR ARRAY COM KEY COM MESMO PARAMETRO
	public function delete($query, $params = [])
	{
		if (strpos($query, "DELETE") !== false) {
			return $this->dataManager($query, $params);
		}else {
			die("Query não é um 'DELETE'");
		}
	}

	// REALIZA AS MUDANÇAS NO BANCO DE DADOS. PARAMETROS:
	// $query = QUERY PARA O AÇÃO
	// $params = VALORES. SE A QUERY TIVER '?' COMO PARAMETRO, USAR ARRAY SEM KEY. SE TIVER ':parametro', USAR ARRAY COM KEY COM MESMO PARAMETRO
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

	// INICIA A TRANSAÇÃO
	public function transaction()
	{
		$this->conexao->beginTransaction();
	}

	// EFETUA A TRANSAÇÃO
	public function commit()
	{
		$this->conexao->commit();
	}

	// CANCELA A TRANSAÇÃO
	public function rollBack()
	{
		$this->conexao->rollBack();
	}

	// RETORNA O ULTIMO ID
	public function lastInsertId()
	{
		return $this->conexao->lastInsertId();
	}
}

?>
