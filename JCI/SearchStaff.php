<?php
 /*********************************************************************************************
  * Original Author: Shane Workman
  * Date of origination: 02/22/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: The purpose of this page is to allow people search for Users and what they are "linked" too.
  * Credit: All my own code.
  *********************************************************************************************/
include ("includes/Header.php");
$page_title = 'Search Staff';
//require ('../DbConnector.php');
 
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
	if (empty($err)) {
		// Create and run the query based of the given criteria.
		
	}



}
?>
<h1>Search Criteria</h1>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="announcement" method="post">
	<fieldset>
		<p>Search For:
		<select name="search">
			<option <?php if(isset($_POST['search'])=="Authored by") echo'selected="selected"'; ?>    value="Authored by">Authored by</option>
			<option <?php if(isset($_POST['search'])=="Journals Reviewed") echo'selected="selected"'; ?>    value="Journals Reviewed">Journals Reviewed</option>
			<!-- temp unused. Will add more search on data as presented.
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
<!-- to be used at a later date once decide what to do.
<h1>Announcements</h1>
<table>
	<fieldset>
		<thead>
			<tr>
				<th>--Something--</th>
				<th>--Something--</th>
				<th>--Something--</th>
			</tr>
		</thead>
		<tbody>
			<?php
			while ($row = mysqli_fetch_row($result)) {
				echo "<tr>";
				echo "<td>" . $row['-'] . "</td>";
				echo "<td>" . $row['-'] . "</td>";
				echo "<td>" . $row['-'] . "</td>";
				echo "</tr>\n";		
			}
			?>
		</tbody>
	</fieldset>
</table>
--> 


<?php
include ("includes/Footer.php");
?>