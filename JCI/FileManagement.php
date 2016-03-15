<?php
 /*********************************************************************************************
  * Original Author: Donald dean
  * Date of origination: 03/15/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: The purpose of this page is to collect data for new announcements.
  * Credit: http://php.net/manual/en/index.php
  ********************************************************************************************/
	//include ("includes/LoginHelper.php");
	include ("includes/ValidationHelper.php");
	include ("includes/Header.php");
	include("includes/FileHelper.php");
	include('includes/TableRowHelper.php');
	require ('../DbConnector.php');
	
	$query = "SELECT FileID, SubmissionId, FileDes FROM files";
	
	// Stole from Shane Workman's Register code
	$selectQuery = @mysqli_query($dbc, $query);
	
	$headerCounter = mysqli_num_fields($selectQuery);
	$tableBody = tableRowGenerator($selectQuery, $headerCounter);
	?>
	
<div id = 'fileViewer'>
		<table>
			<tr>
				<th>FileId</th>
				<th>SubmissionId</th>
				<th>FileDes</th>
			</tr>
			<?php echo $tableBody; ?>
		</table>
	</div>
	
	
<?php
	include('includes/Footer.php');
?>