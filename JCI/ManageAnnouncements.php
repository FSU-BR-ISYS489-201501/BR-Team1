<?php
/*********************************************************************************************
 * Original Author: Mark Bowman
 * Date of origination: 02/17/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: The purpose of this file is to display a page in the browser that shows all
 * announcements (active and inactive) with buttons that will allow the edit, activation, and
 * deactivation of announcements.
 * Credit: I used code written by Michael J. Calkins as an inspiration for executing a function
 * through a php link. This was obtained from http://stackoverflow.com/questions/19323010/execute-php-function-with-onclick.
 * I used code written by Shane Workman to make database queries.
 *
 * Revision1.1: MM/DD/YYYY Author: Name Here 
 * Description of change. Also add //Name: comments above your change within the code.
 ********************************************************************************************/
	$page_title = 'Manage Announcements';
	include('includes/Header.php');
	include('includes/TableRowHelper.php');
	require('../DbConnector.php');
	session_start();
	
	if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor') {
	
		$announcementQuery = "SELECT AnnouncementId, Subject, Body, StartDate, EndDate, Type, IsActive FROM announcements;";
		$announcementIdQuery = "SELECT AnnouncementId FROM announcements;";
		
		// Written by Shane Workman.
		$selectQuery = @mysqli_query($dbc, $announcementQuery);
		$idSelectQuery = @mysqli_query($dbc, $announcementIdQuery);
		
		
		// The idea for this code was inspired by Michael J. Calkins.
		// This block will check if 'deleteId' is set in the url. It will set the announcement with that value to inactive.
		if (isset($_GET['deleteId'])) {
			$announcementDeactivateQuery = "UPDATE announcements SET IsActive = 0 WHERE AnnouncementId = {$_GET['deleteId']};";
			$deactivateQuery = @mysqli_query($dbc, $announcementDeactivateQuery);
			if($deactivateQuery){
				header('Location: http://localhost/jci/ManageAnnouncements.php');
			}
		}
		
		
		// The idea for this code was inspired by Michael J. Calkins.
		// This block will check if 'activateId' is set in the url. It will set the announcement with that value to active.
		if (isset($_GET['activateId'])) {
			$announcementActivateQuery = "UPDATE announcements SET IsActive = 1 WHERE AnnouncementId = {$_GET['activateId']};";
			$activateQuery = @mysqli_query($dbc, $announcementActivateQuery);
			if($activateQuery){
				header('Location: http://localhost/jci/ManageAnnouncements.php');
			}
		}
		
		$pageNames = array('EditAnnouncement.php', 'ManageAnnouncements.php', 'ManageAnnouncements.php');
		$variableNames = array('id', 'deleteId', 'activateId');
		$titles = array('Edit', 'Deactivate', 'Activate');
		
		$headerCounter = mysqli_num_fields($selectQuery);
		$editButton = tableRowLinkGenerator($idSelectQuery, $pageNames, $variableNames, $titles);
		$tableBody = tableRowGeneratorWithButtons($selectQuery, $editButton, 3, $headerCounter);
	}
	else {
		header('Location: http://localhost/jci/Index.php');
	}
?>

	<div id = 'announcementViewer'>
		<table>
			<tr>
				<th>Number</th>
				<th>Subject</th>
				<th>Announcement</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Type</th>
				<th>Active</th>
			</tr>
			<?php echo $tableBody; ?>
		</table>
	</div>
	
<?php
	include('includes/Footer.php');
?>
