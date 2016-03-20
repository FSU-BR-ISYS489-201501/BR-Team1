<?php
/*********************************************************************************************
  * Original Author: Faisal Alfadhli
  * Date of origination: 03/18/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: this page is used to let Editor be able to assign reviewers to specific Critical Incident
  *Credits: www.W3schools.com
  * www.php.net 
  * HTMLBook.pdf from ISYS 288 class
  * used Larry Uldman's PHP book
  * http://stackoverflow.com
  * www.php.net
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
	$reviewersQuery =  "SELECT users.UserId, users.FName, users.LName FROM users INNER JOIN reviewers ON users.UserId=reviewers.UserId WHERE reviewers.CriticalIncidentId=$incidentId AND reviewers.Active='1';";
	$reviewersIdQuery = "SELECT users.UserId FROM users INNER JOIN reviewers ON users.UserId=reviewers.UserId WHERE reviewers.CriticalIncidentId=$incidentId AND reviewers.Active='1';";
	// Written by Shane Workman.
	$selectQuery = @mysqli_query($dbc, $reviewersQuery);
	$idSelectQuery = @mysqli_query($dbc, $reviewersIdQuery);
	$headerCounter = mysqli_num_fields($selectQuery);
	$checkBox = tableRowCheckboxGenerator($selectQuery, $idSelectQuery);
	// it will add one check box in every row 
	$checkBoxCounter = count($checkBox)/count($checkBox);
	$tableBody = tableRowGeneratorWithButtons($selectQuery, $checkBox, $checkBoxCounter, $headerCounter);
	// If $_GET or $_POST are set then assign the value to a variable.
	if (isset($_GET['id']) ) {
		$incidentId = $_GET['id'];
	} elseif (isset($_POST['id']) ) {
		$incidentId = $_POST['id'];
	}
?>		
	<h1>Remove Reviewers</h1>
	<div id = 'divRemoveReviewers'>
		<div class="main">
			<form name="frmRemoveReviwers" action="RemoveReviewers.php" method="post">
				<input type="hidden" name="id" value="<?php echo $incidentId; ?>">
				<label class="heading">Select users to remove from case:</label><br/><br/>
				<table>
					<tr>
						<th>User Id</th>
						<th>First Name</th>
						<th>Last Name</th>
					</tr>
					<?php echo $tableBody; ?>
				</table>
				<!-----Including PHP Script----->
				<br/><input type='submit' name='submit' Value='Submit'/><br/><br/>
<?php

	if(isset($_POST['submit'])){
		if(!empty($_POST['checkList'])) {		
			// Variable to hold an array.
			$userIdArr = array();
			//Loop to store and display values of individual checked checkbox
			foreach($_POST['checkList'] as $selected) {
				// Assign the selected checkbox value to a variable.
				$uID = $selected;	
				// append selected user id to the array.		
				array_push($userIdArr, $uID);				
				$query = "UPDATE reviewers SET Active='0' WHERE UserId=$uID AND CriticalIncidentId=$incidentId;";
				//Run the query...
				$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
				If (!$run) {
					//If the query did not run then tell the user about it.
					echo 'There was an error when assigning the reviewers. Please try again!';
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
?>
			</form>
		</div>
	</div>
<?php
	include('includes/Footer.php');
?>
