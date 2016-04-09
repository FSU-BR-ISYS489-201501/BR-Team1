<?php
/*********************************************************************************************
 * Original Author: Mark Bowman
 * Date of origination: 02/17/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: The purpose of this file is to display a page in the browser that will allow
 * users to view all active announcements and their content.
 * Credit: Give any attributation to code used within, not created by you.
 *
 * Revision1.1: 04/09/2016 Author: Mark Bowman
 * Description of change. Also add //Name: comments above your change within the code.
 ********************************************************************************************/
 	$page_title = 'Announcements';
 	include('includes/Header.php');
	include('includes/TableRowHelper.php');
	require('../DbConnector.php');
	
	$currentDate = date("Y-m-d");
	$query = "SELECT AnnouncementId, Subject, Body FROM announcements WHERE IsActive = 1 AND StartDate < '{$currentDate}' 
		AND EndDate > '{$currentDate}';";
	
	// Stole from Shane Workman's Register code
	$selectQuery = @mysqli_query($dbc, $query);
	
	$headerCounter = mysqli_num_fields($selectQuery);
	$tableBody = tableRowGenerator($selectQuery, $headerCounter);
	
	// Mark Bowman: I added code to check if the body of the table contains any data before displaying the rest of the table.
	// The idea for this code was inspired by Shane.
	if (!empty($tableBody)) {
		echo "
			<br/>
			<div id = 'fileViewer'>
				<table>
					<tr>
						<th>FileId</th>
						<th>CriticalIncidentId</th>
						<th>FileDes</th>
					</tr>
					$tableBody
				</table>
			</div>
		";
	}
?>
<?php
	include('includes/Footer.php');
?>