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

/*if(isset($_SESSION['user'])){
echo($_SESSION['user'].'siema');
}*/

switch($page){
 
    case 'glowna':
	$wyglad->naglowek();						
	$wyglad->glowna();
  break;
  
  case 'stopka':
	$wyglad->naglowek();						
	$wyglad->stopka();
  break;
  
  case 'galeria':
	 $wyglad->naglowek();	
	 $wyglad->galeria();
  break;
  
  case 'itp':
	$wyglad->naglowek();						
	$wyglad->itp();
  break;
  
  case 'kontakt':
	 $wyglad->naglowek();	
	 $wyglad->kontakt();
  break;
  
  case 'best':
	 $wyglad->naglowek();	
	 $wyglad->best();
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

$wyglad->stopka();	
?>