<?php

/* Faisal Alfadhli 
refrence: http://www.w3schools.com
*/


		 
	//This Function will check the email if it is well formed
	Function checkEmail($email) {
			
    	// check if email address is well formed
    	$successMsg = 0;
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$successMsg = 1;
		}
		return $successMsg;
  	}


?>