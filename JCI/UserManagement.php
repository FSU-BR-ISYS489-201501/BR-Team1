<?php
/*********************************************************************************************
 * Original Author: Mark Bowman
 * Date of origination: 04/17/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: The purpose of this page is to provide the editor a landing page for tools
 * that allow the editor to manage user information on the website.
 * 
 ********************************************************************************************/

	session_start();
	if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor') {
		$page_title = 'User Management'; 
		include ("includes/Header.php");
		echo "<h1>User Management</h2>";
		echo "<fieldset>";
		echo "<br/><a href='ValidateSCR.php' class = 'button4'>Validate Member SCR Number</a><br/>";
		echo "<br/><a href='ReviewBoardEntry.php' class = 'button4'>Alter Review Board</a><br/>";
		// echo "<br/><a href='AssignCasesToEditors.php' class = 'button4'>Assign Critical Incidents to Editors</a><br/>";
		echo "</fieldset>";
	}
	else {
		header('Location: Index.php');
		exit;
	}
?>
<?php
	include ('includes/Footer.php');
?>
