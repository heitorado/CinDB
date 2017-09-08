<?php
require_once "Database.php";

class DbFuncoes
{
      public $database;
      public $tabela;

      function __construct($tabela)
      {
            $this->database = new Database();
            $this->tabela = $tabela;
      }

      public function insert($dados)
      {
            $query = "INSERT INTO " . $this->tabela . " (";

            foreach ($dados as $key => $value) {
                  $query .= $key . ", ";
            }
            $query = substr_replace($query, ")",-2);

            $query .= " VALUES (";

            foreach ($dados as $key => $value) {
                  $query .= ":" . $key . ", ";
            }
            $query = substr_replace($query, ");",-2);

            $this->database->abrirConexao();
            $dbh = $this->database->getConexao();

            $dbh->beginTransaction();

            $stmt = $dbh->prepare($query);

            foreach ($dados as $key => $value) {
                  $stmt->bindParam(":".$key, $value);
            }

            $status = $stmt->execute();

            if ($status) {
                  $dbh->commit();
            }else {
                  $dbh->rollBack();
            }

            $this->database->fecharConexao();

            return $status;
      }

      public function select($campos = null, $whereClause = null, $whereValue = null, $fetchStyle = PDO::FETCH_BOTH)
      {
            if (is_null($campos)) {
                  $campos = "*";
            }
            if (is_null($whereClause) && is_null($whereValue))
            {
                  $whereClause = "1 = 1";
            }
            elseif((is_null($whereClause) && !is_null($whereValue)) ||
            (!is_null($whereClause) && is_null($whereValue)))
            {
                  die('$whereClause e $whereValue devem ser preenchidos juntos!');
            }

            $query = "SELECT " . $campos . " FROM " . $this->tabela . " WHERE " . $whereClause;
            $this->database->abrirConexao();
            $dbh = $this->database->getConexao();

            $stmt = $dbh->prepare($query);

            if (!is_null($whereClause) && !is_null($whereValue))
            {
                  foreach ($whereValue as $key => $value)
                  {
                        $stmt->bindParam(":".$key, $value);
                  }
            }

            $stmt->execute();

            $result = $stmt->fetchAll($fetchStyle);
            $this->database->fecharConexao();

            return $result;
      }

      public function delete($whereClause, $whereValue)
      {
            $query = "DELETE FROM " . $this->tabela . " WHERE " . $whereClause;

            $this->database->abrirConexao();
            $dbh = $this->database->getConexao();

            $stmt = $dbh->prepare($query);

            foreach ($whereValue as $key => $value)
            {
                  $stmt->bindParam(":".$key, $value);
            }

            $status = $stmt->execute();
            $this->database->fecharConexao();

            return $status;
      }
}
