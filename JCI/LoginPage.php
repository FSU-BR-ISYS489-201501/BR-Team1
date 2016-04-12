<?php 
/*********************************************************************************************
 * Original Author: Benjamin Brackett
 * Date of origination: 02/14/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: Script 12.1 - login_page.inc.php. This page prints any errors associated with logging in and it creates the entire login page, including the form. 
 * Credit: Ullman, Larry (2011-09-13). PHP and MySQL for Dynamic Web Sites, Fourth Edition: Visual QuickPro Guide (4th Edition) 
 * 			(Kindle Location 30). Pearson Education. Kindle Edition.
 *
 * Revision1.1: MM/DD/YYYY Author: Name Here 
 * Description of change. Also add //Name: comments above your change within the code.
 ********************************************************************************************/

// Include the header:
$page_title = 'Login';
include ('includes/Header.php');

// Print any error messages, if they exist:
if (isset($errors) && !empty($errors)) {
	echo '<h1>Error!</h1>
	<p class="error">The following error(s) occurred:<br />';
	foreach ($errors as $msg) {
		echo " - $msg<br />\n";
	}
	echo '</p><p>Please try again.</p>';
}

// Display the form:
?>
<h1>Login</h1>
<fieldset>
	<form action="Login.php" method="post">
		<p>Email Address: <input type="text" name="email" size="20" maxlength="60" /> </p>
		<p>Password: <input type="password" name="pass" size="20" maxlength="20" /></p>
		<p><input type="submit" name="submit" value="Login" /></p>
		<a href="PasswordHelp.php">Forgot Password?</a>
	</form>
</fieldset>
<?php include ('includes/Footer.php'); ?>