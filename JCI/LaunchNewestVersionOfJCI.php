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
 	
	session_start();
	if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor') {
		
		// Makes the latest volume go live
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//Update the current JCI volume.
		}
		
		$tableBody = '';
		$latest = 7;
	
		$criticalIncidentQuery = 	"SELECT CriticalIncidentId, Title, JournalId
						 			FROM criticalincidents 
						 			WHERE ApprovedPublish = 1 AND JournalId = {$latest} ORDER BY CriticalIncidentId;";
									
		$criticalIncidentIdQuery = 	"SELECT CriticalIncidentId
						 			FROM criticalincidents 
						 			WHERE ApprovedPublish = 1 AND JournalId = {$latest} ORDER BY CriticalIncidentId;";
		
		// Written by Shane Workman.
		$criticalIncidentSelectQuery = @mysqli_query($dbc, $criticalIncidentQuery);
		$criticalIncidentIdSelectQuery = @mysqli_query($dbc, $criticalIncidentIdQuery);
	
		$pageNames = array('FileManagement.php');
		$variableNames = array('id');
		$titles = array('View');
		
		$headerCounter = mysqli_num_fields($criticalIncidentSelectQuery);
		$editButton = tableRowLinkGenerator($criticalIncidentIdSelectQuery, $pageNames, $variableNames, $titles);
		$tableBody = tableRowGeneratorWithButtons($criticalIncidentSelectQuery, $editButton, 1, $headerCounter);
	
		echo "
			<div id = 'announcementViewer'>
				<table>
					<tr>
						<th>ID</th>
						<th>Title</th>
						<th>Volume</th>
					</tr>
					$tableBody
				</table>
			</div>
		";
		
		
		// Shows the submit button or an error message.
		// Declaring variables for future use.
	 	$err = array();
		$criticalIncidentsWithoutFiles = array();
		$criticalIncidentIds = array();
		$fileCounter = 0;
		$fileLocationQuery = '';
		$tableBody = '';
		
	 	$approvedSubmissionQuery = 	"SELECT CriticalIncidentId
						 			FROM criticalincidents 
						 			WHERE ApprovedPublish = 1 AND JournalId = {$latest}
									ORDER BY CriticalIncidentId;";
		
		
		// Written by Shane Workman.
		if ($selectQuery = @mysqli_query($dbc, $approvedSubmissionQuery)) {
			
			if ($row = mysqli_fetch_row($selectQuery)) {
				array_push($criticalIncidentIds, $row[0]);
				
				// Creating the query to verify if Critical Incidents have files
				// associated with them.
				$fileLocationQuery = 	"SELECT CriticalIncidentId, FileDes
										FROM files
										WHERE CriticalIncidentId = {$row[0]}";
				while ($row = mysqli_fetch_row($selectQuery)) {
					array_push($criticalIncidentIds, $row[0]);
					$fileLocationQuery = $fileLocationQuery . " OR CriticalIncidentId = {$row[0]}";
				}
				$fileLocationQuery = $fileLocationQuery . " ORDER BY CriticalIncidentId";
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
			
			$data = array();
			
			// This loop determines if each record contains a file that is associated
			// with a Critical Incident in the initial query.
			for($a = 0; $a < count($criticalIncidentIds); $a++) {
				$currentIdFileCounter = 0;
				while ($row = mysqli_fetch_row($fileLocationSelectQuery)) {
					if ($criticalIncidentIds[$a] == "$row[0]") {
						$currentIdFileCounter++;
					}
				}
				//This function resets the resultset to 0. Shef @ http://stackoverflow.com/questions/6439230/how-to-go-through-mysql-result-twice
				mysqli_data_seek($fileLocationSelectQuery, 0);
				$data[$a] = array($criticalIncidentIds[$a], $currentIdFileCounter);
			}
			
			// Generates the submit button.	
			
			// TODO: This is broken. Fix it. Determining what Critical Incident is missing files is proving to be difficult.
			
			if (count($data) != 0) {
				for($a = 0; $a < count($data); $a++) {
					if (isset($data[$a][1])) {
						if ($data[$a][1] != 2) {
							$err[] = "Critical Incident number {$data[$a][0]} has {$data[$a][1]} PDF files.";
						}
					}
				}
				if (empty($err)) {
					echo '<form action="LaunchNewestVersionOfJCI.php" method = "POST"><input type="submit" value="Launch the Latest Volume"></form>';
				}
			}
			else {
				$err[] = 'No submitted Critical Inicdents have been approved for publication.';
			}
		}
	
		// Generates any error messages.
		for($i = 0; $i < count($err); $i++) {
				echo "{$err[$i]} <br />";
		}
	}
	else {
		header('Location: http://localhost/jci/Index.php');
	}
?>

<?php
	include('includes/Footer.php');
?>