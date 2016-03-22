<?php
 /*********************************************************************************************
  * Original Author: Shane Workman
  * Date of origination: 02/22/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: The purpose of this page is to allow people search for Users and what they are "linked" too.
  * Credit: Mostly all my own code, I did borrow a portion of code from Ben Brackett's browseCI page within the JCI site.
  *  
  * Revision1.1: 03/22/2016 Author: Shane Workman 
  * Combined Ben's search page with mine. Updated the diplay. 
  *********************************************************************************************/
$page_title = 'Search';
include ("includes/Header.php");
include ("includes/TableRowHelper.php");
require ('../DbConnector.php');
$tableBody = "";
$query = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
	//Set up Error msg array.
 	$err = array(); 
	
	
	//Checks to see what criteria we are searching for.
	if (($_POST['field']) == "First Name") {
		$field = mysqli_real_escape_string($dbc, trim($_POST['field']));
	} elseif (($_POST['field']) == "Last Name") {
		$field = mysqli_real_escape_string($dbc, trim($_POST['field']));
	} elseif (($_POST['field']) == "Email") {
		$field = mysqli_real_escape_string($dbc, trim($_POST['field']));
	} elseif (($_POST['field']) == "Title") {
		$field = mysqli_real_escape_string($dbc, trim($_POST['field']));
	} elseif (($_POST['field']) == "PublicationYear") {
		$field = mysqli_real_escape_string($dbc, trim($_POST['field']));
	} else {
		$err[] = 'This error should never print; if it does, select field is bugged.';
	}
	
	//Checks to make sure the user entered some data into the criteria text box.
	if (empty($_POST['criteria'])) {
		$err[] = 'You did not enter anything in the criteria field to search for.';
	} else {
		$criteria = mysqli_real_escape_string($dbc, trim($_POST['criteria']));
	}
	
	//Check to see if any errors occurred during validation.
	if (empty($err)) {
		// Create and run the query based of the given criteria.
			if($field == "First Name")	{
				$query = "SELECT CONCAT(users.FName, users.LName) As name, users.Email as email, criticalincidents.Title as title
						FROM users LEFT JOIN criticalincidents ON users.UserId = criticalincidents.UserId  
						WHERE users.FName = '$criteria';";
			} elseif ($field == "Last Name") {
				$query = "	SELECT CONCAT(users.FName, users.LName) As name, users.Email as email, criticalincidents.Title as title
						FROM users LEFT JOIN criticalincidents ON users.UserId = criticalincidents.UserId
						WHERE users.LName = '$criteria';";
			} elseif ($field == "Email") {
				$query = "	SELECT CONCAT(users.FName, users.LName) As name, users.Email as email, criticalincidents.Title as title
						FROM users LEFT JOIN criticalincidents ON users.UserId = criticalincidents.UserId
						WHERE users.Email = '$criteria';";
			} elseif($field == "Title")	{
				$query = "SELECT PublicationYear, CriticalIncidentId.criticalincidents, Title.criticalincidents, UserId, CONCAT(users.FName, users.LName) AS name
						FROM users LEFT JOIN criticalincidents ON Title.users = Title.criticalincidents
						LEFT JOIN journalofcriticalincidents on CriticalIncidentId.journalofcriticalincidents
						WHERE Title.criticalincidents = '$criteria';";
			} elseif ($field == "PublicationYear") {
				$query = "	SELECT PublicationYear, CriticalIncidentId.criticalincidents, Title.criticalincidents, UserId, CONCAT(users.FName, users.LName) AS name
						FROM users LEFT JOIN criticalincidents ON Title.users = Title.criticalincidents
						LEFT JOIN journalofcriticalincidents on CriticalIncidentId.journalofcriticalincidents
						WHERE PublicationYear = '$criteria';";
			} elseif ($field == "UserId") {
				$query = "	SELECT PublicationYear, CriticalIncidentId.criticalincidents, Title.criticalincidents, UserId, CONCAT(users.FName, users.LName) AS name
						FROM users LEFT JOIN criticalincidents ON Title.users = Title.criticalincidents
						LEFT JOIN journalofcriticalincidents on CriticalIncidentId.journalofcriticalincidents
						WHERE name = '$criteria';";
			} else {
				// nothing.
			} 
	//Diplay search resualts.
	$run = mysqli_query($dbc, $query);
	$headerCounter = mysqli_num_fields($run);
	$tableBody = tableRowGenerator($run, $headerCounter);
	
	} else {
		//List each Error msg that is stored in the array.
		Foreach($err as $m)
		{
			echo " $m <br />";
		} echo "Please correct the errors.";
    }
} else {
	//$query = "";
	//$headerCounter = mysqli_num_fields($query);
	//$tableBody = tableRowGenerator($query, $headerCounter);
}
?>
<h1>Search Criteria</h1>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="announcement" method="post">
	<fieldset>
		<p>Search on the criteria of:
		<select name="field">
			<option <?php if(isset($_POST['field'])=="First Name") echo'selected="selected"'; ?>    value="First Name">First Name</option>
			<option <?php if(isset($_POST['field'])=="Last Name") echo'selected="selected"'; ?>    value="Last Name">Last Name</option>
			<option <?php if(isset($_POST['field'])=="Email") echo'selected="selected"'; ?>    value="Email">Email</option>
			<option <?php if(isset($_POST['field'])=="Title") echo'selected="selected"'; ?> value="Title">Title</option>
			<option <?php if(isset($_POST['field'])=="PublicationYear") echo'selected="selected"'; ?> value="PublicationYear">Publication Date</option>
		</select>
		<input type="text" name="criteria" size="15" maxlength="50" value="<?php if (isset($_POST['criteria'])) echo $_POST['criteria']; ?>" /></p>
		<p><input type="submit" value="Search" /></p>
	</fieldset>
</form> 
<h1>Search Results</h1>
<fieldset>
	<table>
		<tbody>
			<?php echo $tableBody; ?>
		</tbody>
	</table>
</fieldset>

<?php
include ("includes/Footer.php");
?>