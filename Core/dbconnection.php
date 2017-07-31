<?php

/**
* 
*/
class dbconnection
{
	private static $conn;

	public static function conn()
	{

		$dsn = 'mysql:dbname=cindb;host=127.0.0.1';
		$user = 'root';
		$password = 'heitorado';

		if(is_null(self::$conn)){
			//self::$conn = new PDO('mysql:host=localhost;dbname=cindb','root', 'heitorado');
			self::$conn = new PDO($dsn, $user, $password);
		}
		
	    return self::$conn;
	}

}

?>