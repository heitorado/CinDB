<?php
require_once "db/DbFuncoes.php";

$nome;
$status;

if (isset($_POST['nome'])) {
      $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);

      $dbFun = new DbFuncoes();
      $status = $dbFun->insert("professores", ["nome" => $nome]);

      if (!$status) {
            header("Location:../App/Administracao/gerenciador_professores.php?status=false");
      }else {
            header("Location:../App/Administracao/gerenciador_professores.php?status=true");
      }
}
