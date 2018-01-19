<?php
require_once "../../Core/ProfessoresControle.php"; // Carregando a classe de controle
$status = null; // Variavel para mensagens após interação com o BD

$professoresControle = new ProfessoresControle();  // Objeto do controle
$professoresControle->renderHeader(); // Carrega o html superior padrão

// VERIFICA SE VEIO UM 'GET'. CASO POSITIVO É COLOCADO UMA MENSGEM NO $status.
if (!is_null(filter_input(INPUT_GET, 'insertStatus'))) {
      $status = filter_input(INPUT_GET, 'insertStatus') == "true" ? "Professor cadastrado" : "Erro ao cadastrar";
}
elseif (!is_null(filter_input(INPUT_GET, 'deleteStatus'))) {
      $status = filter_input(INPUT_GET, 'deleteStatus') == "true" ? "Professor removido" : "Erro ao remover";
}
elseif (!is_null(filter_input(INPUT_GET, 'updateStatus'))) {
      $status = filter_input(INPUT_GET, 'updateStatus') == "true" ? "Professor modificado" : "Erro ao modificar";
}

$professores = $professoresControle->getProfessores(); // CARREGA TODOS OS PROFESSORES
$cadeiras = $professoresControle->getCadeiras(); // CARREGA TODAS AS CADEIRAS PARA O FORMULARIO
?>

<h3>Gerenciador de Professores</h3>
<!-- modal trigger-->
<h4><?=$status ?></h4>
<button type="button" class="btn btn-info btn-default" id="insert" data-toggle="modal" data-target="#modalProfessor">Adicionar Novo</button>
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
            <!-- EXIBE OS DADOS -->
            <?php foreach ($professores as $key => $value) : ?>
                  <tr>
                        <td><?=$value['nome'] ?></td>
                        <td><?=$value['cadeiras']?></td>
                        <td>
                              <a href="../../Core/ProfessoresControle.php?delete=<?=$value['idprofessor']?>">Remover</a>
                              <a href="#" id="update-<?=$value['idprofessor']?>" data-toggle="modal" data-target="#modalProfessor">Alterar</a>
                        </td>
                  </tr>
            <?php endforeach; ?>
      </tbody>
</table>

<!-- Modal -->
<div id="modalProfessor" class="modal fade" role="dialog">
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
                              <input type="hidden" name="idprofessor" id="idprofessor" value="">
                              <div class="form-group">
                                    <label for="nome" data-toggle="tooltip" title="Insira o nome do professor">Nome:</label>
                                    <input class="form-control" type="text" name="nome" id="nome" required>
                              </div>

                              <strong data-toggle="tooltip" title="Selecione as cadeiras que este professor leciona.">Cadeiras:</strong>
                              <div class="form-group" id="cadeiras">
                                    <?php foreach ($cadeiras as $key => $value) : ?>
                                          <label class="checkbox-inline">
                                                <input type="checkbox" name="cadeiras[]" value="<?=$value['idcadeiras']?>"><?=$value['nome']?>
                                          </label>
                                    <?php endforeach; ?>
                              </div>
                              <div id="submit">
                                    <!-- ATRAVES DO JQUERY, SERA ADICIONADO O BOTÃO CORRETO -->
                              </div>
                        </form>
                  </div>
            </div>
      </div>
</div>
<script type="text/javascript">
//INSERE O BOTAO DE CADASTRO
$("#insert").click(function(){
      limpaModal();
      $("#submit").html('<input type="submit" name="cadastrar" value="cadastrar" class="btn btn-success">');
});
// INSERE O BOTAO DE MODIFICAR E CARREGA OS DADOS ATUAIS
$( "a[id^='update']").click(function(){
      limpaModal();
      $("#submit").html('<input type="submit" name="modificar" value="modificar" class="btn btn-default">');
      var id = $(this).attr("id");
      id = id.split('-')[1];

      buscaProfessor(id);
});

// BUSCA OS DADOS DO PROFESSOR
function buscaProfessor(id) {
      $.ajax({
            type:"POST",
            url: "../../Core/ProfessoresControle.php",
            data:{buscarProfessor : id},
            success: function (response){
                  var professor = $.parseJSON(response);
                  console.log(professor);
                  $("#nome").val(professor.nome);
                  $("#idprofessor").val(professor.idprofessor);

                  $("input[name='cadeiras[]']").each(function ()
                  {
                        if (professor.cadeiras != null) {
                              if ($.inArray($(this).val(), professor.cadeiras) !== -1) {
                                    console.log($(this).val());
                                    $(this).prop('checked',true);
                              }
                        }
                  });

            }
      });
}

// LIMPA O MODAL
function limpaModal() {
      $("#nome").val("");
      $("#idprofessor").val("");
      $("input[name='cadeiras[]']").each(function (){
            $(this).prop('checked',false);
      });
}

</script>
<?php $professoresControle->renderFooter(); //INSERE A PARTE INFERIOR PADRAO ?>