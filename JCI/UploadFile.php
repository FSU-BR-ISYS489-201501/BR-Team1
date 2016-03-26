<?php
 /*********************************************************************************************
  * Original Author: Donald Dean
  * Date of origination: 03/19/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: The purpose of this page is to collect data for file management.
  * Credit: http://php.net/manual/en/index.php
  ********************************************************************************************/

include ("includes/FileHelper.php");
include ("includes/Header.php");
require ('../DbConnector.php');

// Call the uploadFile function
if ($_SERVER["REQUEST_METHOD"] == "POST") {
uploadFile($dbc, "uploadedFile", "../uploads/");
}
?>
<form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" multiple = "multiple">
<input type="file" name="uploadedFile[]" />
<br><br>
Critical Incident ID:<input type="text" name="criticalincidentid" />
		<br><br>
		<input type="submit" value="Submit" name="uploadedFile" />
	</form>
	
<?php
	include ("includes/Footer.php");
?>