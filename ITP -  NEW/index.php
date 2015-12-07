<?php

include('controllers/dataBase.php');
include('controllers/LoginController.php');
include('views/Widok.php');
include("model/User.php"); 
include("model/Firm.php");
$DataBase = new dataBase();
$wyglad = new Widok();
$loginController = new LoginController();

$page = isset($_GET['page']) ? $_GET['page'] : 'glowna';
switch($page){
 
  case 'glowna':
	$wyglad->naglowek();						
	$wyglad->glowna();
  break;
  
  case 'galeria':
	 $wyglad->naglowek();	
	 $wyglad->galeria();
  break;
  
  case 'logowanie':
		
		if (isset($_POST['action'])){	
			$loginController -> doPost($DataBase);
		}
		else{
			$wyglad->naglowek();	
			$wyglad->logowanie();		
		}			
  break;
		 
  case 'rejestracja':
	  if (isset($_POST['action'])){	
	   $loginController ->  doPost($DataBase);
	  }
	  else{
			$wyglad->naglowek();	
			$wyglad->rejestracja();		
		}		
  break;
  
   case 'rejestracjafirm':
	if (isset($_POST['action'])){	
	   $loginController ->  doPost($DataBase);
	  }
	  else{
			$wyglad->naglowek();	
			$wyglad->rejestracjafirm();		
		}
  break;

	 
  default:
	die("Taka strona nie istnieje!");
	break;
}
if(isset($_SESSION['message'])){
echo($_SESSION['message']);
}
$wyglad->stopka();	
?>