<?php
/*********************************************************************************************
 * Original Author: Faisal Alfadhli
 * Date of origination: 02/10/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: function to be used in multiple pages.
 * Credit: 1-  www.W3schools.com/php 
 *
 * Function:  checkEmail($email)
 * Purpose: This Function will check the email if it is well formed
 * Variable: $email - it needs to be verified like this format address@domain.com*
 * 
 *
 * Revision1.1: 02/14/2016 Author: Faisal Alfadhli
 * Description of change. Chenged the return to  0 & 1.
 ********************************************************************************************/

	
	Function checkEmail($email) {
		$successMessage = 0;
    	//check if email address is well formed
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$successMessage = 1;
			return $successMessage;
		}
		else{
			return $successMessage;
		}
  	}


?>