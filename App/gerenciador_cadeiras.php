<!DOCTYPE html>
<html>
<head>
	<title>CinDB</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<!-- Custom Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Aldrich|Fugaz+One|Quantico" rel="stylesheet">
	<!-- Custom styles for this template -->
    <link href="../public/js/tagsinput.css" rel="stylesheet">
    <link href="../public/CSS/mgmtpgs_style.css" rel="stylesheet">

</head>
<body>
    <h1>Gerenciador de Cadeiras</h1>

    <!-- modal trigger-->
        <button type="button" class="btn btn-info btn-default" data-toggle="modal" data-target="#modalCadastro">Criar Nova</button>

    <hr>

    <!-- aqui vai ficar a lista de cadeiras ja existentes com um botao de "edit" do lado-->


    <table id="dbsummary">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Tags</th>
            <th>Professores</th>
        </tr>

        <?php
            require_once "../Core/dbconnection.php";

            $conn = dbconnection::conn();

            $result = $conn->query("SELECT * FROM cadeiras");

            $tagsString = NULL;


            foreach ($result as $row) {
                //$tags = $conn->query("SELECT * FROM tags WHERE idtags = ")

                $tagsID = $conn->query("SELECT tags_idtags FROM cadeiras_has_tags WHERE cadeiras_idcadeiras = $row[idcadeiras]");

                foreach ($tagsID as $tag) {
                    $tagQry = $conn->query("SELECT nome FROM tags WHERE idtags = $tag[tags_idtags]");

                    foreach ($tagQry as $key) {
                        $tagsString .= $key['nome'].", ";
                    }


                }

                $tagsString[strlen ($tagsString)-1] = NULL;
                $tagsString[strlen ($tagsString)-2] = NULL;

                var_dump($tagsString);

                echo "<tr>";
                echo "<td id='idcol'>$row[idcadeiras]</td>";
                echo "<td>$row[nome]</td>";
                echo "<td>$tagsString</td>";
                echo "<td> vai ter professores aqui</td>";
                //ideia: gravar o ID aqui, para poder pegar ele no cadeira_excluir posteriormente. tipo <a value="idcadeiras", etc. Assim cada editar vai ter seu proprio ID associado.
                echo "<td class='table-option'><a href='#'>Editar</a></td>";
                echo "<td class='table-option'><a href='#'>Excluir</a></td>";
                echo "</tr>";

                $tagsString = NULL;
            }

        ?>
    </table>

    <!-- Modal -->
    <div id="modalCadastro" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Cadastrar nova Cadeira</h4>
          </div>
          <div class="modal-body">
            <!--form para cadastro de novas cadeiras-->
            <form method="post" name="nova-cadeira" action="../Core/form_cadeiras_tags.php">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input class="form-control" type="text" name="nome" id="nome">
                    <p class="help-block">Insira o nome da cadeira</p>
                </div>

                <div class="form-group">
                    <label for="tags">Tags:</label>
                    <input class="form-control" type="text" name="tags" id="tags" data-role="tagsinput">
                    <p class="help-block">Insira os tópicos da cadeira, separados por vírgula.</p>
                </div>
                <button type="submit" class="btn btn-default">Criar</button>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>


    <hr>
<!--
    <div class="row">
        <div class="col-lg-6">

            <form role="form">

                <div class="form-group">
                    <label>Text Input</label>
                    <input class="form-control">
                    <p class="help-block">Example block-level help text here.</p>
                </div>

                <div class="form-group">
                    <label>Text Input with Placeholder</label>
                    <input class="form-control" placeholder="Enter text">
                </div>

                <div class="form-group">
                    <label>Static Control</label>
                    <p class="form-control-static">email@example.com</p>
                </div>

                <div class="form-group">
                    <label>File input</label>
                    <input type="file">
                </div>

                <div class="form-group">
                    <label>Text area</label>
                    <textarea class="form-control" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label>Checkboxes</label>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="">Checkbox 1
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="">Checkbox 2
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="">Checkbox 3
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Inline Checkboxes</label>
                    <label class="checkbox-inline">
                        <input type="checkbox">1
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox">2
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox">3
                    </label>
                </div>

                <div class="form-group">
                    <label>Radio Buttons</label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>Radio 1
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">Radio 2
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3">Radio 3
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Inline Radio Buttons</label>
                    <label class="radio-inline">
                        <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline1" value="option1" checked>1
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline2" value="option2">2
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline3" value="option3">3
                    </label>
                </div>

                <div class="form-group">
                    <label>Selects</label>
                    <select class="form-control">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Multiple Selects</label>
                    <select multiple class="form-control">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-default">Submit Button</button>
                <button type="reset" class="btn btn-default">Reset Button</button>

            </form>

        </div>
    </div>
-->



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="../public/js/tagsinput.js"></script>
</body>
</html>
