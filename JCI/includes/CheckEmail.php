<?php

/* Faisal Alfadhli 
refrence: http://www.w3schools.com
*/

// Faisal Alfadhli : define variables 
		$email = $emailErr = "";
		
		Function CheckEmail() {
			
		// Faisal Alfadhli : if empty,  show error
	 if (empty($_POST["email"])) {
    $emailErr = "Please, Enter Your Email";
  } else {
  	
	  // Faisal Alfadhli : send user input data through test_input function
    $email = test_input($_POST["email"]);
	
    // Faisal Alfadhli : check if email address is well formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email"; 
    }
  }

}
?>