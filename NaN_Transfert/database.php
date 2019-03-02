<?php 

/**
* Database permet de se connecter plus facilement a la bd
*/
class Database
{
	private static $dbHost 			= "localhost";
	private static $dbName 			= "acn_trans";
	private static $dbUser 			= "root";
	private static $dbUserPasswd 	= "";
	private static $connexion 		= null;

	public static function connect(){
		try {
			self::$connexion = new PDO("mysql:host=".self::$dbHost.";dbname=".self::$dbName."",self::$dbUser,self::$dbUserPasswd);
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		return self::$connexion;
	}

	public static function disconnect(){
		self::$connexion = null;
	}

}


 ?>