<?php

Class DataBase{
	
	
	
	var $pdo;
	private $stmt;
	
	public function __construct(){		
		
		define("HOSTNAME","localhost");
		define("DATABASE_NAME","itp");
		define("PORT","3306");
		define("USER_NAME","root");
		define("PASSWORD","woj123");
		
		try
		{
			$this -> pdo = new PDO('mysql:host='.HOSTNAME.';dbname='.DATABASE_NAME.';port='.PORT , USER_NAME, PASSWORD);
			$this -> pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e)
		{
			echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
		}
	}
	
	public function accountExists ($email){
		   $stmt = $this -> pdo->prepare("SELECT count(*) as total FROM users where email= :email");
			$stmt -> bindValue(':email', $email, PDO::PARAM_STR); 
			 $stmt -> execute();
			 $ilosc = $stmt ->fetch();
			 
			if ($ilosc[total] > 0 ){
				return true;
			}
			else {
				return false;
			}		
	}
	
	public function login($email, $password){
		  $stmt = $this -> pdo->query('SELECT count(*) FROM users where email='.$email.' AND '. $password);
	}
	
	public function createAccount($email, $password){
		
			// $this ->pdo->beginTransaction();
			 $sql = "INSERT INTO users (email,password) VALUES(?,?)";
		     $stmt = $this ->pdo-> prepare($sql);
			 $stmt->execute(array($email,$password));			 
			//$this ->pdo->commit();
	}
}
?>
