<?php
	/*********************************************************************************************
	 * Original Author: Mark Bowman
	 * Date of origination: 03/06/2016
	 *
	 * Page created for use in the JCI Project.
	 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
	 * Purpose: The purpose of this file is to store all of the functions used for validation.
	 *
	 * Function:  checkEmail($email) - Faisal		
	 * Purpose: This Function will check the email if it is well formed		
	 * Variable: $email - it needs to be verified like this format address@domain.com
	 * Credit: www.W3schools.com/php
	 * 
	 * Function:  checkFile($fileType, $fileSize) - Faisal
	 * Purpose: Checks the file type and size. If the file meets requirments return true if not return false.		
	 * Variable: $fileType - it must be .doc or .docx.		
	 * Variable: $fileSize - it must be 100KB( this may need to be increades later).
	 * Credit: www.tizg.com, www.W3schools.com/php, and http://io.hsoub.com/php 
	 * 
	 * Function:  Function checkPsw($pass) - Shane	
	 * Purpose: This function uses regex to check the mask of a password input to make sure it meets standards.		
	 * Checks for 10 chars, one number, one special char, one lower, one capital!		
	 * Variable: $myVar - Description of variable.		
	 * Variable: $varTwo - Another description.
	 * 
	 * Function:  Function isDate($string) - Shane
	 * Purpose: This function test to see if the date given in a string is a valid date.
	 * Credit: http://php.net/manual/en/function.checkdate.php and venadder at yahoo dot ca
	 * 
	 * Revision1.1: 04/17/2016 Author: Mark Bowman
	 * Description of change. Added a comment header block and citations.
	 * 
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

	function checkFile($fileType, $fileSize) {
		$successMessage = 0;
		// Mark Bowman: changed the structure of this block
		// in order to check both file type and file size.
		
		// this block to check file type 
		if ($fileType== "application/msword" || 
		$fileType== "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
			// this block to check file size
			if($fileSize <= 10000000) {
				$successMessage = 1;                 
			}
		}
		return $successMessage;
	}

	function checkPsw($input_line) {
	 	//Created the regex expression, Checks for 10 chars, one number, one special char, one lower, one capital!
	    $pattern = "/^\S*(?=\S{10,})(?=\S*[a-z])(?=\S*[\W])(?=\S*[A-Z])(?=\S*[\d])\S*$/";
	 	
	 	if (!preg_match($pattern, $input_line)) {
			return FALSE;
		} 
		else {
			return TRUE; 
		}
 	}
	
	function isDate( $string ) {
	  	$stamp = strtotime( $string );
	  	$month = date( 'm', $stamp );
	  	$day   = date( 'd', $stamp );
		$year  = date( 'Y', $stamp );
	
		return checkdate( $month, $day, $year );
	}
?>