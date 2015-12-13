<?php



Class LoginController {
	
	private $action;
	
	//public function __construct($action){
	//	$this-> action = $action;
	//}
	
	public function doPost($DataBases){
		
		session_start();
		
		$action =$_POST['action'];
//		$actions;
		$DataBase = $DataBases;
			if ($action == 'sign_in'){ 
			
				$email = $_POST['email'];
				$password = $_POST['password'];
				
				$user = new User($email,$password);
				$firma = new Firm($email,$password);
				
				if($DataBase->accountExists($email))	{
					
					if ($DataBase->login($email,$password)){
						$_SESSION['user'] = $email;
						$_SESSION['message'] = 'Zalogowany jako ' .$_SESSION['user'];
						header("Location: index.php"); // przekierowanie na index.php	
					}else {
						$_SESSION['message'] = 'Niepoprawne hasło';
						header("Location: index.php");
					}
				}else if($DataBase->accountExistsF($email))	{
					
					if ($DataBase->loginF($email,$password)){
						$_SESSION['user'] = $email;
						$_SESSION['message'] = 'Zalogowany jako ' .$_SESSION['user'];
						header("Location: index.php"); // przekierowanie na index.php	
					}else {
						$_SESSION['message'] = 'Niepoprawne hasło';
						header("Location: index.php");
					}
				}			
				else{
					$_SESSION['message'] = 'Niepoprawne dane logowania';
								header("Location: index.php");
				}
			}
			else if ($action == 'user_registry'){ 
				$email = $_POST['email'];
				$password = $_POST['password'];
				$RepeatPassword = $_POST['passwordRepeat'];
				
				$user = new User($email,$password);

				
					if ($password != $RepeatPassword){
						$_SESSION['message'] = 'Hasła sie nie zgadzają';
						header("Location: index.php");
					}
					else {
							if (!$user->validate()){
								// trzeba dodac w klasie user przygotowanie odpowiedniej wiadomosci
								$_SESSION['message'] = 'Hasło musi składać się z min. 8 znaków';
								header("Location: index.php");
							}
							else{
								try {
									if (!$DataBase->accountExists($email)){
										$DataBase->createAccount($email,$password); 
										$_SESSION['message'] = 'Konto zostało utworzone';
										header("Location: index.php"); // strona wczytana po poprawnej rejestracji
									}
									else {
										$_SESSION['message'] = 'Takie konto już istnieje';
										//$DataBase->createAccount($email,$password);
										header("Location: index.php");// strona wczytana po nieudanej rejestracji
									}
								}
								catch(PDOException $e){
									echo($e);
								$_SESSION['message'] ="Rejestracja nie powiodła się";
								//header("Location: index.php");// strona wczytana po nieudanej rejestracji
								}								
							}
					}
			}
			///
				else if ($action == 'firm_registry'){ //
				$nazwa = $_POST['name'];
				$opis= $_POST['description'];
				$kandydaci= $_POST['wanted'];
				$kontakt= $_POST['contact'];
				$email = $_POST['email'];
				$password = $_POST['password'];
				$RepeatPassword = $_POST['RepeatPassword'];
				
				$firm = new Firm($email,$password);
				//$dataBase = new DataBase($pdo);
				
					if ($password != $RepeatPassword){
						$_SESSION['message'] = 'Hasła sie nie zgadzają';
						header("Location: index.php");
					}
					else {
							if (!$firm->validate()){
								// trzeba dodac w klasie przygotowanie odpowiedniej wiadomosci
								$_SESSION['message'] = 'Hasło musi składać się z min. 8 znaków';
								header("Location: index.php");
							}
							else{
								try {
									if (!$DataBase->accountExistsF($email)){
										$DataBase->createAccountF($nazwa, $opis, $kandydaci, $kontakt, $email, $password);   
										$_SESSION['message'] = 'Konto zostało utworzone';
										header("Location: index.php"); // strona wczytana po poprawnej rejestracji
									}
									else {
										$_SESSION['message'] = 'Takie konto już istnieje!';
										header("Location: index.php");// strona wczytana po nieudanej rejestracji
									}
								}
								catch(PDOException $e){
									echo($e);
								$_SESSION['message'] ="Rejestracja nie powiodła się";
								//header("Location: index.php?exception");// strona wczytana po nieudanej rejestracji
								}								
							}
					}
			}
			///
	
	}
}

?>