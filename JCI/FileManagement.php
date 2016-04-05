<?php
 /*********************************************************************************************
  * Original Author: Donald Dean
  * Date of origination: 03/15/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: The purpose of this page is to collect data for file management.
  * Credit: http://php.net/manual/en/index.php
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
	
	if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor') {
	// Borrowed idea from Mark's ManageAnnouncements
	$query = "SELECT FileID, CriticalIncidentId, FileDes FROM files WHERE CriticalIncidentId = 1";
	$IdQuery = "SELECT FileId FROM files;";
	$idSelectQuery = @mysqli_query($dbc, $IdQuery);
	$selectQuery = @mysqli_query($dbc, $query);
	$headerCounter = mysqli_num_fields($selectQuery);
	$downloadButton = tableRowLinkGeneratorFileManagement($idSelectQuery);
	$tableBody = tableRowGeneratorWithButtons($selectQuery, $downloadButton, 1, $headerCounter);
	}
	else {
		header('Location: http://localhost/jci/Index.php');
	}
	?>
	 <a href="UploadFile.php">Upload a file</a> 
<div id = 'fileViewer'>
		<table>
			<tr>
				<th>FileId</th>
				<th>CriticalIncidentId</th>
				<th>FileDes</th>
			</tr>
			<?php echo $tableBody;
			
			?>
		</table>
	</div>
	
	
<?php
	include('includes/Footer.php');
?>