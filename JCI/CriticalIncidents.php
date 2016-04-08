<?php
/*********************************************************************************************
 * Original Author:Faisal Alfadhli
 * Date of origination: 03/17/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: The purpose of this file is to display a page in the browser that shows all
 * Critical Incidents with buttons that will allow the assgin, remove reviewers 
 * Credit: I used code written by Shane to make database queries.
 * 
 * 
 ********************************************************************************************/
	include('includes/Header.php');
	include('includes/TableRowHelper.php');
	require('../DbConnector.php');
	
	$critincQuery = "SELECT CriticalIncidentId, UserId, Category, Title FROM criticalincidents;";
	$critincIdQuery = "SELECT CriticalIncidentId FROM criticalincidents;";
	
	// Written by Shane Workman.
	$selectQuery = @mysqli_query($dbc, $critincQuery);
	$idSelectQuery = @mysqli_query($dbc, $critincIdQuery);
	
	$headerCounter = mysqli_num_fields($selectQuery);
	$pageNames = array('AssignReviewers.php', 'RemoveReviewers.php');	
	$titles = array('Assign', 'Remove');
	$assignButton = tableRowEditGenerator($idSelectQuery, $pageNames, $titles);
	// it will add two links in every row 
	$rowCount = mysqli_num_rows($idSelectQuery);
	// inspired by William.
	if ($rowCount > 0) {
		$buttonCounter = count($assignButton)/$rowCount;
		// called this function from table row helper.
		$tableBody = tableRowGeneratorWithButtons($selectQuery, $assignButton, $buttonCounter, $headerCounter);
	} else {
		$tableBody = "<tr><td>No results available to display.</td></tr>";
	}
?>
	<h1>Critical Incidents - Assign Reviewers</h1>
	<div id = 'announcementViewer'>
		<table>
			<tr>
				<th>C.I. Id</th>
				<th>User Id</th>
				<th>Category</th>
				<th>Title</th>
			</tr>
			<?php echo $tableBody; ?>
		</table>
	</div>
	
<?php
	include('includes/Footer.php');
?>