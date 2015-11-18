<?
include("DataBase.php"); 
include("User.php"); 
include("Firm.php");

Class controller {
	
	private $pdo;
	private $action = $_POST['action'];
	// narazie tu zostawiam 
	

	public function __construct($hostname,$dbname, $port ,$username,$password){
		session_start();
	// tu się łącze z bazą danych
	
		try
		{
			$pdo = new PDO('mysql:host='.$hostname.';dbname='.$dbname.';port='.$port ,$username, $password );
			echo 'Połączenie nawiązane!';
		}
		catch(PDOException $e)
		{
			echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
		}
	}
	

	if($_SERVER['REQUEST_METHOD'] == 'POST'){ //czy formularz został wysłany	
		
		$action = $_POST['action'];
			
			if (action == 'sign_in'){ 
				$email = $_POST['email'];
				$password = $_POST['password'];
				
				$user = new User($email,$password);
				$dataBase = new DataBase($pdo);

				if($user->validate())	{
					
				// zapisuje w sesji nazwe uzytkownika i flage zalogowania
					$_SESSION['email'] = $email;
					$_SESSION['flag'] = 'logged';
					
					header("Location: index.php"); // przekierowanie na index.php
				
				}
				else{
					$_SESSION['message'] = 'niepoprawne dane logowania';
								header("Location: index.php");
				}
			}
			else if (action == 'user_registry'){ 
				$email = $_POST['email'];
				$password = $_POST['password'];
				$RepeatPassword = $_POST['passwordRepeat'];
				
				$user = new User($email,$password);
				$dataBase = new DataBase($pdo);
				
					if ($password != $RepeatPassword){
						$_SESSION['message'] = 'hasła sie nie zgadzają';
						header("Location: index.php");
					}
					else {
							if (!$user->validate()){
								// trzeba dodac w klasie user przygotowanie odpowiedniej wiadomosci
								$_SESSION['message'] = 'niepoprawne dane rejestracji';
								header("Location: index.php");
							}
							else{
								try {
									if (!$DataBase->accountExists($email)){
										$DataBase->createAccount($email);   
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
				else if (action == 'firm_registry'){ //
				$name = $_POST['name'];
				$logo= $_POST['logo'];
				$description= $_POST['description'];
				$wanted= $_POST['wanted'];
				$contact= $_POST['contact'];
				$email = $_POST['email'];
				$password = $_POST['password'];
				$RepeatPassword = $_POST['passwordRepeat'];
				
				$firm = new Firm($email,$password);
				$dataBase = new DataBase($pdo);
				
					if ($password != $RepeatPassword){
						$_SESSION['message'] = 'hasła sie nie zgadzają';
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
									if (!$DataBase->accountExists($email)){
										$DataBase->createAccount($email);   
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