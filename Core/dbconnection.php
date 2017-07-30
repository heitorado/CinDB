private static $conn;

public static function conn()
{
	if(is_null(self::$conn)){
		self::$conn = new PDO('mysql:host="localhost";dbname="cindb", "root", "heitorado"');
	}
	
    return self::$conn;
}