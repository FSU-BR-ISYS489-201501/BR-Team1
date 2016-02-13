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

 
require_once('login.php');


session_start();

 $username = '';
if(isset($_SESSION['user'])) {
	$username = $_SESSION['user'];
	echo $username . ", you are being logged out."; 
	$user->logout();
	header("Refresh: 3; url=index.php");
	exit();
} else {
	header("Location: index.php");
	exit();
}
?>