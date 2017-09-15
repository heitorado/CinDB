<?php
require_once "db/Database.php";

if (isset($_POST['buscarCadeiras'])) {
      $exercicios = new ExerciciosIndexControle();
      echo json_encode($exercicios->getCadeiras());
}

if (isset($_POST['idCadeiraTag'])) {
      $exercicios = new ExerciciosIndexControle();
      echo json_encode($exercicios->getTags());
}

if (isset($_POST['idCadeira'])) {
      $exercicios = new ExerciciosIndexControle();
      echo json_encode($exercicios->getExercicios());
}

/**
*
*/
class ExerciciosIndexControle
{
      public $dbFun;
      function __construct()
      {
            $this->dbFun = new Database("cindb","localhost", "root", "Leozinho580");
      }

      public function getExercicios()
      {
            $param = [];

            $idcadeiras = filter_input(INPUT_POST, 'idCadeira', FILTER_SANITIZE_STRING);
            $idtags = null;
            if ($_POST['idTag'] != "") {
                  $idtags = filter_input(INPUT_POST, 'idTag', FILTER_SANITIZE_STRING);
            }

            $this->dbFun->abrirConexao();
            $query = "SELECT distinct idexercicios, " .
            "      image, " .
            "      enunciado, " .
            "      professores.nome AS professor, " .
            "      cadeiras.nome AS cadeira, " .
            "      (SELECT group_concat(tags.nome separator ', ') " .
            "      FROM tags, exercicios_has_tags " .
            "      WHERE exercicios_idexercicios = idexercicios " .
            "      AND idtags = tags_idtags " .
            ") AS tags ";
            if (!is_null($idtags)){
                  $query .= "FROM exercicios, professores, cadeiras, exercicios_has_tags, tags ";
            }else {
                  $query .= "FROM exercicios, professores, cadeiras, exercicios_has_tags ";
            }
            $query .= "WHERE professores_has_cadeiras_professores_idprofessor = professores.idprofessor " .
            "AND professores_has_cadeiras_cadeiras_idcadeiras = cadeiras.idcadeiras " .
            "AND cadeiras.idcadeiras = ?";

            array_push($param,$idcadeiras);

            if (!is_null($idtags)) {
                  $query .= " AND exercicios_idexercicios = idexercicios" .
                  " AND idtags = tags_idtags" .
                  " AND idtags IN (?)";
                  array_push($param,$idtags);
            }

            $dados = $this->dbFun->select($query, $param);
            $this->dbFun->fecharConexao();

            foreach ($dados as $key => $value) {
                  foreach ($value as $key2 => $value2) {
                        $dados[$key][$key2] = utf8_encode($dados[$key][$key2]);
                  }
            }

            return $dados;
      }

      public function getCadeiras()
      {
            $this->dbFun->abrirConexao();
            $dados = $this->dbFun->select("SELECT * FROM cadeiras");
            $this->dbFun->fecharConexao();

            return $dados;
      }

      public function getTags()
      {
            $idcadeiras = filter_input(INPUT_POST, 'idCadeiraTag', FILTER_SANITIZE_STRING);

            $query = "SELECT idtags, tags.nome " .
            "FROM tags, cadeiras_has_tags " .
            "WHERE tags.idtags = cadeiras_has_tags.tags_idtags ".
            "AND cadeiras_has_tags.cadeiras_idcadeiras = ?";

            $this->dbFun->abrirConexao();
            $dados = $this->dbFun->select($query, [$idcadeiras]);
            $this->dbFun->fecharConexao();

            return $dados;
      }
}


?>
