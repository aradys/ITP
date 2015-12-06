<?php

Class DataBase{
	
	define("HOSTNAME","ttsi_db");
    define("DATABASE_NAME","ttsi_db");
	define("PORT","ttsi_db");
	define("USER_NAME","ttsi_db");
	define("PASSWORD","ttsi_db");
	
	private $pdo;
	private $stmt;
	
	public function __construct(){		
		
		try
		{
			$pdo = new PDO('mysql:host='.HOSTNAME.';dbname='.DATABASE_NAME.';port='.PORT , USER_NAME, PASSWORD);
			echo 'Połączenie nawiązane!';
		}
		catch(PDOException $e)
		{
			echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
		}
	}
	
	public function accountExists ($email){
		   $stmt = $pdo->query('SELECT count(*) FROM users where email='.$email);
			
			if ($stmt > 0 ){
				return true;
			}
			else {
				return false;
			}		
	}
	
	public function login($email, $password){
		  $stmt = $pdo->query('SELECT count(*) FROM users where email='.$email.' AND '. $password);
	}
	
	public function createAccount($email, $password){
		 $temp = $pdo->exec('INSERT INTO `users` ( `email`, `password`)	VALUES($email,$password);
	}
}
?>