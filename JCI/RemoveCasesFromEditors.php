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
 
  ********************************************************************************************/
	include ('includes/Header.php');
	require ('../DbConnector.php');
	include('includes/TableRowHelper.php');
	
	$editorsQuery =  "SELECT users.UserId, users.FName, users.LName FROM users 
						INNER JOIN reviewers ON users.UserId=reviewers.UserId 
						INNER JOIN reviewcis ON reviewers.ReviewerId=reviewcis.ReviewerId 
						INNER JOIN criticalincidents ON criticalincidents.CriticalIncidentId=reviewcis.CriticalIncidentId 
						WHERE reviewcis.CriticalIncidentId=$incidentId;";
	$editorsIdQuery = "SELECT users.UserId FROM users 
						INNER JOIN reviewers ON users.UserId=reviewers.UserId 
						INNER JOIN reviewcis ON reviewers.ReviewerId=reviewcis.ReviewerId 
						INNER JOIN criticalincidents ON criticalincidents.CriticalIncidentId=reviewcis.CriticalIncidentId 
						WHERE reviewcis.CriticalIncidentId=$incidentId;";
	
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
		//To determine how many fields were returned in the query.
		$headerCounter = countNumberOfFields($dbc, $submissionSelectQuery);
		//To list editors names in dropdown list.
		$radioButton = tableRowRadioButtonGenerator($dbc, $editorSelectQuery, $ids);
		$tableBody = tableRowGeneratorWithRadioButtons($submissionSelectQuery, $radioButton, $headerCounter, $ids);
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		//This block will update the select value to db
		$insertQuery ='INSERT INTO criticalincidents(Editor) VALUES(_POST("$editors[a]"))';
		$run = mysqli_query($dbc, $insertQuery);
	}
	else{
		echo 'Sorry, there is an error, try again please!';
		
	}
?>
	<h1>Assign Editors</h1>
	<div id = 'divRemoveEditors'>
		<div class="main">
			<form name="frmRemoveEditors" action="RemoveCasesFromEditors.php" method="post">
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
				<!-----Including PHP Script----->
				<br/><input type='submit' name='submit' Value='Submit'/><br/><br/>
<?php
	include('includes/footer.php');
?>