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
 * Revision1.1: MM/DD/YYYY Author: Name Here 
 * Description of change. Also add //Name: comments above your change within the code.
 ********************************************************************************************/
 	include('Header.php');
	include('TableRowHelper.php');
	require('../DbConnector.php');
	
	$currentDate = date("Y-m-d");
	$query = "SELECT ANNOUNCEMENT_ID, NOTE FROM announcement WHERE ACTIVE = 1 AND START_DATE < '{$currentDate}' 
		AND END_DATE > '{$currentDate}';";
	
	// Stole from Shane Workman's Register code
	$selectQuery = @mysqli_query($dbc, $query);
	
	$headerCounter = countNumberOfFields($dbc, $selectQuery);
	$tableBody = tableRowGenerator($dbc, $selectQuery, $headerCounter);
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
	include('Footer.php');
?>