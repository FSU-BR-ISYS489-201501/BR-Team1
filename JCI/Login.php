<?php 
/*********************************************************************************************
 * Original Author: Benjamin Brackett
 * Date of origination: 02/14/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: This page processes the login form submission.
 * Credit: Ullman, Larry (2011-09-13). PHP and MySQL for Dynamic Web Sites, Fourth Edition: Visual QuickPro Guide (4th Edition) 
 * 			(Kindle Location 30). Pearson Education. Kindle Edition.
 *
 * Revision1.1: MM/DD/YYYY Author: Name Here 
 * Description of change. Also add //Name: comments above your change within the code.
 ********************************************************************************************/
 
// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Need two helper files:
	require ('includes/LoginFunction.php');
	require ('../DbConnector.php');
		
	// Check the login:
	list ($check, $data) = checkLoginFields($dbc, $_POST['email'], $_POST['pass']);
	
	if ($check) { // OK!
		
		// Set the session data:
		session_start();
		if(isset($_SESSION['views'])){
			$_SESSION['views'] = $_SESSION['views']+1;
			}else{
				$_SESSION['views']=1;
		}
		// User session data:
		$_SESSION['UserId'] = $data['UserId'];
		$_SESSION['FName'] = $data['FName'];
		$_SESSION['LName'] = $data['LName'];
		$_SESSION['Type'] = $data['Type'];
		$_SESSION['Email'] = $data['Email'];
		
		// Store the HTTP_USER_AGENT:
		$_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);
		
		SESSION_WRITE_CLOSE();
		
		// Redirect:
		redirect_user('Index.php');
			
	} else { // Unsuccessful!

		// Assign $data to $errors for LoginPage.php:
		$errors = $data;

	}
		
	mysqli_close($dbc); // Close the database connection.

} // End of the main submit conditional.

// Create the page:
include ('LoginPage.php');
?>