<?php
/*********************************************************************************************
  * Original Author: Faisal Alfadhli
  * Date of origination: 03/31/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: this page is used to let Editor be able to remove specific CI from specific Editors
  * Credits: www.W3schools.com
  * www.php.net 
  * tutor: William Quigley, Email : mnewrath@gmail.com
  * HTMLBook.pdf from ISYS 288 class
  * used Larry Uldman's PHP book
  * Copied this from RemoveReviewers.php , and tweaked some queries.
  * Revision1.0: 04/11/2016 Author: Faisal Alfadhli.
  * moved HTML elements to a function in table row helper to git rid of errors in this page.
 
  ********************************************************************************************/
	include ('includes/Header.php');
	require ('../DbConnector.php');
	include('includes/TableRowHelper.php');
	
	// If $_GET or $_POST are set then assign the value to a variable.
	if (isset($_GET['id']) ) {
		$incidentId = $_GET['id'];
	} elseif (isset($_POST['id']) ) {
		$incidentId = $_POST['id'];
	}
	$editorsQuery =  "SELECT Editor FROM criticalincidents
				      WHERE criticalincidents.CriticalIncidentId=$incidentId;";
	$editorsIdQuery = "SELECT criticalincidents.Editor FROM criticalincidents
					   WHERE criticalincidents.CriticalIncidentId=$incidentId;";
	
	
	$selectQuery = @mysqli_query($dbc, $editorsQuery);
	$idSelectQuery = @mysqli_query($dbc, $editorsIdQuery);
	// this block was inspired by William.
	// tells us how many headers in are in a query result
	if ($headerCount = @mysqli_num_fields($selectQuery)){
		$headerCount = @mysqli_num_fields($selectQuery);
    }
	// tells us how many rows of data are in a query result
	if ($rowCount = @mysqli_num_rows($selectQuery)){
		$rowCount = @mysqli_num_rows($selectQuery);
    }
	// if there is data do something
	if ($rowCount > 0){
		$checkBox = tableRowCheckboxGenerator("radio", $selectQuery, $idSelectQuery);
		// it will add one check box in every row
		$checkBoxCounter = count($checkBox)/count($checkBox);
		$tableBody = tableRowGeneratorWithButtons($selectQuery, $checkBox, $checkBoxCounter, $headerCount);
		// function to add html elements to our page.
		spitMoreHTML($incidentId, $tableBody);
	} else {
		// if there is no data display a message to the user.
		$tableBody = "<tr><td>No users are currently assigned as reviewers!</td></tr>";
		spitMoreHTML($incidentId, $tableBody);
	}
	if(isset($_POST['submit'])){
		if(!empty($_POST['checkList'])) {	
			// Variable to hold an array.
			$editorIdArr = array();
			//Loop to store and display values of individual checked checkbox
			foreach($_POST['checkList'] as $selected) {
				// Assign the selected checkbox value to a variable.
				$editorId = $selected;	
				// append selected user id to the array.		
				array_push($editorIdArr, $editorId);
				$query = "UPDATE criticalincidents SET Editor = NULL WHERE CriticalIncidentId = '$incidentId'";
				// It run the query
				$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
				If (!$run) {
					//If the query did not run then tell the user about it.
					echo 'There was an error when removing the reviewer(s). Please try again!';
				} else {
					// Set the update success flag to true.
					$updateSuccess = "true";
				}
			}
			if ($updateSuccess = "true"){
				echo "User successfully removed from active reviewers!";
			}
		} elseif (empty($_POST['checkList'])) {
			// If no checkboxes are selected then tell the user to make sure they select one. 
			echo "<b>Please Select At least One Option.</b>";
		}
	}

	include('includes/footer.php');
?>