<?php
/*********************************************************************************************
 * Original Author:Faisal Alfadhli
 * Date of origination: 04/16/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: The purpose of this file is to display all categories in drop down list to let the Editor select a category for a journal that is in development.
 *
 * Credit: I used code written by Shane to make database queries.
 * tutor: William Quigley, Email : mnewrath@gmail.com
 * www.php.net
 * www.stackoverflow.com
 * www.W3schools.com
 ********************************************************************************************/
 
 	include('includes/Header.php');
	include('includes/TableRowHelper.php');
	require('../DbConnector.php');
	// I get this Idea from my tutor William.
	// If $_GET or $_POST are set, then assign the value to a variable.
	if (isset($_GET['id']) ) {
		$incidentId = $_GET['id'];
	} elseif (isset($_POST['id']) ) {
		$incidentId = $_POST['id'];
	}
	// these are select quereis to get info from db.
	$myCatQuery = "SELECT CategoryName FROM categorys ORDER BY CategoryId;";	
	$myJournalId = "SELECT JournalId FROM criticalincidents WHERE CriticalIncidentId='$incidentId';";
	$selectQuery = @mysqli_query($dbc, $myCatQuery);	
	$jourIdSelectQuery = @mysqli_query($dbc, $myJournalId);
	// this is to call DropDownList function from TableRowHelper.
	// "CategoryName": this parameter is to display category name in dropdown list.
	$tablebody = DropDownList($selectQuery, "CategoryName");
	
	if (isset($_POST['submit'])){
		// if there is a value run the query and update info to db.
		if (!empty($_POST['slctCategory'])) {
			$catNameToInsert = $_POST['slctCategory'];
			$query = "UPDATE criticalincidents SET Category='$catNameToInsert' WHERE CriticalIncidentId='$incidentId';";
			$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
			//if query unsuccessful tell a user there is an error.
			If (!$run){
				echo "There was an error with the submission. Please try again!";
			} else {
				$myCatIdQuery = "SELECT CategoryId FROM categorys WHERE CategoryName='$catNameToInsert';";
				$selectQuery = @mysqli_query($dbc, $myCatIdQuery);
				$row = mysqli_fetch_array($selectQuery, MYSQLI_NUM);
				$myCatid = $row[0];				
				$JournalIdQuery = "SELECT JournalId FROM criticalincidents WHERE CriticalIncidentId='$incidentId';";
				$selectQuery = @mysqli_query($dbc, $JournalIdQuery);
				$row = mysqli_fetch_array($selectQuery, MYSQLI_NUM);
				$myJournalId = $row[0];
				$query = "INSERT INTO cicategorys (CategoryId, CriticalIncidentId, JournalId)
			          VALUES ('$myCatid', '$incidentId', '$myJournalId');";
				//$run: it is variable to Run the query
				$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
				header('Location: http://localhost/BR-Team1/JCI/Category.php');
			}
		} else {
			echo "You must enter both a category name and a category year.";
		}
	}
?>
	
	<h1>Select a Category</h1>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="assigncategory" method="post">
		<div id = 'ciCategorys'>
			<input type="hidden" name="id" value="<?php echo $incidentId; ?>">
			<?php echo $tablebody; ?>
			<p><input type="submit" name="submit" value="Submit" /></p>
		</div>
	</form>