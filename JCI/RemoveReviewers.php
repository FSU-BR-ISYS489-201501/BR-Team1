<?php
/*********************************************************************************************
  * Original Author: Faisal Alfadhli
  * Date of origination: 03/18/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: this page is used to let Editor be able to remove specific reviewer from specific Critical Incident
  * Credits:  tutor: William Quigley, Email : mnewrath@gmail.com
  *  www.W3schools.com
  * www.php.net 
  * HTMLBook.pdf from ISYS 288 class
  * used Larry Uldman's PHP book
  * http://stackoverflow.com
  * www.php.net
  * Revision 1.1: 03/22/2016 authors: Faisal Alfadhli.
  *  Edited database queries and some changes 
  * Revision 1.1: 04/12/2016 authors: Faisal Alfadhli.
  *  moved HTML element to a function in table row helpe, edited some queries.
  ********************************************************************************************/

	include('includes/Header.php');
	require ('../DbConnector.php');
	include('includes/TableRowHelper.php');
	
	if (isset($_GET['id']) ) {
		$incidentId = $_GET['id'];
	} elseif (isset($_POST['id']) ) {
		$incidentId = $_POST['id'];
	}
	// this block is to pull the users info from the db
	$reviewersQuery =  "SELECT users.UserId, users.FName, users.LName FROM users
						INNER JOIN reviewers ON users.UserId=reviewers.UserId 
						INNER JOIN criticalincidents ON criticalincidents.ReviewerId=reviewers.ReviewerId 
						WHERE criticalincidents.CriticalIncidentId=$incidentId;";
	$reviewersIdQuery = "SELECT criticalincidents.ReviewerId FROM criticalincidents 
						 INNER JOIN reviewers ON reviewers.ReviewerId=criticalincidents.ReviewerId 
						 INNER JOIN users ON reviewers.UserId=users.UserId 
						 WHERE criticalincidents.CriticalIncidentId=$incidentId;";
	// It was written by Shane Workman.
	$selectQuery = @mysqli_query($dbc, $reviewersQuery);
	$idSelectQuery = @mysqli_query($dbc, $reviewersIdQuery);
	
	// This block was copied from remove editors page.
	if ($headerCount = @mysqli_num_fields($selectQuery)){
		$headerCount = @mysqli_num_fields($selectQuery);
    }
	if ($rowCount = @mysqli_num_rows($selectQuery)){
		$rowCount = @mysqli_num_rows($selectQuery);
    }
	// if there is a data do somthing 
	if ($rowCount > 0){
		$checkBox = tableRowCheckboxGenerator("radio", $selectQuery, $idSelectQuery);
		$checkBoxCounter = count($checkBox)/count($checkBox);
		$tableBody = tableRowGeneratorWithButtons($selectQuery, $checkBox, $checkBoxCounter, $headerCount);
		spitHTML($incidentId, $tableBody);
	} else {
		// if ther is no data show a message.
		$tableBody = "<tr><td>No users are currently assigned as reviewers!</td></tr>";
		spitHTML($incidentId, $tableBody);
	}
	if(isset($_POST['submit'])){
		if(!empty($_POST['checkList'])) {	
			// Variable to hold an array.
			$reviwIdArr = array();
			//Loop to store and display values of individual checked checkbox
			foreach($_POST['checkList'] as $selected) {
				// Assign the selected checkbox value to a variable.
				$reviewerId = $selected;	
				// I append selected user id to the array.		
				array_push($reviwIdArr, $reviewerId);
				$query = "UPDATE criticalincidents SET ReviewerId = NULL WHERE CriticalIncidentId = '$incidentId'";
				$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
			
				If (!$run) {
					echo 'There was an error when removing the reviewer(s). Please try again!';
				} else {
					// Set the update success flag to true.
					$updateSuccess = "true";
				}
			}
			if ($updateSuccess = "true"){
				echo "User successfully removed from active reviewers!";
			}
		}
		// If no checkboxes are selected then tell the user to make sure they select one. 
		 elseif (empty($_POST['checkList'])) {
			echo "<b>Please Select At least One Option.</b>";
		}
	}

	include('includes/Footer.php');
?>
	