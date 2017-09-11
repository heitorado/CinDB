<?php
require_once "../../Core/ProfessoresControle.php";
$status = null;
$professoresControle = new ProfessoresControle();
$professoresControle->renderHeader();

if (!is_null(filter_input(INPUT_GET, 'insertStatus'))) {
      $status = filter_input(INPUT_GET, 'insertStatus') == "true" ? "Professor cadastrado" : "Erro ao cadastrar";
}
elseif (!is_null(filter_input(INPUT_GET, 'deleteStatus'))) {
      $status = filter_input(INPUT_GET, 'deleteStatus') == "true" ? "Professor removido" : "Erro ao remover";
}


$professores = $professoresControle->getProfessores();


?>

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
                              <input type="submit" name="cadastrar" value="cadastrar" class="btn btn-success">
                        </form>
                  </div>
            </div>
      </div>
</div>

<?php $professoresControle->renderFooter(); ?>
