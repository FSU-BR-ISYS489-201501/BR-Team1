<?php
/*********************************************************************************************
 * Original Author: Mark Bowman
 * Date of origination: 03/28/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: The purpose of this file is to check the database in order to verify that all 
 * approved for publish Critical Inicidents have at least one summary and one critical incident
 * associated with it in the files table. If all approved Critical Incidents have at least one 
 * summary and one CI associated with it, a submit button is generated. If all approved Critical Incidents 
 * do not have at least one summary and one CI associated with it, an error message is displayed.
 *
 * Revision1.1: 04/09/2016 Author: Mark Bowman
 * I altered the SQL query to allow for searching of the latest volume number. I also changed
 * the logic to check file types instead of just any record in the files table. Finally, I 
 * changed the output of the error messages slightly. It now includes an introductory sentence.
 ********************************************************************************************/
 
 	$page_title = 'Launch Latest Volume of JCI';
	include ("includes/FileHelper.php");
 	include('includes/Header.php');
	include('includes/TableRowHelper.php');
	include('../DbConnector.php');
	
	$latest = 0;
	$latestVolume = '';
	$currentDate = date('Y');
	
 	// Makes the latest volume go live
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$nextVolumeQuery = 	"SELECT JournalId, JournalVolume FROM journalofcriticalincidents WHERE InDevelopement = 1;";
		
		// The idea for this code was inspired by Shane.
		$nextVolumeSelectQuery = @mysqli_query($dbc, $nextVolumeQuery);
		
		if ($row = mysqli_fetch_array($nextVolumeSelectQuery, MYSQLI_ASSOC)) {
			$latest = $row['JournalId'];
			$latestVolume = $row['JournalVolume'];
		}
		
		//These variables will be used with the uploadFile function.
		$criticalIncidentIds = array();
		$types = array();
		$journalIds = array();
		
		array_push($criticalIncidentIds, 0);
		array_push($types, 'Journal');
		array_push($journalIds, $latest);
		
		if (uploadFile($dbc, "uploadedFile", "../uploads/", $criticalIncidentIds, $types, $journalIds)) {
		
			//Update the current JCI volume.
			$updateNextVolumeQuery = "UPDATE journalofcriticalincidents SET InDevelopement = 0 WHERE JournalId = $latest;";
			
			// The idea for this code was inspired by Shane.
			if ($updateNextVolumeSelectQuery = @mysqli_query($dbc, $updateNextVolumeQuery)) {
				if (mysqli_affected_rows($dbc)) {
					$latest++;
					$latestVolume = (int) $latestVolume;
					$currentDate = (int) $currentDate;
					$latestVolume++;
					$currentDate++;
					$createNewVolumeQuery = "INSERT INTO journalofcriticalincidents(JournalVolume, PublicationYear, InDevelopement)
											VALUES ('$latestVolume', '$currentDate', 1)";
					
					// The idea for this code was inspired by Shane.						
					$createNewVolumeInsertQuery = @mysqli_query($dbc, $createNewVolumeQuery);
				}
				else {
				
				}
			}
			else {
				echo 'nothing was updated!';
			}
		}
		else {
			echo 'Failed to upload the new volume.';
		}
	}
	
	session_start();
	if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor') {
		
		$nextVolumeQuery = 	"SELECT JournalId, JournalVolume FROM journalofcriticalincidents WHERE InDevelopement = 1;";
		
		// The idea for this code was inspired by Shane.
		$nextVolumeSelectQuery = @mysqli_query($dbc, $nextVolumeQuery);
		
		if ($row = mysqli_fetch_array($nextVolumeSelectQuery, MYSQLI_ASSOC)) {
			
			$latest = $row['JournalId'];
			$latestVolume = $row['JournalVolume'];
			$tableBody = '';
			// Mark Bowman: I altered the SQL query to check the volume number instead of the journal ID.
			$criticalIncidentQuery = 	"SELECT CriticalIncidentId, Title, JournalId
							 			FROM criticalincidents 
							 			WHERE ApprovedPublish = 1 AND JournalId = $latest ORDER BY CriticalIncidentId;";
										
			$criticalIncidentIdQuery = 	"SELECT CriticalIncidentId
							 			FROM criticalincidents 
							 			WHERE ApprovedPublish = 1 AND JournalId = $latest ORDER BY CriticalIncidentId;";
			
			// The idea for this code was inspired by Shane.
			$criticalIncidentSelectQuery = @mysqli_query($dbc, $criticalIncidentQuery);
			$criticalIncidentIdSelectQuery = @mysqli_query($dbc, $criticalIncidentIdQuery);
		
			$pageNames = array('FileManagement.php');
			$variableNames = array('CriticalIncidentId');
			$titles = array('View');
			
			$headerCounter = mysqli_num_fields($criticalIncidentSelectQuery);
			$editButton = tableRowLinkGenerator($criticalIncidentIdSelectQuery, $pageNames, $variableNames, $titles);
			$tableBody = tableRowGeneratorWithButtons($criticalIncidentSelectQuery, $editButton, 1, $headerCounter);
			
			// Mark Bowman: I added code to check if the body of the table contains any data before displaying the rest of the table.
			// The idea for this code was inspired by Shane.
			if (!empty($tableBody)) {
				echo "
					<br/>
					<div id = 'criticalIncidentViewer'>
						<table>
							<tr>
								<th>Number</th>
								<th>Title</th>
								<th>Volume</th>
							</tr>
							$tableBody
						</table>
					</div>
				";
			}
			
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
							 			WHERE ApprovedPublish = 1 AND JournalId = {$latest} ORDER BY CriticalIncidentId;";
			
			
			// The idea for this code was inspired by Shane.
			if ($selectQuery = @mysqli_query($dbc, $approvedSubmissionQuery)) {
				
				if ($row = mysqli_fetch_row($selectQuery)) {
					array_push($criticalIncidentIds, $row[0]);
					
					// Creating the query to verify if Critical Incidents have files
					// associated with them.
					$fileLocationQuery = 	"SELECT CriticalIncidentId, FileType
											FROM files
											WHERE Active = 1 AND CriticalIncidentId = {$row[0]} ";
					while ($row = mysqli_fetch_row($selectQuery)) {
						array_push($criticalIncidentIds, $row[0]);
						$fileLocationQuery = $fileLocationQuery . " OR CriticalIncidentId = {$row[0]}";
					}
					$fileLocationQuery = $fileLocationQuery . " ORDER BY CriticalIncidentId";
				}
				else {
					$err[] = "There are no approved Critical Incidents for JCI volume $latestVolume.";
				}
			}
			else {
				$err[] = 'There was an error connecting to the database.';
			}
			
			// This command executes the auto-generated SQL query.
			// The idea for this code was inspired by Shane.
			if ($fileLocationSelectQuery = @mysqli_query($dbc, $fileLocationQuery)) {
				
				$data = array();
				
				// This loop determines if each record contains a file that is associated
				// with a Critical Incident in the initial query.
				for($a = 0; $a < count($criticalIncidentIds); $a++) {
					$currentIdFileCounter = 0;
					while ($row = mysqli_fetch_array($fileLocationSelectQuery, MYSQLI_ASSOC)) {
						if (isset($row['FileType'])) {
							if (($criticalIncidentIds[$a] == $row['CriticalIncidentId'] && $row['FileType'] == 'Summary') || 
								($criticalIncidentIds[$a] == $row['CriticalIncidentId'] && $row['FileType'] == 'CI')) {
								$currentIdFileCounter++;
							}
						}
					}
					//This function resets the resultset to 0. Shef @ http://stackoverflow.com/questions/6439230/how-to-go-through-mysql-result-twice
					mysqli_data_seek($fileLocationSelectQuery, 0);
					$data[$a] = array($criticalIncidentIds[$a], $currentIdFileCounter);
				}
				
				// This block will generate the submit button if there were no errors.				
				if (count($data) != 0) {
					for($a = 0; $a < count($data); $a++) {
						if (isset($data[$a][1])) {
							if ($data[$a][1] != 2) {
								$err[] = "Critical Incident number {$data[$a][0]} has {$data[$a][1]} PDF files.";
							}
						}
					}
					if (empty($err)) {
						$formToDisplay = '<form action="LaunchNewestVolume.php" enctype="multipart/form-data"  multiple = "multiple" method = "POST">';
						$formToDisplay = $formToDisplay . '<input type="file" name="uploadedFile[]" />';
						$formToDisplay = $formToDisplay . '<input type="submit" class = "button5" value="Launch the Latest Volume">';
						$formToDisplay = $formToDisplay . '</form>';
						echo $formToDisplay;
					}
				}
				else {
					$err[] = 'No submitted Critical Incidents have been approved for publication.';
				}
			}
			
			// Generates any error messages.
			// I added an introductory message for the errors.
			if (!empty($err)) {
				echo "<br/>Here is a list of all of the errors: <br/>";
				for($i = 0; $i < count($err); $i++) {
					echo "{$err[$i]} <br/>";
				}
			}
		}
	}
	else {
		header('Location: Index.php');
	}
?>

<?php
	include('includes/Footer.php');
?>