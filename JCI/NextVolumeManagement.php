<?php
/*********************************************************************************************
 * Original Author: Mark Bowman
 * Date of origination: 04/29/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: The purpose of this page is to provide the editor a landing page for tools
 * that allow the editor to manage the next volume of the JCI.
 * 
 ********************************************************************************************/

	session_start();
	if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor') {
		$page_title = 'Next Volume Management'; 
		include ("includes/Header.php");
		echo "<h1>Next Volume Management</h2>";
		echo "<fieldset>";
		echo "<br/><a href='ChangeSubmissionDates.php' class = 'button4'>Set the Submission Dates for the Next Volume</a><br/>";
		echo "<br/><a href='Category.php' class = 'button4'>Browse Categories for the Next Volume</a><br/>";
		echo "<br/><a href='ChooseForPublication.php' class = 'button4'>Choose Critical Incidents for the Next Volume</a><br/>";
		echo "<br/><a href='LaunchNewestVolume.php' class = 'button4'>Finalize the Next Volume</a><br/>";
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