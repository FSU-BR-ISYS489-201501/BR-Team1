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
 *  *Revision1.0: 03/11/2016 Author: Faisal Alfadhli: edited tables names
  ********************************************************************************************/
	include ('includes/Header.php');
	require ('../DbConnector.php');
	include('includes/TableRowHelper.php');
	
	
	$submissionQuery= "Select submissions.SubmissionId, users.UserId, users.FName, users.LName, submissions.SubmissionDate 
		from submissions JOIN users on submissions.UserId = users.UserId;";
	$editorName= "SELECT LName from users U JOIN usertypes T on U.UserId = T.UserId
		WHERE Type = 'Editor';";	
	$idQuery = "SELECT SubmissionId FROM submissions;";
	//$UpdateEditorTable= "UPDATE Critical_Incident SET ";
	
	$idSelectQuery = @mysqli_query($dbc, $idQuery);
	$editorSelectQuery = @mysqli_query($dbc, $editorName);
	$submissionSelectQuery = @mysqli_query($dbc, $submissionQuery);
	
	$ids = array();
	$tableBody = '';
	
	while ($row = mysqli_fetch_row($idSelectQuery)) {
		array_push($ids, $row);
	}
	if (!empty($ids)){
		// to determine how many fields were returned in the query.
		$headerCounter = countNumberOfFields($dbc, $submissionSelectQuery);
		// to list editors names in dropdown list.
		$radioButton = tableRowRadioButtonGenerator($dbc, $editorSelectQuery, $ids);
		$tableBody = tableRowGeneratorWithRadioButtons($dbc, $submissionSelectQuery, $radioButton, $headerCounter, $ids);
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// this block will update the select vallue to db
		$insertQuery ='insert into CriticalIncidents(Editor) VALUES(_POST("$editors[a]"))';
		$run = mysqli_query($dbc, $insertQuery);
	}
	else{
		echo 'Soerry, there is an error, try again please!';
		
	}
		
		// //Set up Error msg array.
		// $err = array();
		// //Check if a user select a name or not.
		// for($a = 0;$a < 5;$a++) {
			// if (isset($_POST['selectEditor1'])) {
			// $err[] = 'You forgot to select an editor.';
		// } 
		// }
		// if (isset($_POST['selectEditor1'])) {
			// $err[] = 'You forgot to select an editor.';
		// } 
			// else {
				// $qeury = $submissionQuery;
				// //Run the query
				// $run = @mysqli_query($dbc, $query);
			// }
		// if(isset($_POST['selectEditor2'])) {
			// $err[] = 'You forgot to select an editor.';
		// } 
			// else {
				// $caseID = mysql_real_escape_string($_POST['criticalIncidentId']);
				// $date = mysql_real_escape_string($_POST['SubmissionDate']);
				// $editor = mysql_real_escape_string($_POST['EditorName']);
				// $qeury = "insert into Editor ('FileID','SubmissionDate','EditorName') values('$fileid','$date','$editor')";
				// //Run the query
				// $run = @mysqli_query($dbc, $query);
			// }
// 		
		// if(isset($_POST['selectEditor3'])) {
			// $err[] = 'You forgot to select an editor.'; 
		// }
			// else {
				// $caseID = mysql_real_escape_string($_POST['criticalIncidentId']);
				// $date = mysql_real_escape_string($_POST['SubmissionDate']);
				// $editor = mysql_real_escape_string($_POST['EditorName']);
				// $qeury = "insert into Editor ('FileID','SubmissionDate','EditorName') values('$fileid','$date','$editor')";
				// //Run the query
				// $run = @mysqli_query($dbc, $query);
			// }
		// if(isset($_POST['selectEditor4'])) {
			// $err[] = 'You forgot to select an editor.'; 
		// }
			// else {
				// $caseID = mysql_real_escape_string($_POST['criticalIncidentId']);
				// $date = mysql_real_escape_string($_POST['SubmissionDate']);
				// $editor = mysql_real_escape_string($_POST['EditorName']);
				// $qeury = "insert into Editor ('caseID','SubmissionDate','EditorName') values('$caseID','$date','$editor')";
				// //Run the query
				// $run = @mysqli_query($dbc, $query);
			// }
// 		
	// }


?>
	<h2 align="center">Assign Cases To Editors</h1>
	<form id = 'assignCasesToEditors' method = 'POST' action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<table>
			<tr>
				<th>Submiision ID</th>
				<th>Author ID</th>
				<th>Author Name</th>
				<th>Submission Date</th>
				<th>Editor Name</th>
			</tr>
			<?php echo $tableBody; ?>
		</table>
		<input type="Submit" name="submit" value="Update" />
	</form>
<?php
	include('includes/footer.php');
?>