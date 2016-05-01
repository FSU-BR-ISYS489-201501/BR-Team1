<?php
 /*********************************************************************************************
  * Original Author: Donald Dean
  * Date of origination: 03/15/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: The purpose of this page is to collect data for file management.
  * Credit: http://php.net/manual/en/index.php
  * 
  * Revision 1.1: 04/09/2016 Author: Mark Bowman
  * Description of Change: I redesigned the file so that it would accept a critical incident
  * ID and then display all of the files associated with that ID number. 
  ********************************************************************************************/
  	$page_title = 'File Management';
	include ("includes/LoginHelper.php");
	include ("includes/ValidationHelper.php");
	include ("includes/Header.php");
	//include("includes/FileHelper.php");
	//include("includes/FileManagementHelper.php");
	include('includes/TableRowHelper.php');
	require ('../DbConnector.php');
	session_start();
	
	if (isset($_GET['CriticalIncidentId'])) {
		$criticalIncidentId = $_GET['CriticalIncidentId'];
	}
	
	if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor') {
		// Borrowed idea from Mark's ManageAnnouncements
		$query = "SELECT FileDes, FileType FROM files WHERE CriticalIncidentId = $criticalIncidentId";
		$IdQuery = "SELECT FileId FROM files WHERE CriticalIncidentId = $criticalIncidentId;";
		$idSelectQuery = @mysqli_query($dbc, $IdQuery);
		$selectQuery = @mysqli_query($dbc, $query);
		$headerCounter = mysqli_num_fields($selectQuery);
		$downloadButton = tableRowLinkGeneratorFileManagement($idSelectQuery);
		$tableBody = tableRowGeneratorWithButtons($selectQuery, $downloadButton, 1, $headerCounter);
		
		// Mark Bowman: I added code to check if the body of the table contains any data before displaying the rest of the table.
		// The idea for this code was inspired by Shane.
		if (!empty($tableBody)) {
			echo "
				<br/>
				<div id = 'fileViewer'>
					<table>
						<tr>
							<th>FileDes</th>
							<th>FileType</th>
						</tr>
						$tableBody
					</table>
				</div>
			";
		}
	}
	else {
		header('Location: Index.php');
	}
?>
	<br/>
	<a href= "UploadFile.php?CriticalIncidentId=<?php echo $criticalIncidentId; ?>" class = 'button4'>Upload a file</a>
	
<?php
	include('includes/Footer.php');
?>