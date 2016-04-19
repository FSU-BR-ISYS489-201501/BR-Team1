<?php
/*********************************************************************************************
 * Original Author: Mark Bowman
 * Date of origination: 04/17/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: The purpose of this file is to allow an editor to change the pictures on the
 * website.
 * 
 ********************************************************************************************/

	session_start();
	if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor') {
		
		$page_title = 'Picture Management';
		include ("includes/Header.php");
		echo "<h1>Picture Management</h2>";
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$saveLocation = '';
			$CriticalIncidentIds = array();
			$journalIds = array();
			$types = array();
			array_push($types, $_POST['type']);
			if ($types[0] == 'Slide') {
				$saveLocation = "styles/images/slideshow/";
			}
			else if ($types[0] == 'About') {
				$saveLocation = "styles/images/aboutus/";
			}
			else {
				echo 'Please select a location for the image to display.';
			}
			if (uploadFile($dbc, "uploadedFile", $saveLocation, $criticalIncidentIds, $types, $journalIds)) {
				echo 'Your file has been uploaded.';
			}
		}
		
		$query = "SELECT FileDes, FileLocation FROM files WHERE FileType = 'Slide';";
		
		if ($selectQuery = @mysqli_query($dbc, $query)) {	
			echo "<fieldset>";
			echo "</fieldset>";
		}
	}
	else {
		header('Location: http://br-t1-jci.sfcrjci.org/Index.php');
		exit;
	}

?>

<form action="ImageManagement.php" enctype="multipart/form-data"  multiple = "multiple" method = "POST">
	<select name = 'type'>
		<option value = 'null'>Location on the Website</option>
		<option value = 'Slide'>Slideshow Image</option>
		<option value = 'About'>About Us Image</option>
	</select>
	<input type="file" name="uploadedFile" />
	<input type="submit" class = "button" value="Submit Picture">
</form>

<?php
	include('includes/Footer.php');
?>