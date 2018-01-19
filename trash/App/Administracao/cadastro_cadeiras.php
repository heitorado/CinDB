<!DOCTYPE html>
<html>
<head>
	<title>CinDB</title>

	<!-- Custom styles for this template -->
  	<link href="../public/CSS/style.css" rel="stylesheet">
</head>
<body>
	<h1>Gerenciador de Cadeiras</h1>

	<hr>

	<form method="post" name="nova-cadeira" action="../Core/form_cadeiras_tags.php">
		<label for="cadeira"><p>Cadeira:</p></label>
		<input type="text" name="cadeira" id="cadeira" placeholder="Nome da cadeira">
		
		<input type="submit" value="Cadastrar Cadeira">
	</form>

	<hr>

	<form method="post" name="nova-tag" action="../Core/form_cadeiras_tags.php">
		<label for="tags"><p>Inserir assuntos da cadeira:</p></label>
		<input type="text" name="tags" id="tags" placeholder="Insira a nova tag">
		
		<input type="submit" value="Cadastrar Tag">
	</form>

	<hr>

	<table>
		<tr>
            <td>Id</td>
            <td>Nome</td>
            <td>Tags</td>
        </tr>

		<?php
			require_once "../Core/dbconnection.php";

	        $conn = dbconnection::conn();
	       	
	       	$result = $conn->query("SELECT * FROM cadeiras");

	       	foreach ($result as $row) {
	       		echo"<tr>";
	       		echo"<td>$row[idcadeiras]</td>";
	       		echo"<td>$row[nome]</td>";
	       		echo "</tr>";
	       	}
	 
	    ?>
    </table>

</body>
</html>