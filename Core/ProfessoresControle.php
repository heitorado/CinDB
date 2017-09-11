<?php
// CLASSE RESPONSAVEL COM GERENCIAR OS PROCESSOS DA PAGINA "gerenciador_professores.php"

require_once "db/Database.php";
require_once "Template.php";

// CASO A CONDIÇÃO SEJA VERDADEIRA, ELE REALIZA O INSERT
if (isset($_POST['nome']) && isset($_POST['cadastrar'])) {
      $professoresControle = new ProfessoresControle();
      $professoresControle->insertProfessores();
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
            // FILTRA O QUE FOI DIGITADO RETIRANDO TAGS DO CARACTER
            $this->nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $query = "INSERT INTO professores (nome) VALUES (:nome)";
            $this->status = $this->dbFun->insert($query,[":nome" => $this->nome]);

            // REDIRECIONA INDICANDO SUCESSO OU FALHA
            if (!$this->status) {
                  header("Location:../App/Administracao/gerenciador_professores.php?insertStatus=false");
            }else {
                  header("Location:../App/Administracao/gerenciador_professores.php?insertStatus=true");
            }


      }

      // REALIZA A EXCLUSAO DE UM PROFESSOR
      public function deleteProfessores()
      {
            $this->idprofessor = filter_input(INPUT_GET, 'delete', FILTER_SANITIZE_STRING);
            $query = "DELETE FROM professores WHERE idprofessor = :idprofessor";

            $this->status = $this->dbFun->delete($query, [":idprofessor" => $this->idprofessor]);

            // REDIRECIONA INDICANDO SUCESSO OU FALHA
            if (!$this->status) {
                  header("Location:../App/Administracao/gerenciador_professores.php?deleteStatus=false");
            }else {
                  header("Location:../App/Administracao/gerenciador_professores.php?deleteStatus=true");
            }
      }

      // BUSCA TODOS O PROFESSORES
      public function getProfessores()
      {
            return $this->dbFun->select("SELECT * FROM professores");
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
