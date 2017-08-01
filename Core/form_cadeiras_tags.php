<?php
	
	require_once "dbconnection.php";

	#var_dump($_POST['tags']);
	$nomeID = NULL;
	$tagID = NULL;

	$arraytags = str_getcsv($_POST['tags']);

	#var_dump($arraytags);
	#die();

	if(isset($_POST['nome']))
	{

 		$cindb = dbconnection::conn();
		$stmt = $cindb->prepare("INSERT INTO cadeiras(nome) VALUES(?)");
		$stmt->bindParam(1,$_POST['nome']);
	
		if($stmt->execute())
		{
			$nomeID = $cindb->lastInsertId();
            //die("true");
        }
        else 
        {
       		die("Erro");
        }
	}

	if(isset($_POST['tags']))
	{

 		$cindb = dbconnection::conn();

 		foreach ($arraytags as $element)
 		{
			$stmt = $cindb->prepare("INSERT INTO tags(nome) VALUES(?)");
			$stmt->bindParam(1,$element);
			
	
			if($stmt->execute())
			{
	            $tagID = $cindb->lastInsertId();
	        }
	        else 
	        {
	       		die("Erro2");
	        }

	        $stmt2 = $cindb->prepare("INSERT INTO cadeiras_has_tags(cadeiras_idcadeiras, tags_idtags) VALUES(?,?)");

	        $stmt2->bindParam(1,$nomeID);
	        $stmt2->bindParam(2,$tagID);

	        if($stmt2->execute())
			{
	            //die("true");
	        }
	        else 
	        {
	        	var_dump($nomeID);
	        	var_dump($tagID);
	       		die("Erro3");
	        }

    	}
	}


?>