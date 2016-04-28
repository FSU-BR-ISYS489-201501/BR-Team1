<?php
/*********************************************************************************************
  * Original Author: Faisal Alfadhli
  * Date of origination: 03/18/2016
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: this page is used to let Editor be able to assign reviewers to specific Critical Incident
  * Credits: www.W3schools.com
  * www.php.net 
  * HTMLBook.pdf from ISYS 288 class
  * used Larry Uldman's PHP book
  * http://stackoverflow.com
  * www.php.net
  * tutor: William Quigley, Email : mnewrath@gmail.com
  * Revision 1.1: 03/22/2016 authors: Faisal Alfadhli 
  * Edited database queries and some changes 
  * Revision 1.2: 04/07/2016 authors: Faisal Alfadhli.
  * Description of change: Added a parameter 
  * Revision 1.2: 04/012/2016 authors: Faisal Alfadhli.
  * Description of change: changed checkbox to radio button, edited some queries.
  ********************************************************************************************/

	include('includes/Header.php');
	require ('../DbConnector.php');
	include('includes/TableRowHelper.php');
	
	// this block is to pull the users info from the db 
	$reviewerQuery = "SELECT users.UserId, users.FName, users.LName FROM users
						INNER JOIN usertypes ON users.UserId=usertypes.UserId
						INNER JOIN reviewers ON users.UserId=reviewers.UserId
						WHERE usertypes.Type='Reviewer';";
	$reviewerIdQuery = "SELECT reviewers.ReviewerId FROM reviewers
						INNER JOIN users ON reviewers.UserId=users.UserId
						INNER JOIN usertypes ON users.UserId=usertypes.UserId
						WHERE usertypes.Type='Reviewer';";
	
	// It was written by Shane Workman.
	$selectQuery = @mysqli_query($dbc, $reviewerQuery);
	$idSelectQuery = @mysqli_query($dbc, $reviewerIdQuery);
	$headerCounter = mysqli_num_fields($selectQuery);
	//TableRowCheckboxGenerator function to accept imput type and set it as radio so only one reviewer can be selected at a time
	$checkBox = tableRowCheckboxGenerator("radio", $selectQuery, $idSelectQuery);
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
				<br/><input type='submit' name='submit' Value='Submit'/><br/><br/>
			</form>
		</div>
	</div>
<?php

	if(isset($_POST['submit'])){
		if(!empty($_POST['checkList'])) {
			// $userIdArr is to hold an array.
			$userIdArr = array();
			// Variable is to hold the number of users already assigned to the incident.
			$assErr = 0;
			
			//foreach loop is to store and display values of individual checked checkbox
			foreach($_POST['checkList'] as $selected) {
				// Assign the selected checkbox value to $reviewerID.
				$reviewerID = $selected;
				// idea was from http://stackoverflow.com/questions/10119665/checking-if-data-exists-in-database
				// It counts the number of rows returned from our query to help us determine
				// the user is already assigned to the incident.				
				$query = "SELECT COUNT(ReviewerId) AS numberOfRows FROM criticalincidents WHERE CriticalIncidentId=$incidentId AND ReviewerId=$reviewerID;";
				// $result is to assign the results of the query to a variable.
				$result = mysqli_query($dbc, $query);
				// $row gets the array and assign it to a variable
				$row = mysqli_fetch_array($result);
				// IF statement is to check to see if the number of rows returned is greater than 0.
				// If it is greater than 0 add an error count to the error count variable.
				// Then I set the Update Success variable to false.
				if ( $row['numberOfRows'] > 0) {
					echo "User is already assigned to this case.<br/>";
					$assErr = $assErr + 1;
					$updateSuccess = "false";
				} else {					
					// I append selected user id to the array.
					// If the number of rows returned is not greater than 0 than run the Insert
					// Query to assign the user as a reviewer.	
					array_push($userIdArr, $reviewerID);
					$query = "UPDATE criticalincidents SET ReviewerId=$reviewerID WHERE CriticalIncidentId = $incidentId;";
					//I run the query.
					//If the query did not run then tell the user about it.
					// Set the update success flag to true.
					$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
					If (!$run) {
						echo 'There was an error when assigning the reviewers. Please try again!';
					} else {
						$updateSuccess = "true";
					}
				}
				// If the update success flag is set to true, then tell the user it worked.
				if ($updateSuccess == "true"){
					echo "Your Incident has been assigned!<br/>";
				}
			}
		// If no checkboxes are selected then tell the user to make sure they select one. 
		} elseif (empty($_POST['checkList'])) {
			echo "<b>Please Select At least One Option.</b>";
		}		
	}	

	include('includes/Footer.php');
?>
