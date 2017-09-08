<?php
$status = null;
require_once "../../Core/ProfessoresControle.php";

if (!is_null(filter_input(INPUT_GET, 'insertStatus'))) {
      $status = filter_input(INPUT_GET, 'insertStatus') == true ? "Professor cadastrado" : "Erro ao cadastrar";
}
elseif (!is_null(filter_input(INPUT_GET, 'deleteStatus'))) {
      $status = filter_input(INPUT_GET, 'deleteStatus') == true ? "Professor removido" : "Erro ao remover";
}

$professoresControle = new ProfessoresControle();

$professores = $professoresControle->getProfessores();


?>
<!DOCTYPE html>
<html>
<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>CinDB</title>
      <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
      <link rel="stylesheet" href="../../public/css/mgmtpgs_style.css">
      <link rel="stylesheet" href="../../public/css/ie10-viewport-bug-workaround.css">
      <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
      <nav id="adminNav" class="navbar navbar-inverse visible-xs">
            <div class="container-fluid">
                  <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">CinDb</a>
                  </div>
                  <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav">
                              <li class="active"><a href="#">Gerenciar Professores</a></li>
                              <li><a href="#">Gerenciar Cadeiras</a></li>
                              <li><a href="#">Exercicios</a></li>
                        </ul>
                  </div>
            </div>
      </nav>

      <div class="container-fluid">
            <div class="wrapper row">
                  <!-- Inicio nav -->
                  <nav id="adminSidebar" class="sidebar col-sm-12 col-md-2">
                        <!-- Nav Header -->
                        <div class="sidebar-header">
                              <h2>CinDb</h2>
                        </div>
                        <!-- Nav Links -->
                        <ul>
                              <li class="active"><a href="#">Gerenciar Professores</a></li>
                              <li><a href="#">Gerenciar Cadeiras</a></li>
                              <li><a href="#">Exercicios</a></li>
                        </ul>
                  </nav>
                  <!-- Fim nav -->
                  <div class="col-sm-12 col-md-10">
                        <h3>Gerenciador de Professores</h3>
                        <!-- modal trigger-->
                        <h4><?=$status ?></h4>
                        <button type="button" class="btn btn-info btn-default" data-toggle="modal" data-target="#modalCadastro">Adicionar Novo</button>
                        <hr>
                        <table class="table table-bordered">
                              <thead>
                                    <tr>
                                          <th>Nome</th>
                                          <th>Cadeiras</th>
                                          <th>Opções</th>
                                    </tr>
                              </thead>
                              <tbody>
                                    <?php foreach ($professores as $key => $value) : ?>
                                          <tr>
                                                <td><?=$professores[$key]['nome'] ?></td>
                                                <td>nada</td>
                                                <td>
                                                      <a href="../../Core/ProfessoresControle.php?delete=<?=$professores[$key]['idprofessor']?>">Remover</a>
                                                      <a href="#">Alterar</a>
                                                </td>
                                          </tr>
                                    <?php endforeach; ?>
                              </tbody>
                        </table>

                  </div>
            </div>
      </div>


      <!-- Modal -->
      <div id="modalCadastro" class="modal fade" role="dialog">
            <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                        <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Cadastrar Professor</h4>
                        </div>
                        <div class="modal-body">
                              <!--form para cadastro de novas cadeiras-->
                              <form method="post" name="novo-professor" action="../../Core/ProfessoresControle.php">
                                    <div class="form-group">
                                          <label for="nome" data-toggle="tooltip" title="Insira o nome do professor">Nome:</label>
                                          <input class="form-control" type="text" name="nome" id="nome" required>
                                    </div>

                                    <strong data-toggle="tooltip" title="Selecione as cadeiras que este professor leciona.">Cadeiras:</strong>
                                    <div class="form-group" id="cadeiras">
                                          <label class="checkbox-inline">
                                                <input type="checkbox">cadeira1
                                          </label>
                                          <label class="checkbox-inline">
                                                <input type="checkbox">cadeira2
                                          </label>
                                          <label class="checkbox-inline">
                                                <input type="checkbox">cadeira3
                                          </label>
                                    </div>
                                    <input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-success">                                    </form>
                              </div>
                        </div>
                  </div>
            </div>
            <script src="../../public/js/jquery.min.js"></script>
            <script type="text/javascript" src="../../public/js/bootstrap.min.js"></script>
            <script>
            $(document).ready(function(){
                  $('[data-toggle="tooltip"]').tooltip();
            });
            </script>
      </body>
      </html>
