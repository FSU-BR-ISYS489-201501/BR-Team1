<?php
 /*********************************************************************************************
  * Original Author: Donald Dean
  * Date of origination: 03/19/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: The purpose of this page is to collect data for file management.
  * Credit: http://php.net/manual/en/index.php
  * 
  * Revision 1.1: 04/09/2016 Author: Mark Bowman
  * Description of Change: Redesigned the file to allow the upload of a Word document, a
  * CI PDF document, or a Summary PDF document. The uploaded file will be saved in the
  * database to the corresponding critical incident ID number.
  ********************************************************************************************/

 	session_start();
	if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor') {
		
		include ("includes/FileHelper.php");
		include ("includes/Header.php");
		require ('../DbConnector.php');
		include("includes/ValidationHelper.php");
		
		$criticalIncidentId = 0;
		if (isset($_GET['CriticalIncidentId'])) {
			$criticalIncidentId = $_GET['CriticalIncidentId'];
		}
		else {
			$criticalIncidentId = $_POST['id'];
		}
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$criticalIncidentIdQuery = "SELECT JournalId FROM criticalincidents WHERE CriticalIncidentId = $criticalIncidentId;";
			$idQuery = @mysqli_query($dbc, $criticalIncidentIdQuery);
			if ($row = mysqli_fetch_array($idQuery, MYSQLI_ASSOC)) {
				
				$journalIds = array();
				$types = array();
				$ids = array();
				array_push($journalIds, $row['JournalId']);
				array_push($types, $_POST['fileType']);
				array_push($ids, $criticalIncidentId);
				if ($_FILES["uploadedFile"]["type"] == "application/msword" || $_FILES["uploadedFile"]["type"] == "application/pdf" ||
					$_FILES["uploadedFile"]["type"] =="application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
					if (preg_match("/(^[a-zA-Z0-9]).([a-zA-Z])/", $_FILES["uploadedFile"]['name'])) {
						if (uploadFile($dbc, "uploadedFile", "../uploads/", $ids, $types, $journalIds)) {
							echo 'The file has been uploaded.';
						}
					}
					else {
						echo 'The file must be name with English letters or numbers.';
					}
				}
				else {
					echo 'The uploaded file must be a Microsoft Word document or a PDF document.';
				}
			}
		}
	}
	else {
		header('Location: http://br-t1-jci.sfcrjci.org/Index.php');
		exit;
	}
?>
	<br/>
	<fieldset>
		<form method="post" enctype="multipart/form-data"  multiple = "multiple">
			<input type="hidden" value="<?php if (isset($criticalIncidentId)) echo $criticalIncidentId; ?>" name="id" />
			<input type="file" name="uploadedFile" />
			<br/><br/>
			<select name = 'fileType'>
				<option value = 'Word'>Word Document</option>
				<option value = 'CI'>Critical Incident</option>
				<option value = 'Summary'>Summary</option>
			</select>
			<br/><br/>
			<input type="submit" value="Submit" name="uploadedFile" />
		</form>
	</fieldset>
<?php
	include ("includes/Footer.php");
?>