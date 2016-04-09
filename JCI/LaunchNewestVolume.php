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
 * Revision1.1: 04/09/2016 Author: Mark Bowman
 * I altered the SQL query to allow for searching of the latest volume number. I also changed
 * the logic to check file types instead of just any record in the files table. Finally, I 
 * changed the output of the error messages slightly. It now includes an introductory sentence.
 ********************************************************************************************/
 
 	$page_title = 'Launch Latest Volume of JCI';
 	include('includes/Header.php');
	include('includes/TableRowHelper.php');
	include('../DbConnector.php');
	
 	// Makes the latest volume go live
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$latest = 0;
		$currentDate = date("Y");
		$nextVolumeQuery = 	"SELECT VolumeNumber
						 	FROM nextvolume;";
		
		// Written by Shane Workman.
		$nextVolumeSelectQuery = @mysqli_query($dbc, $nextVolumeQuery);
		
		if ($row = mysqli_fetch_array($nextVolumeSelectQuery, MYSQLI_ASSOC)) {
			$latest = $row['VolumeNumber'];
		}
		//Update the current JCI volume.
		$latest++;
		$updateNextVolumeQuery = 	"UPDATE nextvolume SET VolumeNumber = {$latest} WHERE NextVolumeId = 1;";
	
		// Written by Shane Workman.
		$updateNextVolumeSelectQuery = @mysqli_query($dbc, $updateNextVolumeQuery);
		
		$createNewVolumeQuery = "INSERT INTO journalofcriticalincidents(JournalVolume, PublicationYear)
								VALUES ($latest, $currentDate)";
		
		// Written by Shane Workman.						
		$createNewVolumeInsertQuery = @mysqli_query($dbc, $createNewVolumeQuery);
	}
	
	session_start();
	if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor') {
		
		$nextVolumeQuery = 	"SELECT VolumeNumber
						 	FROM nextvolume;";
		
		// Written by Shane Workman.
		$nextVolumeSelectQuery = @mysqli_query($dbc, $nextVolumeQuery);
		
		
		
		if ($row = mysqli_fetch_array($nextVolumeSelectQuery, MYSQLI_ASSOC)) {
			
			$latest = $row['VolumeNumber'];
			$tableBody = '';
			// Mark Bowman: I altered the SQL query to check the volume number instead of the journal ID.
			$criticalIncidentQuery = 	"SELECT criticalincidents.CriticalIncidentId, criticalincidents.Title, journalofcriticalincidents.JournalVolume
							 			FROM criticalincidents 
							 			INNER JOIN journalofcriticalincidents
									 	ON journalofcriticalincidents.JournalId = criticalincidents.JournalId
							 			WHERE ApprovedPublish = 1 AND journalofcriticalincidents.JournalVolume = {$latest} ORDER BY CriticalIncidentId;";
										
			$criticalIncidentIdQuery = 	"SELECT CriticalIncidentId
							 			FROM criticalincidents 
							 			INNER JOIN journalofcriticalincidents
									 	ON journalofcriticalincidents.JournalId = criticalincidents.JournalId
							 			WHERE ApprovedPublish = 1 AND journalofcriticalincidents.JournalVolume = {$latest} ORDER BY CriticalIncidentId;";
			
			// Written by Shane Workman.
			$criticalIncidentSelectQuery = @mysqli_query($dbc, $criticalIncidentQuery);
			$criticalIncidentIdSelectQuery = @mysqli_query($dbc, $criticalIncidentIdQuery);
		
			$pageNames = array('FileManagement.php');
			$variableNames = array('id');
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
							 			INNER JOIN journalofcriticalincidents
									 	ON journalofcriticalincidents.JournalId = criticalincidents.JournalId
							 			WHERE ApprovedPublish = 1 AND journalofcriticalincidents.JournalVolume = {$latest} ORDER BY CriticalIncidentId;";
			
			
			// Written by Shane Workman.
			if ($selectQuery = @mysqli_query($dbc, $approvedSubmissionQuery)) {
				
				if ($row = mysqli_fetch_row($selectQuery)) {
					array_push($criticalIncidentIds, $row[0]);
					
					// Creating the query to verify if Critical Incidents have files
					// associated with them.
					$fileLocationQuery = 	"SELECT CriticalIncidentId, FileType
											FROM files
											WHERE CriticalIncidentId = {$row[0]}";
					while ($row = mysqli_fetch_row($selectQuery)) {
						array_push($criticalIncidentIds, $row[0]);
						$fileLocationQuery = $fileLocationQuery . " OR CriticalIncidentId = {$row[0]}";
					}
					$fileLocationQuery = $fileLocationQuery . " ORDER BY CriticalIncidentId";
				}
				else {
					$err[] = "There are no approved Critical Incidents for JCI volume {$latest}.";
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
						if (isset($row['FileType'])) {
							if (($criticalIncidentIds[$a] == "$row[0]" && $row['FileType'] == 'Summary') || ($criticalIncidentIds[$a] == "$row[0]" && $row['FileType'] == 'CI')) {
								$currentIdFileCounter++;
							}
						}
					}
					//This function resets the resultset to 0. Shef @ http://stackoverflow.com/questions/6439230/how-to-go-through-mysql-result-twice
					mysqli_data_seek($fileLocationSelectQuery, 0);
					$data[$a] = array($criticalIncidentIds[$a], $currentIdFileCounter);
				}
				
				// Generates the submit button.				
				if (count($data) != 0) {
					for($a = 0; $a < count($data); $a++) {
						if (isset($data[$a][1])) {
							if ($data[$a][1] != 2) {
								$err[] = "Critical Incident number {$data[$a][0]} has {$data[$a][1]} PDF files.";
							}
						}
					}
					if (empty($err)) {
						echo '<form action="LaunchNewestVolume.php" method = "POST"><input type="submit" value="Launch the Latest Volume"></form>';
					}
				}
				else {
					$err[] = 'No submitted Critical Incidents have been approved for publication.';
				}
			}
			
			// Generates any error messages.
			// Mark Bowman: I added an introductory message for the errors.
			if (!empty($err)) {
				echo "<br/>Here is a list of all of the errors: <br/>";
				for($i = 0; $i < count($err); $i++) {
					echo "{$err[$i]} <br/>";
				}
			}
		}
	}
	else {
		header('Location: http://localhost/jci/Index.php');
	}
?>

<?php
	include('includes/Footer.php');
?>