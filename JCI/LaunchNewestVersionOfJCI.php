<?php
/*********************************************************************************************
 * Original Author: Name Here
 * Date of origination: MM/DD/YYYY
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: Include a overview of the page: Such as. This is the index.php and will serve as the home page content of the site.\
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
 
 	include('includes/Header.php');
	include('includes/TableRowHelper.php');
	include('../DbConnector.php');
 	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		//Update the current JCI volume.
	}
	
 	$err = array();
	$missingFiles = array();
	$criticalIncidentsWithFiles = array();
	$criticalIncidentIds = array();
 	$latest = 7;
	$fileCounter = 0;
 	$approvedSubmissionQuery = 	"SELECT CriticalIncidentId
					 			FROM criticalincidents 
					 			WHERE ApprovedPublish = 1 AND JournalId = {$latest};";
	$fileLocationQuery = '';
	$tableBody = '';
	
	// Stole from Shane Workman's Register code
	if ($selectQuery = @mysqli_query($dbc, $approvedSubmissionQuery)) {
		
		if ($row = mysqli_fetch_row($selectQuery)) {
			array_push($criticalIncidentIds, $row[0]);
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
	
	if ($fileLocationSelectQuery = @mysqli_query($dbc, $fileLocationQuery)) {
		// $headerCounter = mysqli_num_fields($fileLocationSelectQuery);
		// $tableBody = tableRowGenerator($fileLocationSelectQuery, $headerCounter);
		
		//This function resets the resultset to 0. Shef @ http://stackoverflow.com/questions/6439230/how-to-go-through-mysql-result-twice
		// mysqli_data_seek($fileLocationSelectQuery, 0);
		
		$rowCounter = mysqli_num_rows($fileLocationSelectQuery);
		
		for($a = 0; $a < count($criticalIncidentIds); $a++) {
			while ($row = mysqli_fetch_row($fileLocationSelectQuery)) {
				if ($criticalIncidentIds[$a] == "$row[0]") {
					$fileCounter++;
					break;
				}
			}
		}
			
		if ($fileCounter == count($criticalIncidentIds)) {
			echo '<form action="LaunchNewestVersionOfJCI.php" method = "POST"><input type="submit" value="Launch the Latest Volume"></form>';
		}
		else {
			echo 'Not all PDFs have been uploaded.';
		}
	}
?>

<?php
	include('includes/Footer.php');
?>