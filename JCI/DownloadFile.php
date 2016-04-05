<?php
 /*********************************************************************************************
  * Original Author: Donald Dean
  * Date of origination: 03/17/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: The purpose of this page is to collect data for file management.
  * Credit: http://php.net/manual/en/index.php
  ********************************************************************************************/
// Gets the id from the link that is clicked and opens the file using the downloadFile function
include ("includes/FileHelper.php");
require ('../DbConnector.php');
// Borrowed this code from Faisal's Edit Announcement

If (isset($_GET['id']) ) {
			$fileId = $_GET['id'];
		} Else {
			$fileId = $_POST['id'];
		}
downloadFile($dbc, $fileId);
?>