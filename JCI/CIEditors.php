<?php
/*********************************************************************************************
 * Original Author:Faisal Alfadhli
 * Date of origination: 03/30/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: The purpose of this file is to display a page in the browser that shows all
 * Critical Incidents with buttons that will allow the assgin, remove editors
 * Credit: I used code written by Shane to make database queries. Credit to William and http://stackoverflow.com/
 * 
 ********************************************************************************************/

	include('includes/Header.php');
	include('includes/TableRowHelper.php');
	require('../DbConnector.php');
	
	// $critincQuery: joining tables to get some info and display them.
	$critincQuery = "SELECT criticalincidents.CriticalIncidentId, criticalincidents.UserId, criticalincidents.Category,
							criticalincidents.Title, users.Fname, users.Lname FROM criticalincidents INNER JOIN users ON users.UserId=criticalincidents.Editor;";
	$critincIdQuery = "SELECT CriticalIncidentId FROM criticalincidents;";
	
	// Written by Shane Workman.
	$selectQuery = @mysqli_query($dbc, $critincQuery);
	$idSelectQuery = @mysqli_query($dbc, $critincIdQuery);
	
	$headerCounter = mysqli_num_fields($selectQuery);
	// create two buttons in every row and link them to assgin or remove
	$pageNames = array('AssignCasesToEditors.php', 'RemoveCasesFromEditors.php');
	$titles = array('Assign', 'Remove');
	$assignButton = tableRowEditGenerator($idSelectQuery, $pageNames, $titles);
	// it will add two links in every row 
	$rowCount = mysqli_num_rows($idSelectQuery);
	$buttonCounter = count($assignButton)/$rowCount;
	$pageNames = array('AssignCasesToEditors.php', 'RemoveCasesFromEditors.php');
	$tableBody = tableRowGeneratorWithButtons($selectQuery, $assignButton, $buttonCounter, $headerCounter);
?>
	<h1>Critical Incidents - Assign Editors</h1>
	<div id = 'announcementViewer'>
		<table>
			<tr>
				<th>C.I. Id</th>
				<th>User Id</th>
				<th>Category</th>
				<th>Title</th>
				<th>Editor</th>
			</tr>
			<?php echo $tableBody; ?>
		</table>
	</div>
	
<?php
	include('includes/Footer.php');
?>