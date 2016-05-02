<?php
/*********************************************************************************************
 * Original Author: Benjamin Brackett
 * Date of origination: 04/17/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: Include a overview of the page: Such as. This is the index.php and will serve as the home page content of the site.\
 * Credit: Give any attributation to code used within, not created by you.
 *
 * Function:  functionName($myVar, $varTwo)
 * Purpose: This is the description of what the function does.
 * Variable: $myVar - Description of variable.
 * Variable: $varTwo - Another description.
 *
 * Function:  functionNameTwo($anotherVar)
 * Purpose: This is the description of what the function does.
 * Variable: $anotherVar - Description of variable. 
 *
 * Revision1.1: MM/DD/YYYY Author: Name Here 
 * Description of change. Also add //Name: comments above your change within the code.
 ********************************************************************************************/
	$page_title = 'Create Keyword';
 	include ("includes/Header.php");
	include ("includes/ValidationHelper.php");
	require ('../DbConnector.php');
	
	// everything in the bracket will run when the submit button is pressed
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
		$CriticalIncidentId = $_GET['id'];
		$keyword =$_POST['keyword'];
		// checking to make sure only letters are being entered 
		if (preg_match("/^[a-zA-Z]/", $keyword)) {
		echo "$CriticalIncidentId";
		echo "$keyword";
		
		// an insert query to insert the new keyword
		$query = "INSERT INTO keywords (CIKeyword, CriticalIncidentId) VALUES ('$keyword', $CriticalIncidentId);";
		
		$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
		}else{
			echo "The keyword can only contain English letters.";
		}
	}
	
	//grabs the id from the url
	If (isset($_GET['id'])) {
		$CriticalIncidentId = $_GET['id'];
	} 
	else if (isset($_POST['id'])){
		$CriticalIncidentId = $_POST['id'];
	}
	
	
	
	?>

	<!--Takes information to create a new announcement in the db.-->
	<h1>Edit Critical Incidents</h1>
		<form id="createKeyword" method="post">
			<fieldset>
					Keywords: <input  type="text" name="keyword" size="15" maxlength="50" value="<?php if (isset($keyword)){echo $keyword;} ?>" </input>
					<input type="hidden" value="<?php if (isset($CriticalIncidentId)) echo $CriticalIncidentId; ?>" name="id"></input>
					<input type="submit" value="Submit" />
			</fieldset>
		</form>		