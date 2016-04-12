<?php
/*********************************************************************************************
 * Original Author: Benjamin Brackett
 * Date of origination: 04/12/2016
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
$page_title = 'Browse SFCR Members';
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
	$criticalIncidentQuery = "SELECT FName, LName, VerifiedMemberCode 
	FROM users ORDER BY VerifiedMemberCode;";
	$criticalIncidentIdQuery = "SELECT VerifiedMemberCode FROM criticalincidents;";
	
	// Written by Shane Workman.
	$selectQuery = @mysqli_query($dbc, $criticalIncidentQuery);
	$idSelectQuery = @mysqli_query($dbc, $criticalIncidentIdQuery);	
	
	//Creates table body. Function by Mark Bowman 
	$headerCounter = mysqli_num_fields($selectQuery);
	$tableBody = tableRowGeneratorWithButtons($selectQuery, $editButton, 1, $headerCounter);
?>		

<h1>Critical Incidents</h1>
<fieldset>
	<table>
		<thead>
			<tr>
				<th>--First Name--</th>
				<th>--Last Name--</th>
				<th>--SFCR Member Code--</th>
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
