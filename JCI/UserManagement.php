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
		header('Location: http://br-t1-jci.sfcrjci.org/Index.php');
		exit;
	}
?>
