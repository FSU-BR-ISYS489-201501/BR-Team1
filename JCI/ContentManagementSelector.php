<?php
/*********************************************************************************************
 * Original Author: Mark Bowman
 * Date of origination: 04/14/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: This file will allow an editor to modify the content on the index, about us, 
 * ethics and editorial policy page.
 * Credit: Blocks of code have been borrowed from EditAnnouncement.php in order to save time.
 * A combination of Faisal Alfadhli and William are responsible for those pieces of code on
 * lines: 35-40, 43-55, and 117-125.
 * 
 * Revision 1.1: 04/15/2016 Author: Mark Bowman
 * Description of Change: I changed the file to use prepared statements.
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
		header('Location: http://br-t1-jci.sfcrjci.org/Index.php');
		exit;
	}
	
?>