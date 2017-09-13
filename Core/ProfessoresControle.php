<?php
// CLASSE RESPONSAVEL COM GERENCIAR OS PROCESSOS DA PAGINA "gerenciador_professores.php"

require_once "db/Database.php";
require_once "Template.php";

// CASO A CONDIÇÃO SEJA VERDADEIRA, ELE REALIZA O INSERT
if (isset($_POST['nome']) && isset($_POST['cadastrar'])) {
      $professoresControle = new ProfessoresControle();
      $professoresControle->insertProfessores();
}

if (isset($_POST['nome']) && isset($_POST['modificar'])) {
      $professoresControle = new ProfessoresControle();
      $professoresControle->updateProfessor();
}

if (isset($_POST['buscarProfessor'])) {
      $professoresControle = new ProfessoresControle();
      echo $professoresControle->getProfessor();
}

// CASO A CONDIÇÃO SEJA VERDADEIRA, ELE REALIZA O DELETE
if (isset($_GET['delete'])) {
      $professoresControle = new ProfessoresControle();
      $professoresControle->deleteProfessores();
}

class ProfessoresControle
{
      public $idprofessor;
      public $nome;
      public $status;

      // CRIA A INSTANCIA DA CLASSE DbFuncoes PASSANDO A TABELA QUE VAI MANIPULAR.
      function __construct()
      {
            $this->dbFun = new Database("cindb","localhost", "root", "Leozinho580");
      }

      // REALIZA A INCLUSAO DE UM PROFESSOR
      public function insertProfessores()
      {
            // PEGA AS CADEIRAS SELECIONADAS
            $cadeiras = [];
            if(isset($_POST['cadeiras']))
            {
                  foreach ($_POST['cadeiras'] as $check) {
                        array_push($cadeiras,$check);
                  }
            }
            $this->dbFun->transaction();

            // FILTRA O QUE FOI DIGITADO RETIRANDO TAGS DO CARACTER
            $this->nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $query = "INSERT INTO professores (nome) VALUES (:nome)";

            $this->status = $this->dbFun->insert($query,[":nome" => $this->nome]);

            if (sizeof($cadeiras) > 0 && $this->status)
            {
                  $this->idprofessor = $this->dbFun->lastInsertId();
                  $query = "INSERT INTO professores_has_cadeiras VALUES (?,?)";

                  foreach ($cadeiras as $key => $value)
                  {
                        $this->status = $this->dbFun->insert($query,[$this->idprofessor,$value]);
                        if (!$this->status) {
                              exit;
                        }
                  }
            }

            // REDIRECIONA INDICANDO SUCESSO OU FALHA
            if (!$this->status) {
                  $this->dbFun->rollBack();
                  header("Location:../App/Administracao/gerenciador_professores.php?insertStatus=false");
            }else {
                  $this->dbFun->commit();
                  header("Location:../App/Administracao/gerenciador_professores.php?insertStatus=true");
            }
      }

      public function updateProfessor()
      {
            // PEGA AS CADEIRAS SELECIONADAS
            $cadeiras = [];
            if(isset($_POST['cadeiras']))
            {
                  foreach ($_POST['cadeiras'] as $check) {
                        array_push($cadeiras,$check);
                  }
            }
            $this->dbFun->transaction();

            // FILTRA O QUE FOI DIGITADO RETIRANDO TAGS DO CARACTER
            $this->nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $this->idprofessor = filter_input(INPUT_POST, 'idprofessor', FILTER_SANITIZE_STRING);

            $query = "UPDATE professores SET nome = :nome WHERE idprofessor = :idprofessor";

            $this->status = $this->dbFun->update($query,[":nome" => $this->nome, ":idprofessor" => $this->idprofessor]);
            if ($this->status) {
                  $query = "DELETE FROM professores_has_cadeiras WHERE professores_idprofessor = :idprofessor";
                  $this->status = $this->dbFun->delete($query, [":idprofessor" => $this->idprofessor]);
            }

            if (sizeof($cadeiras) > 0 && $this->status)
            {
                  $query = "INSERT INTO professores_has_cadeiras VALUES (?,?)";

                  foreach ($cadeiras as $key => $value)
                  {
                        $this->status = $this->dbFun->insert($query,[$this->idprofessor,$value]);

                        if (!$this->status) {
                              exit;
                        }
                  }
            }

            // REDIRECIONA INDICANDO SUCESSO OU FALHA
            if (!$this->status) {
                  $this->dbFun->rollBack();
                  header("Location:../App/Administracao/gerenciador_professores.php?updateStatus=false");
            }else {
                  $this->dbFun->commit();
                  header("Location:../App/Administracao/gerenciador_professores.php?updateStatus=true");
            }
      }

      // REALIZA A EXCLUSAO DE UM PROFESSOR
      public function deleteProfessores()
      {
            $this->idprofessor = filter_input(INPUT_GET, 'delete', FILTER_SANITIZE_STRING);
            $this->dbFun->transaction();
            $query = "DELETE FROM professores_has_cadeiras WHERE professores_idprofessor = :idprofessor";
            $this->status = $this->dbFun->delete($query, [":idprofessor" => $this->idprofessor]);

            if ($this->status) {
                  $query = "DELETE FROM professores WHERE idprofessor = :idprofessor";
                  $this->status = $this->dbFun->delete($query, [":idprofessor" => $this->idprofessor]);
            }

            // REDIRECIONA INDICANDO SUCESSO OU FALHA
            if (!$this->status) {
                  $this->dbFun->rollBack();
                  header("Location:../App/Administracao/gerenciador_professores.php?deleteStatus=false");
            }else {
                  $this->dbFun->commit();
                  header("Location:../App/Administracao/gerenciador_professores.php?deleteStatus=true");
            }
      }

      // BUSCA TODOS O PROFESSORES
      public function getProfessores()
      {
            $query = "SELECT idprofessor, " .
            " professores.nome, " .
            " (SELECT group_concat(cadeiras.nome separator ', ')" .
            " FROM cadeiras, professores_has_cadeiras" .
            " WHERE professores_idprofessor = idprofessor" .
            " AND idcadeiras = cadeiras_idcadeiras" .
            " ) AS cadeiras" .
            " FROM professores;";
            $dados = $this->dbFun->select($query);
            //var_dump($dados);
            return $dados;
      }

      public function getProfessor()
      {
            $this->idprofessor = filter_input(INPUT_POST, 'buscarProfessor', FILTER_SANITIZE_STRING);

            $query = "SELECT idprofessor, " .
            " professores.nome, " .
            " (SELECT group_concat(cadeiras.idcadeiras separator ', ')" .
            " FROM cadeiras, professores_has_cadeiras" .
            " WHERE professores_idprofessor = idprofessor" .
            " AND idcadeiras = cadeiras_idcadeiras" .
            " ) AS cadeiras" .
            " FROM professores" .
            " WHERE idprofessor = ?";
            $dados = $this->dbFun->select($query, [$this->idprofessor], false);
            //var_dump($dados);
            return json_encode($dados);
      }

      public function getCadeiras()
      {
            return $this->dbFun->select("SELECT * FROM cadeiras");
      }

      // CARREGA A PARTE SUPERIOR DO TEMPLATE
      public function renderHeader()
      {
            $template = new Template("../../App/Administracao/_templateHeader.php");
            $template->set("path", "../..");
            $template->set("title", "CinDB");
            echo $template->output();
      }

      // CARREGA A PARTE INFERIOR DO TEMPLATE
      public function renderFooter()
      {
            $template = new Template("../../App/Administracao/_templateFooter.php");
            $template->set("path", "../..");
            echo $template->output();
      }


}
