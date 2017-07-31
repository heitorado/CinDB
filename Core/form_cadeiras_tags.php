<?php
	
	require_once "dbconnection.php";

	#var_dump($_POST['tags']);

	$arraytags = str_getcsv($_POST['tags']);

	#var_dump($arraytags);
	#die();

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

	if(isset($_POST['tags']))
	{

 		$conn = dbconnection::conn();

 		foreach ($arraytags as $element)
 		{
			$stmt = $conn->prepare("INSERT INTO tags(nome) VALUES(?)");
			$stmt->bindParam(1,$element);
	
			if($stmt->execute())
			{
	            //die("true");
	        }
	        else 
	        {
	       		die("Erro");
	        }

    	}
	}


?>