<?php
	$page_title = 'Choose Cases for Publication';
	include('includes/Header.php');
	include('includes/TableRowHelper.php');
	require('../DbConnector.php');
	
	$tableBody = '';
	
	session_start();
	if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor') {
		
		// The idea for this code was inspired by Michael J. Calkins.
		// This block will check if 'deleteId' is set in the url. It will set the announcement with that value to inactive.
		if (isset($_GET['rejectedPublicationId'])) {
			$rejectQuery = "UPDATE criticalincidents SET ApprovedPublish = 0 WHERE CriticalIncidentId = {$_GET['rejectedPublicationId']};";
			$rejectCriticalIncidentQuery = @mysqli_query($dbc, $rejectQuery);
			if($rejectCriticalIncidentQuery){
				header('Location: http://localhost/jci/ChooseForPublication.php');
			}
		}
		
		
		// The idea for this code was inspired by Michael J. Calkins.
		// This block will check if 'activateId' is set in the url. It will set the announcement with that value to active.
		if (isset($_GET['approvedPublicationId'])) {
			$approveQuery = "UPDATE criticalincidents SET ApprovedPublish = 1 WHERE CriticalIncidentId = {$_GET['approvedPublicationId']};";
			$approveCriticalIncidentQuery = @mysqli_query($dbc, $approveQuery);
			if($approveCriticalIncidentQuery){
				header('Location: http://localhost/jci/ChooseForPublication.php');
			}
		}
		
		$nextVolumeQuery = 	"SELECT VolumeNumber
						 	FROM nextvolume;";
		
		// Written by Shane Workman.
		$nextVolumeSelectQuery = @mysqli_query($dbc, $nextVolumeQuery);
		
		if ($row = mysqli_fetch_array($nextVolumeSelectQuery, MYSQLI_ASSOC)) {
			
			$latest = $row['VolumeNumber'];
			
			$criticalIncidentQuery = 	"SELECT CriticalIncidentId, Title, ApprovedPublish
									 			FROM criticalincidents 
									 			WHERE JournalId = {$latest} ORDER BY CriticalIncidentId;";
												
			$criticalIncidentIdQuery = 	"SELECT CriticalIncidentId
							 			FROM criticalincidents 
							 			WHERE JournalId = {$latest} ORDER BY CriticalIncidentId;";
										
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
		
	echo $tableBody;
?>
	




<?php
	include('includes/Footer.php');
?>