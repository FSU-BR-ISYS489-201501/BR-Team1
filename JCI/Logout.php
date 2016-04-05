<?php
/*********************************************************************************************
 * Original Author: Benjamin Brackett
 * Date of origination: 02/09/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: This page lets the user logout. This version uses sessions.
 * Credit: Ullman, Larry (2011-09-13). PHP and MySQL for Dynamic Web Sites, Fourth Edition: Visual QuickPro Guide (4th Edition) 
 * 			(Kindle Location 30). Pearson Education. Kindle Edition.
 *
 * Revision1.1: 02/14/2016 Author: Benjamin Brackett
 * Removed cookies code and replaced it with sessions logout code
 ********************************************************************************************/

session_start(); // Access the existing session.

// If no session variable exists, redirect the user:
if (!isset($_SESSION['UserId'])) {

	// Need the functions:
	require ('includes/LoginFunction.php');
	redirect_user();	
	
} else { // Cancel the session:

	$_SESSION = array(); // Clear the variables.
	session_destroy(); // Destroy the session itself.
	setcookie ('PHPSESSID', '', time()-3600, '/', '', 0, 0); // Destroy the cookie.

}

// Set the page title and include the HTML header:
$page_title = 'Logged Out!';
include ('includes/Header.php');

// Print a customized message:
echo "<h1>Logged Out!</h1>
<p>You are now logged out!</p>";

include ('includes/Footer.php');
?>
