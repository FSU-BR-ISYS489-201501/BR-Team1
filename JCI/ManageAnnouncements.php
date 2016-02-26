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
	include('Header.php');
	include('TableRowHelper.php');
	require('../DbConnector.php');
	
	$announcementQuery = "SELECT AnnouncementId, Subject, Body, StartDate, Type, EndDate, IsActive FROM Announcement;";
	$announcementIdQuery = "SELECT AnnouncementId FROM announcement;";
	
	// Written by Shane Workman.
	$selectQuery = @mysqli_query($dbc, $announcementQuery);
	$idSelectQuery = @mysqli_query($dbc, $announcementIdQuery);
	
	
	// The idea for this code was inspired by Michael J. Calkins.
	// This block will check if 'deleteId' is set in the url. It will set the announcement with that value to inactive.
	if (isset($_GET['deleteId'])) {
		$announcementDeactivateQuery = "UPDATE announcement SET ACTIVE = 0 WHERE ANNOUNCEMENT_ID = {$_GET['deleteId']};";
		$deactivateQuery = @mysqli_query($dbc, $announcementDeactivateQuery);
		if($deactivateQuery){
		}
	}
	
	
	// The idea for this code was inspired by Michael J. Calkins.
	// This block will check if 'activateId' is set in the url. It will set the announcement with that value to active.
	if (isset($_GET['activateId'])) {
		$announcementActivateQuery = "UPDATE announcement SET ACTIVE = 1 WHERE ANNOUNCEMENT_ID = {$_GET['activateId']};";
		$activateQuery = @mysqli_query($dbc, $announcementActivateQuery);
		if($activateQuery){
		}
	}
	
	$headerCounter = countNumberOfFields($dbc, $selectQuery);
	$editButton = tableRowLinkGenerator($dbc, $idSelectQuery);
	$tableBody = tableRowGeneratorWithButtons($dbc, $selectQuery, $editButton, $headerCounter);
?>

	<div id = 'announcementViewer'>
		<table>
			<tr>
				<th>Announcement Number</th>
				<th>Announcement</th>
			</tr>
			<?php echo $tableBody; ?>
		</table>
	</div>
	
<?php
?>
