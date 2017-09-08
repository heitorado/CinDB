<?php
require_once "db/DbFuncoes.php";

if (isset($_POST['nome']) && isset($_POST['cadastrar'])) {
      $professoresControle = new ProfessoresControle();
      $professoresControle->insertProfessores();
}

if (isset($_GET['delete'])) {
      $professoresControle = new ProfessoresControle();
      $professoresControle->deleteProfessores();
}

class ProfessoresControle
{
      public $idprofessor;
      public $nome;
      public $status;

      function __construct()
      {
            $this->dbFun = new DbFuncoes("professores");
      }

      public function insertProfessores()
      {
            $this->nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);

            $this->status = $this->dbFun->insert(["nome" => $this->nome]);

            if (!$this->status) {
                  header("Location:../App/Administracao/gerenciador_professores.php?insertStatus=false");
            }else {
                  header("Location:../App/Administracao/gerenciador_professores.php?insertStatus=true");
            }


      }

      public function deleteProfessores()
      {
            $this->idprofessor = filter_input(INPUT_GET, 'delete', FILTER_SANITIZE_STRING);

            $this->status = $this->dbFun->delete("professores","idprofessor = :idprofessor", ["idprofessor" => $this->idprofessor]);

            if (!$this->status) {
                  header("Location:../App/Administracao/gerenciador_professores.php?deleteStatus=false");
            }else {
                  header("Location:../App/Administracao/gerenciador_professores.php?deleteStatus=true");
            }
      }

      public function getProfessores()
      {
            return $this->dbFun->select("professores", "*", null, null, PDO::FETCH_ASSOC);
      }


}
