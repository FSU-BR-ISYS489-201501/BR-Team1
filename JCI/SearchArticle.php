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
include ("includes/Header.php");
$page_title = 'Search Article';
require ('mysqli_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') 

//Set up Error msg array.
 	$err = array(); 

if(isset($_POST['submit'])){
	if(isset($_GET['go'])){
		if(preg_match("/^[  a-zA-Z]+/", $_POST['name'])){
			$name=$_POST['name'];

		//query  the database table
		$$dbc="CriticalIncidentId, Title, PublicationYear, UserId FROM Critical_Incident 
		JOIN Journal_of_Critical_Incidents ON Journald.joc=Journald.ci WHERE Title LIKE '%" . $name .  "%' OR PublicationYear LIKE '%" . $name ."%' OR UserId LIKE '%" . $name ."%'";
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
	}
}
?>
<h3>Search  Articles</h3>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="announcement" method="post">
	<fieldset>
		<p>You may search by
		<select name="field">
			<option <?php if(isset($_POST['field'])=="Title") echo'selected="selected"'; ?> value="Title">Title</option>
			<option <?php if(isset($_POST['field'])=="PublicationYear") echo'selected="selected"'; ?> value="PublicationYear">Publication Date</option>
			<option <?php if(isset($_POST['field'])=="UserId") echo'selected="selected"'; ?> value="UserId">Primary Author</option>
		</select>
		<input type="text" name="name" size="15" maxlength="50" value="<?php if (isset($_POST['criteria'])) echo $_POST['criteria']; ?>" /></p>
		<input type="submit" name="submit" value="Search"/></p>
     </fieldset>
</form>


<?php
include ("includes/Footer.php");
?>