<?php
	
	require_once "dbconnection.php";

	if(isset($_POST['nome']))
	{

 		$conn = dbconnection::conn();
		$stmt = $conn->prepare("INSERT INTO cadeiras(nome) VALUES(?)");
		$stmt->bindParam(1,$_POST['nome']);
	
		if($stmt->execute())
		{
            //die("true");
        }
        else 
        {
       		die("Erro");
        }
	}
?>