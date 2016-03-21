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
 ********************************************************************************************/
	include('includes/Header.php');
	include('includes/TableRowHelper.php');
	require('../DbConnector.php');
	
	$critincQuery = "SELECT CriticalIncidentId, CriticalIncidentLocation, SummaryLocation, TeachingNoteLocation, MemoLocation, CoverPageLocation, Category, Title FROM criticalincidents;";
	$critincIdQuery = "SELECT CriticalIncidentId FROM criticalincidents;";
	
	// Written by Shane Workman.
	$selectQuery = @mysqli_query($dbc, $critincQuery);
	$idSelectQuery = @mysqli_query($dbc, $critincIdQuery);
	
	$headerCounter = mysqli_num_fields($selectQuery);
	$assignButton = tableRowEditGenerator($idSelectQuery);
	// it will add two links in every row 
	$buttonCounter = count($assignButton)/2;
	$tableBody = tableRowGeneratorWithButtons($selectQuery, $assignButton, $buttonCounter, $headerCounter);
?>
	<h1>Critical Incidents</h1>
	<div id = 'announcementViewer'>
		<table>
			<tr>
				<th>C.I. Id</th>
				<th>C.I. Loc.</th>
				<th>Sum. Loc.</th>
				<th>Tea. Not. Loc.</th>
				<th>Mem. Loc.</th>
				<th>Cov. Pag. Loc.</th>
				<th>Category</th>
				<th>Title</th>
			</tr>
			<?php echo $tableBody; ?>
		</table>
	</div>
	
<?php
	include('includes/Footer.php');
?>