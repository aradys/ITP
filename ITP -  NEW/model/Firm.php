<?php
	Class Firm{
		
		private $name;
		private $logo;
		private $description;
		private $wanted;
		private $contact;
		private $email;
		private $password;
		
		public function __construct($email,$password){
			$this -> email = $email;
			$this -> password = $password;
		}
		
		public function getEmail(){
			return $this->email;
		}
		
		public function getPassword(){
			return $this->password;
		}
		
		public function validate() {
		
			if(!preg_match('/^[a-zA-Z0-9\.\-_]+\@[a-zA-Z0-9\.\-_]+\.[a-z]{2,4}$/D', $this->email)){
				return false;
			}
			else if  (strlen($this->password) < 8) {
				return false;
			}
			
			else {
				return true;
			}
		} 

			
			
	}
?>