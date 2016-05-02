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
 * Revision1.1: 04/10/2016 Author: Mark Bowman
 * Description of change. The layout of the file was altered in order to allow redirects to 
 * occur. If the header function is called after content is displayed, it will not redirect.
 * 
 * Credit: I found out about the header function problem after reading the post by Daedalus
 * at http://stackoverflow.com/questions/21522384/php-header-location-url-php-not-working-in-godaddy.
 ********************************************************************************************/
	session_start();
	
	if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor') {
		require('../DbConnector.php');
		// Citation: Michael J. Calkins.
		// This block will check if 'deleteId' is set in the url. It will set the announcement with that value to inactive.
		if (isset($_GET['deleteId'])) {
			$announcementDeactivateQuery = "UPDATE announcements SET IsActive = 0 WHERE AnnouncementId = {$_GET['deleteId']};";
			$deactivateQuery = @mysqli_query($dbc, $announcementDeactivateQuery);
			if($deactivateQuery){
				header('Location: ManageAnnouncements.php');
				exit;
			}
		}
		
		// Citation: Michael J. Calkins.
		// This block will check if 'activateId' is set in the url. It will set the announcement with that value to active.
		if (isset($_GET['activateId'])) {
			$announcementActivateQuery = "UPDATE announcements SET IsActive = 1 WHERE AnnouncementId = {$_GET['activateId']};";
			$activateQuery = @mysqli_query($dbc, $announcementActivateQuery);
			if($activateQuery){
				header('Location: ManageAnnouncements.php');
				exit;
			}
		}
		
		$page_title = 'Manage Announcements';
		include('includes/Header.php');
		include('includes/TableRowHelper.php');
		
		$announcementQuery = "SELECT AnnouncementId, Subject, Body, StartDate, EndDate, Type, IsActive FROM announcements;";
		$announcementIdQuery = "SELECT AnnouncementId FROM announcements;";
		
		// The idea for this code was inspired by Shane.
		$selectQuery = @mysqli_query($dbc, $announcementQuery);
		$idSelectQuery = @mysqli_query($dbc, $announcementIdQuery);
		
		$pageNames = array('EditAnnouncement.php', 'ManageAnnouncements.php', 'ManageAnnouncements.php');
		$variableNames = array('id', 'deleteId', 'activateId');
		$titles = array('Edit', 'Deactivate', 'Activate');
		
		$headerCounter = mysqli_num_fields($selectQuery);
		$editButton = tableRowLinkGenerator($idSelectQuery, $pageNames, $variableNames, $titles);
		$tableBody = tableRowGeneratorWithButtons($selectQuery, $editButton, 3, $headerCounter);
	}
	else {
		header('Location: Index.php');
		exit;
	}
?>
<h1>Manage Announcements</h1>
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
	<br/>
	<br/>
	<a href="PostNewAnnouncement.php" class = 'button4'>Create a New Announcement</a>
	
<?php
	include('includes/Footer.php');
?>
