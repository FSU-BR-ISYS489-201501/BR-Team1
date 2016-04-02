<?php
/*********************************************************************************************
 * Original Author: Ben Brackett
 * Date of origination: 02/22/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: Include a overview of the page: Such as. This is the index.php and will serve as the home page content of the site.\
 * Credit: http://www.webreference.com/programming/php/search/2.html
 *
 * Revision1.1: MM/DD/YYYY Author: Name Here 
 * Description of change. Also add //Name: comments above your change within the code.
 ********************************************************************************************/
$page_title = 'Search Article';
include ("includes/Header.php");
require ('../DbConnector.php');
//require ('mysqli_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

//Set up Error msg array.
 	$err = array(); 
	
	//Written by Shane Workman
	//Checks to see what criteria we are searching for.
	if (($_POST['field']) == "Title") {
		$field = mysqli_real_escape_string($dbc, trim($_POST['field']));
	} elseif (($_POST['field']) == "PublicationYear") {
		$field = mysqli_real_escape_string($dbc, trim($_POST['field']));
	} elseif (($_POST['field']) == "UserId") {
		$field = mysqli_real_escape_string($dbc, trim($_POST['field']));
	} else {
		$err[] = 'SELECT field is bugged.';
	}
	
	//Written by Shane Workman
	//Checks to make sure the user entered some data into the criteria text box.
	if (empty($_POST['criteria'])) {
		$err[] = 'You did not enter anything in the criteria field to search for.';
	} else {
		$criteria = mysqli_real_escape_string($dbc, trim($_POST['criteria']));
	}
	
	//Written by Shane Workman, edited by Ben Brackett
	//Check to see if any errors occurred during validation.
	if (empty($err)) {
		// Create and run the query based of the given criteria.
			if($field == "Title")	{
				$query = "	SELECT PublicationYear, CriticalIncidentId.criticalincidents, Title.criticalincidents, UserId, CONCAT(users.FName, users.LName) AS name
						FROM users LEFT JOIN criticalincidents ON Title.users = Title.criticalincidents
						LEFT JOIN journalofcriticalincidents on CriticalIncidentId.journalofcriticalincidents
						WHERE Title.criticalincidents = $criteria;";
			} elseif ($field == "PublicationYear") {
				$query = "	SELECT PublicationYear, CriticalIncidentId.criticalincidents, Title.criticalincidents, UserId, CONCAT(users.FName, users.LName) AS name
						FROM users LEFT JOIN criticalincidents ON Title.users = Title.criticalincidents
						LEFT JOIN journalofcriticalincidents on CriticalIncidentId.journalofcriticalincidents
						WHERE PublicationYear = $criteria;";
			} elseif ($field == "UserId") {
				$query = "	SELECT PublicationYear, CriticalIncidentId.criticalincidents, Title.criticalincidents, UserId, CONCAT(users.FName, users.LName) AS name
						FROM users LEFT JOIN criticalincidents ON Title.users = Title.criticalincidents
						LEFT JOIN journalofcriticalincidents on CriticalIncidentId.journalofcriticalincidents
						WHERE name = $criteria;";
			} else {
				echo 'This Error should never be print; if it does, query is bugged.';
			}
			$results = @mysqli_query($dbc, $query);

 			if (!empty($err)) {
 			//List each Error msg that is stored in the array.
			Foreach($err as $m)
			{
				echo " $m <br />";
			} echo "Please correct the errors.";
			}
	}
}

	/**if(isset($_GET['submit'])){
		if(preg_match("/^[  a-zA-Z]+/", $_POST['result'])){
			$result=$_POST['result'];

		//query  the database table
		$$dbc="CriticalIncidentId, Title, PublicationYear, UserId FROM criticalincident 
		JOIN journalofcriticalincidents ON Journald.joc=Journald.ci WHERE Title LIKE '%" . $result .  "%' OR PublicationYear LIKE '%" . $result ."%' OR UserId LIKE '%" . $result ."%'";
		//run  the query against the mysql query function
		$result=mysql_query($dbc);
		//create  while loop and loop through result set
		while($row=mysql_fetch_array($result)){
				$Title=$row['Title'];
				$PublicationDate=$row['PublicationYear'];
				$PrimaryAuthor=$row['UserId'];
				$ID=$row['CriticalIncidentId'];
				//-display the result of the array
				echo "<ul>\n";
				echo "<li>" .$Title . " " . $PublicationYear .  " " . $UserId .  "</a></li>\n";
				echo "</ul>";
			}
		}
		else{
		echo  "<p>Please enter a search query</p>";
		}
	}*/

?>
<!--Edited, but orginally written by Shane Workman-->
<h3>Search  Articles</h3>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="announcement" method="post">
	<fieldset>
		<p>You may search by
		<select name="field">
			<option <?php if(isset($_POST['field'])=="Title") echo'selected="selected"'; ?> value="Title">Title</option>
			<option <?php if(isset($_POST['field'])=="PublicationYear") echo'selected="selected"'; ?> value="PublicationYear">Publication Date</option>
			<option <?php if(isset($_POST['field'])=="UserId") echo'selected="selected"'; ?> value="UserId">Primary Author</option>
		</select>
		<input type="text" name="result" size="15" maxlength="50" value="<?php if (isset($_POST['criteria'])) echo $_POST['criteria']; ?>" /></p>
		<p><input type="submit" name="submit" value="field"/></p>
     </fieldset>
</form>


<?php
include ("includes/Footer.php");
?>