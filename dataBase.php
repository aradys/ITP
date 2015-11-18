<?
include("DataBase.php"); 
include("User.php"); 

Class controller {
	
	private $pdo;
	private $action = $_POST['action'];
	// narazie tu zostawiam 
	

	public function __construct($hostname,$dbname, $port ,$username,$password){
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
			
			if (action == 'dologin'){
				$email = $_POST['email'];
				$password = $_POST['password'];
				
				$user = new User($email,$password);
				$dataBase = new DataBase($pdo);

				if($user->validate())	{
					
				// zapisuje w sesji nazwe uzytkownika i flage zalogowania
					$_SESSION['email'] = $email;
					$_SESSION['flag'] = 'logged';
					
					header("Location: indeks.php"); // przekierowanie na index.php
				
				}
				else{
					$_SESSION['message'] = 'niepoprawne dane logowania';
								header("Location: indeks.php");
				}
			}
			else if (action == 'registry'){
				$email = $_POST['email'];
				$password = $_POST['password'];
				$RepeatPassword = $_POST['passwordRepeat'];
				
				$user = new User($email,$password);
				$dataBase = new DataBase($pdo);
				
					if ($password != $RepeatPassword){
						$_SESSION['message'] = 'hasła sie nie zgadzają';
						header("Location: indeks.php");
					}
					else {
							if (!$user->validate()){
								// trzeba dodac w klasie user przygotowanie odpowiedniej wiadomosci
								$_SESSION['message'] = 'niepoprawne dane rejestracji';
								header("Location: indeks.php");
							}
							else{
								try {
									if (!$DataBase->accountExists($email)){
										$DataBase->createAccount($email);   
										header("Location: indeks.php"); // strona wczytana po poprawnej rejestracji
									}
									else {
										$_SESSION['message'] = 'konto nie istnieje';
										header("Location: indeks.php");// strona wczytana po nieudanej rejestracji
									}
								}
								catch(PDOException $e){
								$_SESSION['message'] ="rejestracja nie powiodła się";
								header("Location: indeks.php");// strona wczytana po nieudanej rejestracji
								}								
							}
					}
			}
	
	}
}

?>