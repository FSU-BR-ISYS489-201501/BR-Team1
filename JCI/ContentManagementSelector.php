<?php
/*********************************************************************************************
 * Original Author: Mark Bowman
 * Date of origination: 04/14/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: This file will show links that will all direct an editor to the content management
 * page, but each link will include a distinct id value. That value will be used in content
 * management to determine which page will be modified.
 ********************************************************************************************/
 
 	session_start();
	
	// This checks to see if the logged in user is an editor.
	if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor') {
		$page_title = 'Content Management'; 
		include ("includes/Header.php");
		echo "<h1>Content Management</h2>";
		echo "<fieldset>";
		echo "<br/><a href='ContentManagement.php?id=1' class = 'button2'>Manage the Home Page</a><br/><br>";
		echo "<br/><a href='ContentManagement.php?id=2' class = 'button2'>Manage the About Us Page</a><br/><br>";
		echo "<br/><a href='ContentManagement.php?id=3' class = 'button2'>Manage the Editor Names on the About Us Page</a><br/><br>";
		echo "<br/><a href='ContentManagement.php?id=4' class = 'button2'>Manage the Ethics Policy and Malpractice Page</a><br/><br>";
		echo "<br/><a href='ContentManagement.php?id=5' class = 'button2'>Manage the Editorial Policy Page</a><br/><br>";
		echo "</fieldset>";
	}
	else {
		header('Location: Index.php');
		exit;
	}
	
?>