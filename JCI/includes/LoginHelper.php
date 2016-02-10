<?php
	// Put code here for functions that help in the login, logout, and register processes
	
	
	//Author: Ben Brackett 02/05/16
	//Ben Brackett: This block of code is the function for checking to see if the user is logged in or 
	//not. I did not create this code myself. It was found off of stackoverflow from
	//http://stackoverflow.com/questions/18537016/php-check-if-user-is-logged-in-with-a-function
	//Ben Brackett: This check_login function checks the session login to see if it matches a logged in
	//session id. If not, then it will return a false, if true, it will return a true. 
	//If true it will then echo you are in, or just show login screen   
	if(check_login()) {
  echo 'You are in!';
} else {
    header('Location: login.php');
    exit;
}

function check_login () {
    if(isset($_SESSION['login'] && $_SESSION['login'] != '')) {
       return true;
    } else {
       false;
    }
}
?>


<?php
//Author: Ben Brackett 02/05/16
//Email: brackeb1@ferris.edu
//Ben Brackett: I found this code written by David Walsh on
//https://davidwalsh.name/php-validatie-numeric-digits 
//Ben Brackett: This function checks for digits only, no dots
//If it does match a digit then it will return true, if it doesn't
//match a digit then it will return a false
function is_digits($element) {
	return !preg_match ("/[^0-9]/", $element);
}