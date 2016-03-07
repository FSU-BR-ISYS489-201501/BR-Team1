<?php

	function CheckAlphanumeric($test) {
	// Use preg_match function to check letters and numbers, also is case insensative.
	// This if statement tests the variable for alphanumerics and special symbols
		if (!preg_match('/^[a-z0-9 .\/-@#+*=_&^()!$%,.?;:]+$/i',$test)) {
	        return FALSE;
		
		}  
		else {
			return TRUE;
		}
	}

	function CheckAlphaNoSymbols($test) {
	    if (ctype_alnum($test)) {
	        return TRUE;
		} 
		else {
	       	return FALSE;
	    }
	}

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
?>