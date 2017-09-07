<?php

class Database
{
	private $conexao;
	private $dsn;
	private $user;
	private $password;

	public function __construct()
	{
		$this->dsn = 'mysql:dbname=cindb;host=127.0.0.1';
		$this->user = 'root';
		$this->password = 'Leozinho580';
	}

	public function abrirConexao()
	{
		if(is_null($this->conexao))
		{
			$this->conexao = new PDO($this->dsn, $this->user, $this->password);
			if (!$this->conexao) {
				die("Erro ao abrir a conexão!");
			}
			return;
		}
		die("Erro ao abrir a conexão!");
	}

	public function fecharConexao()
	{
		$this->conexao = null;
	}

	public function getConexao()
	{
		return $this->conexao;
	}
}

?>
