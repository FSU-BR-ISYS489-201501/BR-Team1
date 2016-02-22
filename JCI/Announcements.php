<?php
 /*********************************************************************************************
  * Original Author: Shane Workman
  * Date of origination: 02/21/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: The purpose of this page is to collect data for new announcements.
  * Credit: http://php.net/manual/en/index.php
  * 
  ********************************************************************************************/
 include ("includes/Header.php");
 $page_title = 'Announcements';
 
 //Grab the db connector.
 require ('../DbConnector.php');
 
 //Begin Validation... 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
 	//Set up Error msg array.
 	$err = array();
 	//Check if the first name text box has a value.
	if (empty($_POST['title'])) {
			$err[] = 'You forgot to put a title for the announcement.';
		} else {
			$title = mysqli_real_escape_string($dbc, trim($_POST['title']));
		}
	
	//Check if the first name text box has a value.
	if (empty($_POST['announcement'])) {
		$err[] = 'You forgot to enter an announcement.';
		} else {
			$announcement = mysqli_real_escape_string($dbc, trim($_POST['announcement']));
		}
		
 	//Check if the first name text box has a value.
	if (empty($_POST['endDate'])) {
			$err[] = 'You forgot to enter a date that the announcement expires.';
		} elseif (!preg_match("/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/", ($_POST['endDate']))) {
			$err[] = 'You did not enter the date in the MM/DD/YYYY format..';
		} elseif (!checkdate($_POST['endDate'])) {
			$err[] = 'You forgot to enter a date that the announcement expires.';
		} elseif (($_POST['endDate']) < getdate()) {
			$err[] = 'The expiration date must be in the Future.';
		} else {
			$endDate = mysqli_real_escape_string($dbc, trim($_POST['endDate']));
		}

	//Check to see if any errors exist in the validation array.
	if(empty($err)) {
		//Creat the query that dumps info into the DB.
		$query = "INSERT INTO Announcements (title, announcement, createDate, expireDate)
				VALUES ('$title', '$announcement', NOW(), '$endDate');";
				
		//Run the query...
		$run = @mysqli_query($dbc, $query);
		
		IF (!$run)
		{
			echo 'There was an error when creating the announcement. Please try again!';
		}
	} else {
			//List each Error msg that is stored in the array.
			Foreach($err as $m)
			{
				echo " $m <br />";
			} echo "Please correct the errors.";
		
		}	
}

	//Temp display announcements to verify adding works.
	$query = "SELECT title, announcement, createDate FROM Announcements WHERE expireDate > DATE(NOW()) ORDER BY createDate ASC"; 
	$result = mysql_query($query);
 ?>
 <!--Takes information to create a new announcement in the db.-->
<h1>New Announcement</h1>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="announcement" method="post">
	<fieldset>
		<p>Title: <input type="text" name="title" size="15" maxlength="50" value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>" /></p>
		<p>Announcement: <textarea name="announcement" style="width:250px;height:150px;" value="<?php if (isset($_POST['announcement'])) echo $_POST['announcement']; ?>"></textarea
		<p>End Date(MM/DD/YYYY): <input type="text" name="endDate" size="10" maxlength="10" value="<?php if (isset($_POST['endDate'])) echo $_POST['endDate']; ?>" /></p>
		<p><input type="submit" value="Submit" /></p>
	</fieldset>
</form>
<!--Creates a table to show the current Announcements in the DB. -->
<table>
	<fieldset>
		<thead>
			<tr>
				<th>Title</th>
				<th>Announcement</th>
				<th>Creation Date</th>
			</tr>
		</thead>
		<tbody>
			<?php
			while ($row = mysqli_fetch_row($result)) {
				echo "<tr>";
				echo "<td>" . $row['title'] . "</td>";
				echo "<td>" . $row['announcement'] . "</td>";
				echo "<td>" . $row['createDate'] . "</td>";
				echo "</tr>\n";		
			}
			?>
		</tbody>
	</fieldset>
</table>
<?php
include ("includes/Footer.php");
?>
