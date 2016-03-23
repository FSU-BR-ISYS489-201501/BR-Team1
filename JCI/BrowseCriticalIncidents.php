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
 * Revision1.1: MM/DD/YYYY Author: Name Here 
 * Description of change. Also add //Name: comments above your change within the code.
 ********************************************************************************************/
$page_title = 'Browse Critical Incidents';
include('includes/Header.php');
include('includes/TableRowHelper.php');
require('mysqli_connect.php');
//require('../DbConnector.php');

$output = '';
$search = '';
$query = '';
$editButton = array();
$button = "<td><select>";
$selectQuery = '';
$idSelectQuery = '';
$editors = '';
$headerCounter = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') 

	//Set up Error msg array.s
 	$err = array(); 

//collect
/**
if(isset($_POST['search'])) {
	if ($search == "ApprovedPublish") {
		$query = mysql_query("SELECT* from criticalincidents 
			LEFT JOIN (files) ON (CriticalIncidentId.ci=CriticalIncidentId.f) WHERE ApprovedPublish = $criteria ORDER BY CriticalIncidentId;") or die("could not access critical incidents.");
	} elseif ($search == "ApprovedReview") {
		$query = mysql_query("SELECT* from criticalincidents 
			LEFT JOIN (files) ON (CriticalIncidentId.ci=CriticalIncidentId.f) WHERE ApprovedReview = $criteria ORDER BY CriticalIncidentId;") or die("could not access critical incidents.");
	}**/
// Collect
if(isset($_POST['search'])) {
	$criticalIncidentQuery = "SELECT* FROM criticalincidents 
			LEFT JOIN (files) ON (criticalincidents.CriticalIncidentId=files.CriticalIncidentId) ORDER BY CriticalIncidentId;" or die("could not access critical incidents.");
	$criticalIncidentIdQuery = "SELECT CriticalIncidentId FROM criticalincidents;";
	
	// Written by Shane Workman.
	$selectQuery = @mysqli_query($dbc, $criticalIncidentQuery);
	$idSelectQuery = @mysqli_query($dbc, $criticalIncidentIdQuery);	
	
	$count = mysqli_num_rows($selectQuery);
			if ($count == 0) {
				$output = 'There were no search results!';
			}else{
				while ($row = mysqli_fetch_row($selectQuery)) {
					$CriticalIncidentId = $row['CriticalIncidentId'];
					$Title = $row['Title'];
					$ReviewerId = $row['ReviewerId'];
					$MemoLocation = $row['MemoLocation'];
					$CoverPageLocation = $row['CoverPageLocation'];
					$LetterToEditorLocation = $row['LetterToEditorLocation'];
					$Category = $row['Category'];
					$Active = $row['Active'];
					$ApprovedReview = $row['ApprovedReview'];
					$ApprovedPublish = $row['ApprovedPublish'];
					
				$output .= '<div>'
							.$Title.
							''
							.$ReviewerId.
							''
							.$MemoLocation.
							''
							.$CoverPageLocation.
							''
							.$LetterToEditorLocation.
							''
							.$Category.
							''
							.$Active.
							''
							.$ApprovedReview.
							''
							.$ApprovedPublish.
							'<div>';
				}	
				}
				
}
	$pageNames = array('ViewCriticalIncidents.php');
	$variableNames = array('CriticalIncidentId');
	$titles = array('View');
	
	for($a = 0; $a < count($editButton); $a++) {
			echo $editButton[$a];
			}
	
	$headerCounter = mysqli_num_fields($selectQuery);
	$editButton = tableRowLinkGenerator($idSelectQuery, $pageNames, $variableNames, $titles);
	$tableBody = tableRowGeneratorWithButtons($selectQuery, $editButton, 1, $headerCounter);
?>		

<h1>Critical Incidents</h1>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<fieldset>
		<!--<p>Criteria:
		<select name="search">
			<option <?php if(isset($_POST['search'])=="ApprovedPublish") echo'selected="selected"'; ?>    value="ApprovedPublish">ApprovedPublish</option>
			 <option <?php if(isset($_POST['search'])=="ApprovedReview") echo'selected="selected"'; ?>    value="ApprovedReview">ApprovedReview</option>
			temp unused. Will add more search on data as presented.
			<option <?php if(isset($_POST['search'])=="Journals Reviewed") echo'selected="selected"'; ?>    value="Journals Reviewed">Journals Reviewed</option>
			<option <?php if(isset($_POST['search'])=="Journals Reviewed") echo'selected="selected"'; ?>    value="Journals Reviewed">Journals Reviewed</option>
			<option <?php if(isset($_POST['search'])=="Journals Reviewed") echo'selected="selected"'; ?>    value="Journals Reviewed">Journals Reviewed</option>
			<option <?php if(isset($_POST['search'])=="Journals Reviewed") echo'selected="selected"'; ?>    value="Journals Reviewed">Journals Reviewed</option>
			<option <?php if(isset($_POST['search'])=="Journals Reviewed") echo'selected="selected"'; ?>    value="Journals Reviewed">Journals Reviewed</option>
			-->
		</select></p>
		<p><input type="submit" value="search" /></p>
		<!--<p>On the criteria of:
		<select name="field">
			<option <?php if(isset($_POST['field'])=="First Name") echo'selected="selected"'; ?>    value="First Name">First Name</option>
			<option <?php if(isset($_POST['field'])=="Last Name") echo'selected="selected"'; ?>    value="Last Name">Last Name</option>
			<option <?php if(isset($_POST['field'])=="Email") echo'selected="selected"'; ?>    value="Email">Email</option>
		</select>
		<input type="text" name="criteria" size="15" maxlength="50" value="<?php if (isset($_POST['criteria'])) echo $_POST['criteria']; ?>" /></p>
		<p><input type="submit" value="Search" /></p>-->
	</fieldset>
</form> 
<fieldset>
	<table>
		<thead>
			<tr>
				<th>--Title--</th>
				<th>--Reviewers Assigned--</th>
				<th>--Memo--</th>
				<th>--Cover Page--</th>
				<th>--Letter to Editor--</th>
				<th>--Category--</th>
				<th>--Approved for Review--</th>
				<th>--Approved for Publication--</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			echo $tableBody;
			?>
			
		</tbody>
	</table>
</fieldset>
