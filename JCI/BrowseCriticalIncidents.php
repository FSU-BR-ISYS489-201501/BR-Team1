<?php
/*********************************************************************************************
 * Original Author: Benjamin Brackett
 * Date of origination: 03/13/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: As an Editor, I need to be able to view a list of Critical Incidents based on status, 
 * 			revision round, etc. 
 * 			Search Criteria (May be all active CIs, CIs in a particular round, etc. 
 * 			Does not search on Keywords, Title, or other standard criteria)
 * Credit: https://www.youtube.com/watch?v=PBLuP2JZcEg
 *
 * Function: functionName($myVar, $varTwo)
 * Purpose: This is the description of what the function does.
 * Variable: $myVar - Description of variable.
 * Variable: $varTwo - Another description.
 *
 * Function:  functionNameTwo($anotherVar)
 * Purpose: This is the description of what the function does.
 * Variable: $anotherVar - Description of variable. 
 *
 * Revision1.1: MM/DD/YYYY Author: Benjamin Brackett
 * Description of change. Also add //Name: comments above your change within the code.
 ********************************************************************************************/
$page_title = 'Browse Critical Incidents';
include('includes/Header.php');
include('includes/TableRowHelper.php');
require('../DbConnector.php');

$output = '';
$search = '';
$query = '';
$editButton = array();
$button = "<td><select>";
$selectQuery = '';
$idSelectQuery = '';
$editors = '';
$headerCounter = '';
$tableBody = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') 

	//Set up Error msg array
 	$err = array(); 

	// Collect data from table
	$criticalIncidentQuery = "SELECT Title, Category, ApprovedReview, ApprovedPublish 
	FROM criticalincidents ORDER BY criticalincidents.CriticalIncidentId;";
	$criticalIncidentIdQuery = "SELECT CriticalIncidentId FROM criticalincidents;";
	
	// Written by Shane Workman.
	$selectQuery = @mysqli_query($dbc, $criticalIncidentQuery);
	$idSelectQuery = @mysqli_query($dbc, $criticalIncidentIdQuery);	
	
	// Push CI Id to FileMgmt			
	$pageNames = array('CriticalIncidentManagement.php', 'FileManagement.php');
	$variableNames = array('id', 'CriticalIncidentId');
	$titles = array('View', 'Manage Files');
	
	//Edit button creates view link in table for each CI Id
	$headerCounter = mysqli_num_fields($selectQuery);
	$editButton = tableRowLinkGenerator($idSelectQuery, $pageNames, $variableNames, $titles);
	$tableBody = tableRowGeneratorWithButtons($selectQuery, $editButton, 2, $headerCounter);
?>		

<h1>Critical Incidents</h1>
<fieldset>
	<table>
		<thead>
			<tr>
				<th>--Title--</th>
				<th>--Category--</th>
				<th>--Approved for Review (1=Yes, 0=No)--</th>
				<th>--Approved for Publication (1=Yes, 0=No)--</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			echo $tableBody;
			?>	
		</tbody>
	</table>
</fieldset>
<?php
include ("includes/Footer.php");
?>
