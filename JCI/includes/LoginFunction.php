<?php 
/*********************************************************************************************
 * Original Author: Benjamin Brackett
 * Date of origination: 02/14/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: login_functions.inc.php. This page defines two functions used by the login/logout process.
 * Credit: Ullman, Larry (2011-09-13). PHP and MySQL for Dynamic Web Sites, Fourth Edition: Visual QuickPro Guide (4th Edition) 
 * 			(Kindle Location 30). Pearson Education. Kindle Edition.
 *
 * Function:  redirect_user($page)
 * Purpose: This function determines an absolute URL and redirects the user there.
 * 				The function takes one argument: the page to be redirected to.
 * 				The argument defaults to index.php.
 * Variable: $page - Defines the url for the index page
 *
 * Function:  check_login($dbc, $email, $pass)
 * Purpose: This function validates the form data (the email address and password)
 * 				If both are present, the database is queried.
 * 				The function requires a database connection.
 * 				The function returns an array of information, including:
 *  			a TRUE/FALSE variable indicating success
 *  			an array of either errors or the database result
 * Variable: $dbc - connects to the database
 * Variable: $email - uses the email that was grabbed in the email field
 * Variable: $pass - uses the password that was grabbed in the password field
 *
 * Revision1.1: MM/DD/YYYY Author: Name Here 
 * Description of change. Also add //Name: comments above your change within the code.
 ********************************************************************************************/

function redirect_user ($page = 'index.php') {

	// Start defining the URL...
	// URL is http:// plus the host name plus the current directory:
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	
	// Remove any trailing slashes:
	$url = rtrim($url, '/\\');
	
	// Add the page:
	$url .= '/' . $page;
	
	// Redirect the user:
	header("Location: $url");
	exit(); // Quit the script.

} // End of redirect_user() function.



function check_login($dbc, $email = '', $pass = '') {

	$errors = array(); // Initialize error array.

	// Validate the email address:
	if (empty($email)) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($email));
	}

	// Validate the password:
	if (empty($pass)) {
		$errors[] = 'You forgot to enter your password.';
	} else {
		$p = mysqli_real_escape_string($dbc, trim($pass));
	}

	if (empty($errors)) { // If everything's OK.

		// Retrieve the user_id and first_name for that email/password combination:
		$q = "SELECT USERID, Fname FROM users WHERE email='$e' AND password_hash='$p'";		
		$r = @mysqli_query ($dbc, $q); // Run the query.
		
		// Check the result:
		if (mysqli_num_rows($r) == 1) {

			// Fetch the record:
			$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
	
			// Return true and the record:
			return array(true, $row);
			
		} else { // Not a match!
			$errors[] = 'The email address and password entered do not match those on file.';
		}
		
	} // End of empty($errors) IF.
	
	// Return false and the errors:
	return array(false, $errors);

} // End of check_login() function.