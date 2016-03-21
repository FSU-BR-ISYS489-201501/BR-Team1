<?php
/*********************************************************************************************
  * Original Author: Faisal Alfadhli
  * Date of origination: 03/18/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: this page is used to let Editor be able to assign reviewers to specific Critical Incident
  *Credits: to William 
 *  www.W3schools.com
  * www.php.net 
  * HTMLBook.pdf from ISYS 288 class
  * used Larry Uldman's PHP book
  * http://stackoverflow.com
  * www.php.net
  ********************************************************************************************/

	include('includes/Header.php');
	require ('../DbConnector.php');
	include('includes/TableRowHelper.php');
	
	// this block is to pull the users info from the db 
	$reviewerQuery = "SELECT UserId, FName, LName FROM users;";
	$reviewerIdQuery = "SELECT UserId FROM users;";
	
	// Written by Shane Workman.
	$selectQuery = @mysqli_query($dbc, $reviewerQuery);
	$idSelectQuery = @mysqli_query($dbc, $reviewerIdQuery);
	
	$headerCounter = mysqli_num_fields($selectQuery);
	$checkBox = tableRowCheckboxGenerator($selectQuery, $idSelectQuery);
	// it will add one check box in every row 
	// it was inspired by William
	$checkBoxCounter = count($checkBox)/count($checkBox);
	$tableBody = tableRowGeneratorWithButtons($selectQuery, $checkBox, $checkBoxCounter, $headerCounter);
	// If $_GET or $_POST are set then assign the value to a variable.
	if (isset($_GET['id']) ) {
		$incidentId = $_GET['id'];
	} elseif (isset($_POST['id']) ) {
		$incidentId = $_POST['id'];
	}
?>		
	<h1>Assign Reviewers</h1>
	<div id = 'divAssignReviewers'>
		<div class="main">
			<form name="frmAssignReviwers" action="AssignReviewers.php" method="post">
				<input type="hidden" name="id" value="<?php echo $incidentId; ?>">
				<label class="heading">Select users to review case:</label><br/><br/>
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
			// Variable to hold the number of users already assigned to the incident.
			$assErr = 0;
			
			//Loop to store and display values of individual checked checkbox
			foreach($_POST['checkList'] as $selected) {
				// Assign the selected checkbox value to a variable.
				$uID = $selected;	
				// append selected user id to the array.		
				array_push($userIdArr, $uID);	
				
				// idea from http://stackoverflow.com/questions/10119665/checking-if-data-exists-in-database
				// Count the number of rows returned from our query to help us determine
				// the user is already assigned to the incident.				
				$query = "SELECT COUNT(UserId) AS numberOfRows FROM reviewers WHERE CriticalIncidentId = $incidentId AND UserId = $uID";
				// Assign the results of the query to a variable.
				$result = mysqli_query($dbc, $query);
				// get the array and assign it to a variable
				$row = mysqli_fetch_array($result);
				// Check to see if the number of rows returned is greater than 0.
				if ( $row['numberOfRows'] > 0) {
					$query = "SELECT Active FROM reviewers WHERE CriticalIncidentId = $incidentId AND UserId = $uID";
					$result = mysqli_query($dbc, $query);
					$row = mysqli_fetch_array($result);
				    if ($row['Active'] == 0){
						echo "User was assigned to this case at one time, but is currently not Active.<br/>";
					}
					// If it is greater than 0 add an error count to the error count variable.
					$assErr = $assErr + 1;
					// Set the Update Success variable to false.
					$updateSuccess = "false";
				} else {
					// If the number of rows returned is not greater than 0 than run the Insert
					// Query to assign the user as a reviewer.
					$query = "INSERT INTO reviewers (UserId, CriticalIncidentId, Active) VALUES ($uID,$incidentId, 1);";
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
			}
			// If the update success flag is set to true ...
			if ($updateSuccess == "true"){
				// Then tell the user it worked.
				echo "Your Incident has been assigned!<br/>";
			}
			// If the assign error value is greater than 0 ...
			if ($assErr > 0) {
				// Inform the user how many of the selected users were already assigned.
				echo $assErr . " user(s) already assigned to the incident!<br/>";
			}
		// If no checkboxes are selected then tell the user to make sure they select one. 
		} elseif (empty($_POST['checkList'])) {
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
