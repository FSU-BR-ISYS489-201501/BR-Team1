<?php
 /*********************************************************************************************
 * Original Author:Faisal Alfadhli
 * Date of origination: 04/17/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: The purpose of this file lets an editor to create new category for a journal that is in development.
 * Credit: tutor: William Quigley, Email : mnewrath@gmail.com
 * www.php.net
 * www.stackoverflow.com
 * www.W3schools.com
 ********************************************************************************************/
 
 	include('includes/Header.php');
	include('includes/TableRowHelper.php');
	require('../DbConnector.php');
	// If $_GET or $_POST are set then assign the value to a variable.
	if (isset($_GET['id']) ) {
		$incidentId = $_GET['id'];
	} elseif (isset($_POST['id']) ) {
		$incidentId = $_POST['id'];
	}
	if (isset($_POST['submit'])){
		if (!empty($_POST['catgyName']) and !empty($_POST['catgyYear'])) {
			$catNameToInsert = $_POST['catgyName'];
			$catYearToInsert = $_POST['catgyYear'];
			// this is to build insert query into categorys table.
			$query = "INSERT INTO categorys (CategoryName, CategoryYear)
			          VALUES ('$catNameToInsert', '$catYearToInsert');";
			$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
			//if query is unsuccessful tell a user there is an error.
			If (!$run){
				echo "There was an error with the submission. Please try again!";
			} else {
				// It gets ID of last insert query in db.
				//http://www.w3schools.com/php/php_mysql_insert_lastid.asp
				$lastId = mysqli_insert_id($dbc);
				$query = "UPDATE criticalincidents SET Category='$catNameToInsert' WHERE CriticalIncidentId='$incidentId';";
				$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
				$JournalIdQuery = "SELECT JournalId FROM criticalincidents WHERE CriticalIncidentId='$incidentId';";
				$selectQuery = @mysqli_query($dbc, $JournalIdQuery);
				$row = mysqli_fetch_array($selectQuery, MYSQLI_NUM);
				$myJournalId = $row[0];
				$query = "INSERT INTO cicategorys (CategoryId, CriticalIncidentId, JournalId)
			          VALUES ('$lastId', '$incidentId', '$myJournalId');";
				$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
				header('Location: http://localhost/BR-Team1/JCI/Category.php');
			}
		} else {
			echo "You must enter both a category name and a category year.";
		}
	}
?>

	<h1>Create New Category</h1>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="newcategory" method="post">
		<fieldset>
			<input type="hidden" name="id" value="<?php echo $incidentId; ?>">
			<p>Category Name: <input type="text" name="catgyName" size="15" maxlength="50" value="<?php if (isset($_POST['catgyName'])) echo $_POST['catgyName']; ?>" /></p>
			<p>Category Year: <input type="text" name="catgyYear" size="15" maxlength="50" value="<?php if (isset($_POST['catgyYear'])) echo $_POST['catgyYear']; ?>" /></p>
			<p><input type="submit" name="submit" value="Submit" /></p>
		</fieldset>
	</form>

<?php
 	include ("includes/Footer.php");
?>