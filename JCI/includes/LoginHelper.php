<?php
	// Put code here for functions that help in the login, logout, and register processes
	/*********************************************************************************************
 * Original Author: Benjamin Brackett
 * Date of origination: 02/05/16
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: Put code here for functions that help in the login, logout, and register processes
 * Credit: Give any attributation to code used within, not created by you.
 *
 * Function:  check_login($myVar, $varTwo)
 * Purpose: Check if user is logged in
 * Variable: $_SESSION['user'] - identifies session.
 * Credit: http://stackoverflow.com/questions/18537016/php-check-if-user-is-logged-in-with-a-function
 	
 *
 * Function:  is_digits($anotherVar)
 * Purpose: Checks to see if field only has digits.
 * Variable: $element - The character in question.
 * Credit: https://davidwalsh.name/php-validatie-numeric-digits 
 *
 * Revision1.1: 02/12/2016 Author: Benjamin Brackett
 * Description of change: changed $_SESSION['login'] to $_SESSION['user']
 ********************************************************************************************/

	if(check_login()) {
  echo 'You are in!';
} else {
    header('Location: login.php');
    exit;
}
//Benjamin Brackett: Changed $_SESSION['login'] to $_SESSION['user']
function check_login () {
    if(isset($_SESSION['user'] && $_SESSION['user'] != '')) {
       return true;
    } else {
       false;
    }
}
?>


<?php

function is_digits($element) {
	return !preg_match ("/[^0-9]/", $element);
}