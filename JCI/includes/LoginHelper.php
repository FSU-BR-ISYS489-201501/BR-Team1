<?php
	/*********************************************************************************************
 * Original Author: Benjamin Brackett
 * Date of origination: 02/05/16
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: Put code here for functions that help in the login, logout, and register processes
 * Credit: Give any attributation to code used within, not created by you.
 *
 * Function:  CheckLogin($USERID)
 * Purpose: Check if user is logged in
 * Variable: $_SESSION['USERID'] - identifies session.
 * Credit: http://stackoverflow.com/questions/18537016/php-check-if-user-is-logged-in-with-a-function
 	
 *
 * Function:  CheckDigits($anotherVar)
 * Purpose: Checks to see if field only has digits.
 * Variable: $element - The character in question.
 * Credit: https://davidwalsh.name/php-validatie-numeric-digits 
 *
 * Revision1.1: 02/16/2016 Author: Benjamin Brackett
 * Description of change: changed $_SESSION['login'] to $_SESSION['USERID']
	 * 						Also modified code to return 0s and 1s
 * Revision1.2: 02/20/2016 Author: Benjamin Brackett
 * Description of change: changed $USERID to USERID for if statement
 ********************************************************************************************/
//1 being true, 0 being false
//If user ID is nonexistant then it returns a 0
//If one does exist then it returns a 1 
//Ben Brackett: modified code to return 0s and 1s
//Ben Brackett: changed $USERID to USERID for if statement
function checkLogin($USERID) {
  if (empty($USERID)) {
  	return 0;
  }
  else {
  	return 1;
  	}
}
//Matchs input to 0-9. If it doesn't match it returns a 0 meaning false.
//If it does match it returns a 1 meaning true.
//Ben Brackett: modified code to return 0s and 1s
function checkDigits($element) {
	if (!preg_match ("/[^0-9]/", $element)) {
		return 0;
	}
	else {
		return	1;
	}
}
