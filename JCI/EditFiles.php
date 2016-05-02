<?php
 /*********************************************************************************************
  * Original Author: Mark Bowman
  * Date of origination: 04/30/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: The purpose of this page is to allow an editor to activate or deactivate files
  * that were submitted. Deactivated files will not display during a search but activated files
  * will.
  * 
  * Credit: I used code written by Michael J. Calkins as an inspiration for executing a function
  * through a php link. This was obtained from http://stackoverflow.com/questions/19323010/execute-php-function-with-onclick.
  * 
  ********************************************************************************************/
session_start();

$selectBody = '';
$tableBody = '';
$publicationYear = 0;

if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor') {
	
	require('../DbConnector.php');
	
	// Citation: Michael J. Calkins.
	// This block will check if 'deleteId' is set in the url. It will set the file with that value to inactive.
	if (isset($_GET['deleteId'])) {
		$fileDeactivateQuery = "UPDATE files SET Active = 0 WHERE FileId = {$_GET['deleteId']};";
		$deactivateQuery = @mysqli_query($dbc, $fileDeactivateQuery) OR die("Errors are ".mysqli_error($dbc));
		if($deactivateQuery){
		}
	}
	
	// Citation: Michael J. Calkins.
	// This block will check if 'activateId' is set in the url. It will set the file with that value to active.
	if (isset($_GET['activateId'])) {
		$fileActivateQuery = "UPDATE files SET Active = 1 WHERE FileId = {$_GET['activateId']};";
		$activateQuery = @mysqli_query($dbc, $fileActivateQuery) OR die("Errors are ".mysqli_error($dbc));
		if($activateQuery){
		}
	}
	
	include('includes/Header.php');
	include('includes/TableRowHelper.php');
	
	// This block will retrieve the files from the database for the selected publication year, or
	// it will retrieve the files from the database for the current year.
	$fileQuery = '';
	$fileIdQuery = '';
	if (isset($_POST['publicationYear'])) {
		$publicationYear = $_POST['publicationYear'];
		$fileQuery = "SELECT files.FileDes, files.FileType, files.Active
					FROM files 
					INNER JOIN journalofcriticalincidents 
					ON files.JournalId = journalofcriticalincidents.JournalId 
					WHERE journalofcriticalincidents.PublicationYear = $publicationYear;";
		$fileIdQuery = "SELECT files.FileId 
					FROM files 
					LEFT JOIN journalofcriticalincidents 
					ON files.JournalId = journalofcriticalincidents.JournalId 
					WHERE journalofcriticalincidents.PublicationYear = $publicationYear;";
	}
	else {
		$currentDate = date("Y");
		$fileQuery = "SELECT files.FileDes, files.FileType, files.Active
					FROM files 
					INNER JOIN journalofcriticalincidents 
					ON files.JournalId = journalofcriticalincidents.JournalId 
					WHERE journalofcriticalincidents.PublicationYear = $currentDate;";
		$fileIdQuery = "SELECT files.FileId 
					FROM files 
					LEFT JOIN journalofcriticalincidents 
					ON files.JournalId = journalofcriticalincidents.JournalId 
					WHERE journalofcriticalincidents.PublicationYear = $currentDate;";
	}
	
	// If the query is successful, this block will use the tableRowGenerator to create a table filled
	// with files from the database. If it fails, an error message will display.
	if ($fileIdSelectQuery = mysqli_query($dbc, $fileIdQuery) OR die("Errors are ".mysqli_error($dbc))) {
		if ($fileSelectQuery = mysqli_query($dbc, $fileQuery) OR die("Errors are ".mysqli_error($dbc))) {
			$pageNames = array('EditFiles.php', 'EditFiles.php');
			$variableNames = array('deleteId', 'activateId');
			$titles = array('Deactivate', 'Activate');
			
			$editButton = tableRowLinkGenerator($fileIdSelectQuery, $pageNames, $variableNames, $titles);
			$headerCounter = mysqli_num_fields($fileSelectQuery);
			$tableBody = tableRowGeneratorWithButtons($fileSelectQuery, $editButton, 2, $headerCounter);
		}
		else {
			echo "There was an error with the database. Please contact the system administrator.";
		}
	}
	else {
		echo "There was an error with the database. Please contact the system administrator.";
	}
	
	// This block will create a dropdown box filled with values from the database. The publication years of
	// all of the records in the journalofcriticalincidents table will be displayed in the dropdown box. If 
	// the query is not successful, an error message will be displayed.
	$publicationYearQuery = "SELECT PublicationYear FROM journalofcriticalincidents ORDER BY PublicationYear DESC;";
	if ($publicationYearSelectQuery = mysqli_query($dbc, $publicationYearQuery) OR die("Errors are ".mysqli_error($dbc))) {
		$selectBody = "<select name = 'publicationYear'>";
		while ($row = mysqli_fetch_array($publicationYearSelectQuery, MYSQLI_NUM)) {
			$selectBody = $selectBody . "<option value = '$row[0]'>$row[0]</option>";
		}
		$selectBody = $selectBody . "</select>";
	}
	else {
		echo "There was an error with the database. Please contact the system administrator.";
	}
}
else {
	header('Location: Index.php');
	exit;
}

?>
<div>
	<?php // The idea for this code was inspired by Shane. ?>
	<div name = 'table'style="float:left">
		</br>
		<?php
			// The idea for this code was inspired by Shane.
			if (!empty($tableBody)) {
				echo "
					<table>
						<tr>
							<th>FileDes</th>
							<th>FileType</th>
							<th>Active (1 = Yes/0 = No)</th>
						</tr>
						$tableBody
					</table>
				";
			}
		?>
	</div>
	<?php // The idea for this code was inspired by Shane. ?>
	<div name = 'select'style="float:right">
		</br>
		<fieldset>
			<form method="post">
				Choose the year in which files will be/were published.
				<br>
				<?php // The idea for this code was inspired by the use of a hidden field in Submit Case, written by Faisal. ?>
				<input type="hidden" value="<?php if (isset($publicationYear)) echo $publicationYear; ?>" name="id" />
				<?php
					echo $selectBody;
				?>
				<input type = 'submit' value = 'Submit' class = 'button4'>
			</form>
		</fieldset>
	</div>
</div>

<?php
	include('includes/Footer.php');
?>
 