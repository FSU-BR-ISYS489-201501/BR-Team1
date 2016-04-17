<?php
/*********************************************************************************************
 * Original Author: Name Here
 * Date of origination: MM/DD/YYYY
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: Include a overview of the page: Such as. This is the index.php and will serve as the home page content of the site.\
 * Credit: Give any attributation to code used within, not created by you.
 *
 * Function:  functionName($myVar, $varTwo)
 * Purpose: This is the description of what the function does.
 * Variable: $myVar - Description of variable.
 * Variable: $varTwo - Another description.
 *
 * Function:  functionNameTwo($anotherVar)
 * Purpose: This is the description of what the function does.
 * Variable: $anotherVar - Description of variable. 
 *
 * Revision1.1: MM/DD/YYYY Author: Name Here 
 * Description of change. Also add //Name: comments above your change within the code.
 ********************************************************************************************/

	session_start();
	if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor') {
		$page_title = 'Website Management'; 
		include ("includes/Header.php");
		echo "<h1>Website Management</h2>";
		echo "<fieldset>";
		echo "<br/><a href='BrowseCriticalIncidents.php' class = 'button4'>Browse Critical Incidents</a><br/>";
		echo "<br/><a href='ManageAnnouncements.php' class = 'button4'>Manage Announcements</a><br/>";
		echo "<br/><a href='ContentManagementSelector.php' class = 'button4'>Manage Website Content</a><br/>";
		echo "<br/><a href='ChangeSubmissionDates.php' class = 'button4'>Set the Submission Dates for the Next Volume</a><br/>";
		echo "<br/><a href='ChooseForPublication.php' class = 'button4'>Choose Critical Incidents for the Next Volume</a><br/>";
		echo "<br/><a href='LaunchNewestVolume.php' class = 'button4'>Finalize the Next Volume</a><br/>";
		echo "</fieldset>";
	}
	else {
		header('Location: http://br-t1-jci.sfcrjci.org/Index.php');
		exit;
	}
?>
