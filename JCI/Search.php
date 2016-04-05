<?php
 /*********************************************************************************************
  * Original Author: Shane Workman
  * Date of origination: 02/22/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: The purpose of this page is to allow people search for Users and what they are "linked" too.
  * Credit: Mostly all my own code, I did borrow a portion of code from Ben Brackett's browseCI page within the JCI site
  * (which is no longer used on this page) and used marks functions.
  *  
  * Revision1.1: 03/22/2016 Author: Shane Workman 
  * Combined Ben's search page with mine. Updated the diplay. 
  *********************************************************************************************/
$page_title = 'Search';
include ("includes/Header.php");
include ("includes/TableRowHelper.php");
require ('../DbConnector.php');
$tableBody = "";
$searchHeader = "";
$tableStart= "<table><tbody>";
$tableEnd= "</table></tbody>";
$fieldVar = "First Name";
//$emptyResults= "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
	//Set up Error msg array.
 	$err = array();
	
	//Sticky forms help.
	if(isset($_POST['field']) == "First Name"){
		$fieldVar = $_POST['field'];
	} elseif(isset($_POST['field'])== "Last Name"){
		$fieldVar = $_POST['field'];
	} elseif(isset($_POST['field'])== "Email"){
		$fieldVar = $_POST['field'];
	} elseif(isset($_POST['field'])== "Title"){
		$fieldVar = $_POST['field'];
	} elseif(isset($_POST['field'])== "Keyword"){
		$fieldVar = $_POST['field'];
	} elseif(isset($_POST['field'])== "PubYear"){
		$fieldVar = $_POST['field'];
	} else {
		$fieldVar = "First Name";
	}
	
	//Checks to see what criteria we are searching for.
	if (($_POST['field']) == "First Name") {
		$field = mysqli_real_escape_string($dbc, trim($_POST['field']));
	} elseif (($_POST['field']) == "Last Name") {
		$field = mysqli_real_escape_string($dbc, trim($_POST['field']));
	} elseif (($_POST['field']) == "Email") {
		$field = mysqli_real_escape_string($dbc, trim($_POST['field']));
	} elseif (($_POST['field']) == "Title") {
		$field = mysqli_real_escape_string($dbc, trim($_POST['field']));
	} elseif (($_POST['field']) == "PubYear") {
		$field = mysqli_real_escape_string($dbc, trim($_POST['field']));
	} elseif (($_POST['field']) == "Keyword"){
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
				$query = "SELECT users.LName, users.FName, users.Email as email, criticalincidents.Title as title
									FROM users LEFT JOIN criticalincidents ON users.UserId = criticalincidents.UserId  
									WHERE users.FName = '$criteria';";
									
			} elseif ($field == "Last Name") {
				$query = "SELECT users.LName, users.FName, users.Email as email, criticalincidents.Title as title
									FROM users LEFT JOIN criticalincidents ON users.UserId = criticalincidents.UserId
									WHERE users.LName = '$criteria';";
									
			} elseif ($field == "Email") {
				$query = "SELECT users.LName, users.FName, users.Email as email, criticalincidents.Title as title
									FROM users LEFT JOIN criticalincidents ON users.UserId = criticalincidents.UserId
									WHERE users.Email = '$criteria';";
									
			} elseif($field == "Title")	{
				$query = "SELECT criticalincidents.Title, criticalincidents.Category, journalofcriticalincidents.PublicationYear 
									FROM criticalincidents  INNER JOIN journalofcriticalincidents 
									ON criticalincidents.JournalId = journalofcriticalincidents.JournalId
									WHERE criticalincidents.Title = '$criteria';";
									
				$idSelectQuery = "SELECT CriticalIncidentId FROM criticalincidents WHERE Title = '$criteria';";
				
			} elseif ($field == "PubYear") {
				$query = "Select  criticalincidents.Title, criticalincidents.Category, journalofcriticalincidents.PublicationYear
									FROM criticalincidents INNER JOIN journalofcriticalincidents
									ON criticalincidents.JournalId = journalofcriticalincidents.JournalId
									WHERE journalofcriticalincidents.PublicationYear = '$criteria'; ";
									
				$idSelectQuery = "SELECT criticalincidents.CriticalIncidentId 
									FROM criticalincidents INNER JOIN journalofcriticalincidents
									ON criticalincidents.JournalId = journalofcriticalincidents.JournalId
									WHERE journalofcriticalincidents.PublicationYear = '$criteria'; ";
									
			} elseif ($field == "Keyword") {
				$query = "Select criticalincidents.Title, criticalincidents.Category, journalofcriticalincidents.PublicationYear 
									FROM criticalincidents LEFT JOIN keywords 
									ON keywords.CriticalIncidentId = criticalincidents.CriticalIncidentId 
									INNER JOIN journalofcriticalincidents 
									ON criticalincidents.JournalId = journalofcriticalincidents.JournalId 
									WHERE CIKeyword = '$criteria';";
									
				$idSelectQuery = "Select criticalincidents.CriticalIncidentId
									FROM criticalincidents LEFT JOIN keywords 
									ON keywords.CriticalIncidentId = criticalincidents.CriticalIncidentId 
									INNER JOIN journalofcriticalincidents 
									ON criticalincidents.JournalId = journalofcriticalincidents.JournalId 
									WHERE CIKeyword = '$criteria';";
									
			} else {
				echo "If this prints, Selecting which SQL statement is used is bugged!";
			} 
		if($field == "First Name" || $field == "Last Name" || $field == "Email"){
			//Diplay search resualts.
			$run = mysqli_query($dbc, $query);
			$headerCounter = mysqli_num_fields($run);
			$tableBody = tableRowGenerator($run, $headerCounter);
			$searchHeader = "<th>Last Name</th><th>First Name</th><th>Email</th><th>Title</th>";
			//"Last Name - First Name - Email - Title";
			
		} elseif ($field == "PubYear" || $field == "Title" || $field == "Keywords"){
			$run = mysqli_query($dbc, $query);
	  		$headerCounter = mysqli_num_fields($run);
	  		$idSelectRun = mysqli_query($dbc, $idSelectQuery);
	  		$pageNames = array('PdfViewerSummary.php', 'PdfViewerCI.php');
			$titles = array('View Summary', 'View Critical Incidents');
			$variableName = array('JournalId', 'JournalId');
			$editButton = tableRowLinkGenerator($idSelectRun, $pageNames, $variableName, $titles);
			$tableBody = tableRowGeneratorWithButtons($run, $editButton, 2, $headerCounter);
			$searchHeader = "<th>Title</th><th>Category</th><th>Year Published</th>";
			 
		} else { echo "if this prints, display results is bugged"; }
		
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
			<option <?php if($fieldVar == "First Name") echo'selected="selected"'; ?>    value="First Name">First Name</option>
			<option <?php if($fieldVar == "Last Name") echo'selected="selected"'; ?>    value="Last Name">Last Name</option>
			<option <?php if($fieldVar == "Email") echo'selected="selected"'; ?>    value="Email">Email</option>
			<option <?php if($fieldVar == "Title") echo'selected="selected"'; ?> value="Title">Title</option>
			<option <?php if($fieldVar == "Keyword") echo'selected="selected"'; ?>    value="Keyword">Keyword</option>
			<option <?php if($fieldVar == "PubYear") echo'selected="selected"'; ?> value="PubYear">Publication Date</option>
		</select>
		<input type="text" name="criteria" size="15" maxlength="50" value="<?php if (isset($_POST['criteria'])) echo $_POST['criteria']; ?>" /></p>
		<p><input type="submit" value="Search" /></p>
	</fieldset>
</form> 
<h1>Search Results</h1>
<fieldset>
	<?php 
		IF (!empty($tableBody)){
			echo $tableStart;
			echo $searchHeader;
			echo $tableBody;
			echo $tableEnd;
		} else {
			echo "No Search Results!";
		}
	?>
</fieldset>

<?php
include ("includes/Footer.php");
?>