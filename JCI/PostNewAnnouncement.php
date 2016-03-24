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
  * Revision1.1 Author:Shane Workman
  * Tweaked the SQL statement to reflect the database. Few other minor tweaks.
  * Revision1.2 Author:Shane Workman
  * Added a start date to the form/sql insert statement.
  ********************************************************************************************/
 $page_title = 'Post New Announcement';
 include ("includes/Header.php");
 include ("includes/ValidationHelper.php");
 $page_title = 'Announcements';
 
 //Grab the db connector.
 //require ('../mysqli_connect.php');
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
	if (empty($_POST['board'])) {
			$err[] = 'You forgot to enter an announcement.';
		} elseif (($_POST['board']) == 'Private') {
			$board = mysqli_real_escape_string($dbc, 1);
		} else {
			// All visitors
			$board = mysqli_real_escape_string($dbc, 2);
		}

	//Check if the Start date has a value and that it is correct.
	if (empty($_POST['startDate'])) {
			$err[] = 'You forgot to enter a date that the announcement can begin.';
		} elseif (!preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/", ($_POST['startDate']))) {
			$err[] = 'You did not enter the date in the YYYY-MM-DD format..';
		} elseif (!isDate($_POST['startDate'])) {
			$err[] = 'You did not enter a valid date.';
		} else {
				$startDate = mysqli_real_escape_string($dbc, trim($_POST['startDate']));
		}
		
 	//Check if the first name text box has a value.
	if (empty($_POST['endDate'])) {
			$err[] = 'You forgot to enter a date that the announcement expires.';
		} elseif (!preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/", ($_POST['endDate']))) {
			$err[] = 'You did not enter the date in the YYYY-MM-DD format..';
		} elseif (!isDate($_POST['endDate'])) {
			$err[] = 'You did not enter a valid date.';
		} else {
				$endDate = mysqli_real_escape_string($dbc, trim($_POST['endDate']));
		}
	

	//Check to see if any errors exist in the validation array.
	if(empty($err)) {
		//Creat the query that dumps info into the DB.
		$query = "INSERT INTO announcements (Subject, Body, StartDate, Type, EndDate, IsActive)
				  VALUES ('$title', '$announcement', '$startDate', $board, '$endDate', 1);";
				
		//Run the query...
		$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
		
		If (!$run)
		{
			echo 'There was an error when creating the announcement. Please try again!';
		} else {
			echo "Thank you for your Announcement!";
			header('Location: http://localhost/jci/ManageAnnouncements.php');
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
 <!--Takes information to create a new announcement in the db.-->
<h1>Create New Announcement</h1>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="announcement" method="post">
	<fieldset>
		<p>Who will view this Announcement?:
		<select name="board">
			<option <?php if(isset($_POST['board'])=="Public") echo'selected="selected"'; ?>    value="Public">Public</option>
			<option <?php if(isset($_POST['board'])=="Private") echo'selected="selected"'; ?>    value="Private">Private</option>
		</select></p>	
		<p>Title: <input type="text" name="title" size="15" maxlength="50" value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>" /></p>
		<p>Announcement: <br/><textarea name="announcement" style="width:250px;height:150px;" value="<?php if (isset($_POST['announcement'])) 
				echo $_POST['announcement']; ?>"></textarea><br />
		<p>Start Date(YYYY-MM-DD): <input type="text" name="startDate" size="10" maxlength="10" value="<?php if (isset($_POST['startDate'])) echo $_POST['startDate']; ?>" /></p>
		<p>End Date(YYYY-MM-DD): <input type="text" name="endDate" size="10" maxlength="10" value="<?php if (isset($_POST['endDate'])) echo $_POST['endDate']; ?>" /></p>
		<p><input type="submit" value="Submit" /></p>
	</fieldset>
</form>
<?php
include ("includes/Footer.php");
?>
