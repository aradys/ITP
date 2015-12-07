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
				
				if(!$DataBase->accountExists($email))	{
					
				// zapisuje w sesji nazwe uzytkownika i flage zalogowania
					$_SESSION['email'] = $email;
					$_SESSION['flag'] = true;
					
					header("Location: index.php"); // przekierowanie na index.php	
				}
				else{
					$_SESSION['message'] = 'niepoprawne dane logowania';
								header("Location: index.php");
				}
			}
			else if ($action == 'user_registry'){ 
				$email = $_POST['email'];
				$password = $_POST['password'];
				$RepeatPassword = $_POST['passwordRepeat'];
				
				$user = new User($email,$password);

				
					if ($password != $RepeatPassword){
						$_SESSION['message'] = 'ahasła sie nie zgadzają';
						header("Location: index.php?lala=1");
					}
					else {
							if (!$user->validate()){
								// trzeba dodac w klasie user przygotowanie odpowiedniej wiadomosci
								$_SESSION['message'] = 'niepoprawne dane rejestracji';
								header("Location: index.php?lala=2");
							}
							else{
								try {
									if (!$DataBase->accountExists($email)){
										$DataBase->createAccount($email,$password);   
										header("Location: index.php?lala=3"); // strona wczytana po poprawnej rejestracji
									}
									else {
										$_SESSION['message'] = 'konto nie istnieje';
										//$DataBase->createAccount($email,$password);
										header("Location: index.php?lala=.".$DataBase->accountExists($email));// strona wczytana po nieudanej rejestracji
									}
								}
								catch(PDOException $e){
									echo($e);
								$_SESSION['message'] ="rejestracja nie powiodła się";
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
				$RepeatPassword = $_POST['passwordRepeat'];
				
				$firm = new Firm($email,$password);
				$dataBase = new DataBase($pdo);
				
					if ($password != $RepeatPassword){
						$_SESSION['message'] = 'hasła sie nie zgadzają 1';
						header("Location: index.php");
					}
					else {
							if (!$firm->validate()){
								// trzeba dodac w klasie przygotowanie odpowiedniej wiadomosci
								$_SESSION['message'] = 'niepoprawne dane rejestracji';
								header("Location: index.php");
							}
							else{
								try {
									if (!$DataBase->accountExistsF($email)){
										$DataBase->createAccountF($nazwa, $opis, $kandydaci, $kontakt, $email, $password);   
										header("Location: index.php"); // strona wczytana po poprawnej rejestracji
									}
									else {
										$_SESSION['message'] = 'konto nie istnieje';
										header("Location: index.php");// strona wczytana po nieudanej rejestracji
									}
								}
								catch(PDOException $e){
								$_SESSION['message'] ="rejestracja nie powiodła się";
								header("Location: index.php");// strona wczytana po nieudanej rejestracji
								}								
							}
					}
			}
			///
	
	}
}

?>