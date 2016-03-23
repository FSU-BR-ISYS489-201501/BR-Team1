<?php
/*********************************************************************************************
 * Original Author: Mark Bowman
 * Date of origination: 03/28/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: The purpose of this file is to check the database in order to verify that all 
 * approved for publish Critical Inicidents have at least one file associated with it in the
 * files table. If all approved Critical Incidents have at least one file associated with it, 
 * a submit button is generated. If all approved Critical Incidents do not have at least one
 * file associated with it, an error message is displayed.
 * 
 * Currently, pushing the submit button does nothing.
 * 
 * Credit: Give any attributation to code used within, not created by you.
 *
 * Function:  functionName($myVar, $varTwo)
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
 
 	$page_title = 'Launch Latest Volume of JCI';
 	include('includes/Header.php');
	include('includes/TableRowHelper.php');
	include('../DbConnector.php');
 	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		//Update the current JCI volume.
	}
	
	// Declaring variables for future use.
 	$err = array();
	$criticalIncidentsWithFiles = array();
	$criticalIncidentIds = array();
 	$latest = 7;
	$fileCounter = 0;
	$fileLocationQuery = '';
	$tableBody = '';
	
 	$approvedSubmissionQuery = 	"SELECT CriticalIncidentId
					 			FROM criticalincidents 
					 			WHERE ApprovedPublish = 1 AND JournalId = {$latest};";
	
	
	// Stole from Shane Workman's Register code
	if ($selectQuery = @mysqli_query($dbc, $approvedSubmissionQuery)) {
		
		if ($row = mysqli_fetch_row($selectQuery)) {
			array_push($criticalIncidentIds, $row[0]);
			
			// Creating the query to verify if Critical Incidents have files
			// associated with them.
			$fileLocationQuery = 	"SELECT CriticalIncidentId, FileLocation
									FROM files
									WHERE CriticalIncidentId = {$row[0]}";
			while ($row = mysqli_fetch_row($selectQuery)) {
				array_push($criticalIncidentIds, $row[0]);
				$fileLocationQuery = $fileLocationQuery . " OR CriticalIncidentId = {$row[0]}";
			}
			$fileLocationQuery = $fileLocationQuery . " ORDER BY CriticalIncidentId;";
		}
		else {
			$err[] = 'There were no approved Critical Incidents for the current JCI volume.';
		}
	}
	else {
		$err[] = 'There was an error connecting to the database.';
	}
	
	// This command executes the auto-generated SQL query.
	if ($fileLocationSelectQuery = @mysqli_query($dbc, $fileLocationQuery)) {
		// $headerCounter = mysqli_num_fields($fileLocationSelectQuery);
		// $tableBody = tableRowGenerator($fileLocationSelectQuery, $headerCounter);
		
		//This function resets the resultset to 0. Shef @ http://stackoverflow.com/questions/6439230/how-to-go-through-mysql-result-twice
		// mysqli_data_seek($fileLocationSelectQuery, 0);
		
		$rowCounter = mysqli_num_rows($fileLocationSelectQuery);
		
		// This loop determines if each record contains a file that is associated
		// with a Critical Incident in the initial query.
		for($a = 0; $a < count($criticalIncidentIds); $a++) {
			while ($row = mysqli_fetch_row($fileLocationSelectQuery)) {
				if ($criticalIncidentIds[$a] == "$row[0]") {
					$fileCounter++;
					break;
				}
			}
		}
		
		// Generates the submit button.	
		if ($fileCounter == count($criticalIncidentIds)) {
			echo '<form action="LaunchNewestVersionOfJCI.php" method = "POST"><input type="submit" value="Launch the Latest Volume"></form>';
		}
		else {
			$err[] = 'Not all PDFs have been uploaded.';
		}
	}

	// Generates any error messages.
	for($i = 0; $i < count($err); $i++) {
			echo "{$err[$i]} <br />";
	}
?>

<?php
	include('includes/Footer.php');
?>