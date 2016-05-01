<?php
	/*********************************************************************************************
 * Original Author: Mark Bowman
 * Date of origination: 03/28/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: The purpose of this file is show all of the Critical Incidents that have been uploaded
 * for the next volume of the JCI to an editor. This file also allows the editor to choose which 
 * ones will be published.
 *
 * Revision1.1: 04/09/2016 Author: Mark Bowman
 * I altered the SQL query to allow for searching of the latest volume number. I also added 
 * conditionals to see if the table body has content before displaying the rest of the table.
 * 
 * Revision1.2: 04/21/2016 Author: Mark Bowman
 * I altered the location of the in development query in order to squash a bug that allowed a 
 * user to deactivate a published Critical Incident.	
 ********************************************************************************************/
 
	$page_title = 'Choose Cases for Publication';
	include('includes/Header.php');
	include('includes/TableRowHelper.php');
	require('../DbConnector.php');
	
	$tableStart = "<table>";
	$tableHeader = "<th>Critical Incident</th><th>Approved</th>";
	$tableBody = '';
	$tableEnd = "</table>";
	
	session_start();
	if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor') {
		
		$nextVolumeQuery = 	"SELECT JournalId FROM journalofcriticalincidents WHERE InDevelopement = 1;";
		
		// Written by Shane Workman.
		$nextVolumeSelectQuery = @mysqli_query($dbc, $nextVolumeQuery);
		
		if ($row = mysqli_fetch_array($nextVolumeSelectQuery, MYSQLI_ASSOC)) {
			
			$latest = $row['JournalId'];
		
			// The idea for this code was inspired by Michael J. Calkins.
			// This block will check if 'deleteId' is set in the url. It will set the announcement with that value to inactive.
			if (isset($_GET['rejectedPublicationId'])) {
				$rejectQuery = "UPDATE criticalincidents SET ApprovedPublish = 0 WHERE CriticalIncidentId = {$_GET['rejectedPublicationId']} AND JournalId = $latest;";
				$rejectCriticalIncidentQuery = @mysqli_query($dbc, $rejectQuery);
				if($rejectCriticalIncidentQuery){
					header('Location: http://localhost/jci/ChooseForPublication.php');
				}
			}
			
			
			// The idea for this code was inspired by Michael J. Calkins.
			// This block will check if 'activateId' is set in the url. It will set the announcement with that value to active.
			if (isset($_GET['approvedPublicationId'])) {
				$approveQuery = "UPDATE criticalincidents SET ApprovedPublish = 1 WHERE CriticalIncidentId = {$_GET['approvedPublicationId']} AND JournalId = $latest;";
				$approveCriticalIncidentQuery = @mysqli_query($dbc, $approveQuery);
				if($approveCriticalIncidentQuery){
					header('Location: http://localhost/jci/ChooseForPublication.php');
				}
			}
		
			// Mark Bowman: I altered the SQL query to check the volume number instead of the journal ID.
			$criticalIncidentQuery = 	"SELECT criticalincidents.Title, criticalincidents.ApprovedPublish
									 	FROM criticalincidents 
									 	WHERE JournalId = $latest ORDER BY CriticalIncidentId;";
												
			$criticalIncidentIdQuery = 	"SELECT CriticalIncidentId
							 			FROM criticalincidents 
									 	WHERE JournalId = $latest ORDER BY CriticalIncidentId;";
										
			$criticalIncidentSelectQuery = @mysqli_query($dbc, $criticalIncidentQuery);
			$criticalIncidentIdSelectQuery = @mysqli_query($dbc, $criticalIncidentIdQuery);
			
			$pageNames = array('ChooseForPublication.php', 'ChooseForPublication.php');
			$variableNames = array('approvedPublicationId', 'rejectedPublicationId');
			$titles = array('Approve', 'Reject');
			
			$headerCounter = mysqli_num_fields($criticalIncidentSelectQuery);
			$editButton = tableRowLinkGenerator($criticalIncidentIdSelectQuery, $pageNames, $variableNames, $titles);
			$tableBody = tableRowGeneratorWithButtons($criticalIncidentSelectQuery, $editButton, 2, $headerCounter);
		}
	}
	else {
		header('Location: Index.php');
		exit;
	}
?>
	
	<?php 
		// Mark Bowman: I added code to check if the body of the table contains any data before displaying the rest of the table.
		// The idea for this code was inspired by Shane.
		if (!empty($tableBody)) {
			echo '<fieldset>';
			echo $tableStart;
			echo $tableHeader;
			echo $tableBody; 
			echo $tableEnd;
			echo '</fieldset>';
		}
		else {
			echo 'There are no submitted Critical Incidents for the next volume of the JCI.';
		}
	?>

<?php
	include('includes/Footer.php');
?>