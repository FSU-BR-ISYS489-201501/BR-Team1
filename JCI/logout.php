<?php
/*********************************************************************************************
 * Original Author: Benjamin Brackett
 * Date of origination: 02/09/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: This is the logout page using sessions
 * Credit: https://github.com/GobleB/PHP-Login-with-Sessions/blob/master/logout.php
 *
 * Revision1.1: 02/12/2016 Author: Benjamin Brackett
 * Description of change. Changed entire code in order to use sessions
 ********************************************************************************************/

 # Script 12.11 - logout.php #2
// This page lets the user logout.
// This version uses sessions.

session_start(); // Access the existing session.

// If no session variable exists, redirect the user:
if (!isset($_SESSION['USERID'])) {

	// Need the functions:
	require ('LoginFunction.php');
	redirect_user();	
	
} else { // Cancel the session:

	$_SESSION = array(); // Clear the variables.
	session_destroy(); // Destroy the session itself.
	setcookie ('PHPSESSID', '', time()-3600, '/', '', 0, 0); // Destroy the cookie.

}

// Set the page title and include the HTML header:
$page_title = 'Logged Out!';
include ('Header.php');

// Print a customized message:
echo "<h1>Logged Out!</h1>
<p>You are now logged out!</p>";

include ('Footer.php');
?>