<?php
 /*********************************************************************************************
  * Original Author: Shane Workman
  * Date of origination: 02/22/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: The purpose of this page is to allow people search for Users and what they are "linked" too.
  * Credit: Mostly all my own code, I did borrow a portion of code from Ben Brackett's browseCI page within the JCI site.
  *********************************************************************************************/
$page_title = 'Search Staff';
include ("includes/Header.php");
require ('../DbConnector.php');
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
	//Set up Error msg array.
 	$err = array(); 
	
	//Checks to see what is to be Searched for.
	if (($_POST['search']) == "Authored by") {
		$search = mysqli_real_escape_string($dbc, trim($_POST['search']));
	} elseif (($_POST['search']) == "Journals Reviewed") {
		$search = mysqli_real_escape_string($dbc, trim($_POST['search']));
	} else {
		$err[] = 'This error should never print; if it does, select search is bugged.';
	}
	
	//Checks to see what criteria we are searching for.
	if (($_POST['field']) == "First Name") {
		$field = mysqli_real_escape_string($dbc, trim($_POST['field']));
	} elseif (($_POST['field']) == "Last Name") {
		$field = mysqli_real_escape_string($dbc, trim($_POST['field']));
	} elseif (($_POST['field']) == "Email") {
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
	if (!empty($err)) {
		// Create and run the query based of the given criteria.
		if ($search == "Authored by") {
			if($field == "First Name")	{
				$query = "SELECT CONCAT(users.FName, users.LName) As name, users.Email as email, criticalincidents.Title as title
						FROM users LEFT JOIN criticalincidents ON users.UserId = criticalincidents.UserId  
						WHERE users.FName = $criteria;";
			} elseif ($search == "Last Name") {
				$query = "	SELECT CONCAT(users.FName, users.LName) As name, users.Email as email, criticalincidents.Title as title
						FROM users LEFT JOIN criticalincidents ON users.UserId = criticalincidents.UserId
						WHERE users.LName = $criteria;";
			} elseif ($search == "Email") {
				$query = "	SELECT CONCAT(users.FName, users.LName) As name, users.Email as email, criticalincidents.Title as title
						FROM users LEFT JOIN criticalincidents ON users.UserId = criticalincidents.UserId
						WHERE users.Email = $criteria;";
			} else {
				echo 'This Error should never be print; if it does, query is bugged.';
			}
		} else {
			// add more $search criteria at some point.
		}
		// Borrowed from Ben. Really like this method.
		if (!empty(mysqli_num_rows($query))){
			while ($row = mysqli_fetch_row($query)) {
				$name = $row['name'];
				$email = $row['email'];
				$title = $row['title'];
				
				$output .= '<div>'
							.$name.
							''
							.$email.
							''
							.$title.
							'<div>';
			}
			
		} else {
			$output = "There weren't any search results to display.";
		}
	} else {
		//List each Error msg that is stored in the array.
		Foreach($err as $m)
		{
			echo " $m <br />";
		} echo "Please correct the errors.";
	}
}
?>
<h1>Search Criteria</h1>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="announcement" method="post">
	<fieldset>
		<p>Search For:
		<select name="search">
			<option <?php if(isset($_POST['search'])=="Authored by") echo'selected="selected"'; ?>    value="Authored by">Authored by</option>
			<!-- temp unused. Will add more search on data as presented.
			<option <?php if(isset($_POST['search'])=="Journals Reviewed") echo'selected="selected"'; ?>    value="Journals Reviewed">Journals Reviewed</option>
			<option <?php if(isset($_POST['search'])=="Journals Reviewed") echo'selected="selected"'; ?>    value="Journals Reviewed">Journals Reviewed</option>
			<option <?php if(isset($_POST['search'])=="Journals Reviewed") echo'selected="selected"'; ?>    value="Journals Reviewed">Journals Reviewed</option>
			<option <?php if(isset($_POST['search'])=="Journals Reviewed") echo'selected="selected"'; ?>    value="Journals Reviewed">Journals Reviewed</option>
			<option <?php if(isset($_POST['search'])=="Journals Reviewed") echo'selected="selected"'; ?>    value="Journals Reviewed">Journals Reviewed</option>
			-->
		</select></p>
		<p>On the criteria of:
		<select name="field">
			<option <?php if(isset($_POST['field'])=="First Name") echo'selected="selected"'; ?>    value="First Name">First Name</option>
			<option <?php if(isset($_POST['field'])=="Last Name") echo'selected="selected"'; ?>    value="Last Name">Last Name</option>
			<option <?php if(isset($_POST['field'])=="Email") echo'selected="selected"'; ?>    value="Email">Email</option>
		</select>
		<input type="text" name="criteria" size="15" maxlength="50" value="<?php if (isset($_POST['criteria'])) echo $_POST['criteria']; ?>" /></p>
		<p><input type="submit" value="Search" /></p>
	</fieldset>
</form> 
<h1>Search Results</h1>
<fieldset>
	<table>
		<thead>
			<tr>
				<th>--Name--</th>
				<th>--Email--</th>
				<th>--Title--</th>
			</tr>
		</thead>
		<tbody>
			<?php
				print("$output");
			?>
		</tbody>
	</table>
</fieldset>

<?php
include ("includes/Footer.php");
?>