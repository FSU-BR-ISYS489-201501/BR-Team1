<?php
/*********************************************************************************************
 * Original Author: Mark Bowman
 * Date of origination: 04/19/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: The purpose of this file is to allow an editor to add a picture to the website.
 * 
 ********************************************************************************************/

session_start();
	if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor') {
		
		$page_title = 'Picture Management';
		include ("includes/Header.php");
		include("includes/FileHelper.php");
		require ('../DbConnector.php');
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$saveLocation = '';
			$CriticalIncidentIds = array();
			$journalIds = array();
			$types = array();
			array_push($types, $_POST['type']);
			
			//Mark Bowman: This block will check to see where the user intended the image to 
			//be dispayed, and then it will save that type to the database.
			if ($_POST['type'] == 'Slide') {
				$saveLocation = "styles/images/slideshow/";
			}
			else if ($_POST['type'] == 'About') {
				$saveLocation = "styles/images/aboutus/";
			}
			else {
				echo 'Please select a location for the image to display. <br>';
			}
			
			//Mark Bowman: This block checks if the input file is a jpg, png, or tif image file type. If the input
			//file is of an approved format, it will be uploaded to the database.
			if ($_FILES["uploadedFile"]["type"] == "image/jpeg" || $_FILES["uploadedFile"]["type"] == "image/png" || 
				$_FILES["uploadedFile"]["type"] == "image/tif" || $_FILES["uploadedFile"]["type"] == "image/x-tif") {
					
				if (preg_match("/(^[a-zA-Z0-9]).([a-zA-Z])/", $_FILES["uploadedFile"]['name'])) {
					if ($_POST['type'] != 'null') {
						switch (uploadFile($dbc, "uploadedFile", $saveLocation, $criticalIncidentIds, $types, $journalIds)) {
							case 0:
								echo 'Upload failed. Contact the system administrator.';
								break;
							case 1:
								echo 'Upload was successful.';
								break;
							case 2:
								echo 'Upload failed. There was an error with the file server.';
								break;
							case 3:
								echo 'Upload failed. There was an error with the database.';
								break;
							case 4:
								echo 'Upload failed. No files were attached.';
								break;
						}
					}
				}
				else {
					echo 'The image name should include only numbers and letters. <br>';
				}
			}
			else {
				echo 'The image must be in one of the following formats: .jpg, .png, or .tif. <br>';
			}
		}
	}
	else {
		header('Location: Index.php');
		exit;
	}

?>

<form enctype="multipart/form-data"  multiple = "multiple" method = "POST">
	<select name = 'type'>
		<option value = 'null'>Inactive</option>
		<option value = 'Slide'>Slideshow Image</option>
		<option value = 'About'>About Us Image</option>
	</select>
	<input type="file" name="uploadedFile[]" />
	<input type="submit" class = "button" value="Submit Picture">
</form>

<?php
	include('includes/Footer.php');
?>