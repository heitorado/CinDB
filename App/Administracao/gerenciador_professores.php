<!DOCTYPE html>
<html>
<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>CinDB</title>
      <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
      <link rel="stylesheet" href="../../public/css/mgmtpgs_style.css">
      <link rel="stylesheet" href="../../public/css/ie10-viewport-bug-workaround.css">

      <!-- temp -->
      <style media="screen">
      .wrapper{
            display: flex;
      }

      .sidebar {
            background-color: #f1f1f1;
            border-right: 1px solid #c1c1c1;
            height: 100vh;
            margin-right: 25px;
      }

      .sidebar ul{
            list-style: none;
            padding: 0;
            background: #2277ff;
            border: 1px solid #1155aa;
            border-radius: 4px;
      }


      .sidebar ul li a{
            border-radius: 4px;
            padding: 5px 10px;
            display: block;
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
      }

      .sidebar ul li.active a{
            //border: 1px solid #885500;
            background: #ff9900;
      }
      

      .sidebar ul li:not(.active) a:hover{
            //border: 1px solid #2277ff;
            border-radius: 0;
            background: #1155aa;
      }
      </style>
      <!-- temp -->
</head>
<body>
      <div class="container-fluid">
            <div class="wrapper row">
                  <!-- Inicio nav -->
                  <nav class="sidebar col-md-2">
                        <!-- Nav Header -->
                        <div class="sidebar-header">
                              <h2>CinDB</h2>
                        </div>
                        <!-- Nav Links -->
                        <ul>
                              <li class="active"><a href="#">Gerenciar Professores</a></li>
                              <li><a href="#">Gerenciar Cadeiras</a></li>
                              <li><a href="#">Exercicios</a></li>
                        </ul>
                  </nav>
                  <!-- Fim nav -->
                  <div class="col-md-10">
                        <h3>Gerenciador de Professores</h2>
                              <!-- modal trigger-->
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
                                          <tr>
                                                <td>col</td>
                                                <td>col</td>
                                                <td>col</td>
                                          </tr>
                                          <tr>
                                                <td>col</td>
                                                <td>col</td>
                                                <td>col</td>
                                          </tr>
                                          <tr>
                                                <td>col</td>
                                                <td>col</td>
                                                <td>col</td>
                                          </tr>
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
                                    <form method="post" name="novo-professor" action="../Core/form_cadeiras_tags.php">
                                          <div class="form-group">
                                                <label for="nome" data-toggle="tooltip" title="Insira o nome do professor">Nome:</label>
                                                <input class="form-control" type="text" name="nome" id="nome">
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
                                          <button type="submit" class="btn btn-success">Cadastrar</button>
                                    </form>
                              </div>
                        </div>
                  </div>
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script type="text/javascript" src="../../public/js/bootstrap.min.js"></script>
            <script>
            $(document).ready(function(){
                  $('[data-toggle="tooltip"]').tooltip();
            });
            </script>
      </body>
      </html>
