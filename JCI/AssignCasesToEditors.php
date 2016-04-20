<?php
/*********************************************************************************************
  * Original Author: Faisal Alfadhli
  * Date of origination: 02/22/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: this page is used to let Editor be able to split reviews among editors (assign specific cases to specific Editors)
  *Credits: www.W3schools.com
  * www.php.net 
  * HTMLBook.pdf from ISYS 288 class
  * used Larry Uldman's PHP book
  * tutor: William Quigley, Email : mnewrath@gmail.com
  * Revision1.0: 03/11/2016 Author: Faisal Alfadhli
  * Description of change: edited tables names.
  * Revision1.1: 04/07/2016 Author: Faisal Alfadhli.
  * Description of change: add a parameter for radio button
  * Revision1.2: 04/11/2016 Author: Faisal Alfadhli.
  * Description of change.Changed the query to show editor name instead of ID.
  ********************************************************************************************/
	include('includes/Header.php');
	require ('../DbConnector.php');
	include('includes/TableRowHelper.php');
	
	// this block is to pull the users info from the db 
	$editorQuery = "SELECT users.UserId, users.FName, users.LName FROM users 
					INNER JOIN usertypes ON users.UserId=usertypes.UserId 
					WHERE usertypes.Type='Editor' OR usertypes.Type='editor';";
	$editorIdQuery = "SELECT users.UserId FROM users
						INNER JOIN usertypes ON usertypes.UserId=users.UserId
						WHERE usertypes.Type='Editor' OR usertypes.Type='editor';";
	
	// it was Written by Shane Workman.
	$selectQuery = @mysqli_query($dbc, $editorQuery);
	$idSelectQuery = @mysqli_query($dbc, $editorIdQuery);
	
	$headerCounter = mysqli_num_fields($selectQuery);
	//tableRowCheckboxGenerator:it is FUNCTION TO ACCEPT INPUT TYPE AND SET IT AS RADIO SO ONLY ONE EDITOR CAN BE SELECTED AT A TIME
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
	<h1>Assign Editors</h1>
	<div id = 'divAssignEditors'>
		<div class="main">
			<form name="frmAssignEditors" action="AssignCasesToEditors.php" method="post">
				<input type="hidden" name="id" value="<?php echo $incidentId; ?>">
				<label class="heading">Select an editor to review case:</label><br/><br/>
				<table>
					<tr>
						<th>User Id</th>
						<th>First Name</th>
						<th>Last Name</th>
					</tr>
					<?php echo $tableBody; ?>
				</table>
				<br/><input type='submit' name='submit' Value='Submit'/><br/><br/>
<?php

	if(isset($_POST['submit'])){
		if(!empty($_POST['checkList'])) {
			// $userIdArr: it is a variable to hold an array.
			$userIdArr = array();
			// Variable to hold the number of users already assigned to the incident.
			$assErr = 0;
			$eName = "";
			
			//foreeach Loop is to store and display values of individual checked checkbox
			foreach($_POST['checkList'] as $selected) {
				// Assign the selected checkbox value to a variable.
				$editorID = $selected;
				$editorQuery = "SELECT users.FName, users.LName FROM users WHERE users.UserId=$editorID;";
				$selectQuery = @mysqli_query($dbc, $editorQuery);
				foreach (mysqli_fetch_array($selectQuery, MYSQLI_NUM) As $editorName) {
					// This is to concatinate first name and last name and assign them to the variables.
					// $eName & $editorName: editor First Name and Last Name
					$eName = $eName . " " . $editorName;
				}
				// idea was from http://stackoverflow.com/questions/10119665/checking-if-data-exists-in-database
				//$query is to count the number of rows returned from our query to help us determine
				// the user is already assigned to the incident.				
				$query = "SELECT COUNT(Editor) AS numberOfRows FROM criticalincidents
							WHERE CriticalIncidentId=$incidentId AND Editor=$editorID;";
				// I assign the results of the query to $result.
				$result = mysqli_query($dbc, $query);
				// I get the array and assign it to $row.
				$row = mysqli_fetch_array($result);
				//I check to see if the number of rows returned is greater than 0.
				if ( $row['numberOfRows'] > 0) {
					echo "User is already assigned to this case.<br/>";
					// If it is greater than 0 add an error count to the error count variable.
					$assErr = $assErr + 1;
					// I set the Update Success variable to false.
					$updateSuccess = "false";
				} else {					
				
					// I append selected user id to the array.		
					array_push($userIdArr, $editorID);
					// If the number of rows returned is not greater than 0 than run the Insert
					// Query to assign the user as a reviewer.
					$query = "UPDATE criticalincidents SET Editor='$eName' WHERE CriticalIncidentId = '$incidentId';";
					//I run the query.
					$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
					If (!$run) {
						//If the query did not run then tell the user about it.
						echo 'There was an error when assigning the editors. Please try again!';
					} else {
						// I set the update success flag to true.
						$updateSuccess = "true";
					}
				}
				// If the update success flag is set to true,then tell the user it worked.
				if ($updateSuccess == "true"){
					echo "Your Incident has been assigned!<br/>";
				}
			}
		// If checkboxes are not selected then tell the user to make sure they select one. 
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
