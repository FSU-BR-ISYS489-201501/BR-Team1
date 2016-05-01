<?php
/*********************************************************************************************
 * Original Author: Mark Bowman
 * Date of origination: 04/17/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: The purpose of this page is to provide the editor a landing page for tools
 * that allow the editor to manage the website.
 * 
 ********************************************************************************************/

	session_start();
	if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor') {
		$page_title = 'Website Management'; 
		include ("includes/Header.php");
		echo "<h1>Website Management</h2>";
		echo "<fieldset>";
		echo "<br/><a href='EditFiles.php' class = 'button4'>Activate and Deactivate Files</a><br/>";
		echo "<br/><a href='BrowseCriticalIncidents.php' class = 'button4'>Browse Critical Incidents</a><br/>";
		echo "<br/><a href='ManageAnnouncements.php' class = 'button4'>Manage Announcements</a><br/>";
		echo "<br/><a href='ContentManagementSelector.php' class = 'button4'>Manage Website Content</a><br/>";
		echo "<br/><a href='ImageManagement.php' class = 'button4'>Manage Images</a><br/>";
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
