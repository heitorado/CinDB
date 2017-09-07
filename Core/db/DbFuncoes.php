<?php
require_once "Database.php";

class DbFuncoes
{
      public $database;

      function __construct()
      {
            $this->database = new Database();
      }

      public function insert($tabela, $dados)
      {
            $status;
            $query = "INSERT INTO " . $tabela . " (";

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
}
