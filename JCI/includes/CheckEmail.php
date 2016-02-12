<?php

/* Faisal Alfadhli 
refrence: http://www.w3schools.com
*/


		 
	//This Function will check the email if it is well formed
	Function checkEmail($email) {
			
		$successMsg = 0;
    	//check if email address is well formed
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$successMsg = 1;
		}
		return $successMsg;
  	}


?>