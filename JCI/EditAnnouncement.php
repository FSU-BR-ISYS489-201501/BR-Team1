<?php
/*********************************************************************************************
  * Original Author: Faisal Alfadhli
  * Date of origination: 02/22/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: this page is used for making changes in announcement when an editors click on edit button from manage announcement page
  * Credits: tutor: William Quigley, Email : mnewrath@gmail.com
  * www.W3schools.com
  * www.php.net
  * http://stackoverflow.com/  
  * Revision 1.0: 03/18/2016 Author: Faisal Alfadhli.
  * Description of change:fixed bugs added area for start date 
  ********************************************************************************************/

	include ("includes/Header.php");
	include ("includes/ValidationHelper.php");
	require ('../DbConnector.php');
	$page_title = 'Edit Announcements';
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		//$err Sets up Error msg array.
		$err = array();
		//it checks if a text box has a value, if it is not display an error message
		if (empty($_POST['id'])) {
			$err[] = 'You forgot to enter an announcement.';
		} else {
			$announcementId = mysqli_real_escape_string($dbc, trim($_POST['id']));
			}
		if (empty($_POST['title'])) {
			$err[] = 'You forgot to put a title for the announcement.';
		} else {
			$title = mysqli_real_escape_string($dbc, trim($_POST['title']));
			}
		if (empty($_POST['announcement'])) {
			$err[] = 'You forgot to enter an announcement.';
		} else {
			$announcement = mysqli_real_escape_string($dbc, trim($_POST['announcement']));
			}
		if (empty($_POST['type'])) {
			$err[] = 'You forgot to select an announcement type.';
		} elseif (($_POST['type']) == 'Private') {
			$type = mysqli_real_escape_string($dbc, 1);
		} else {
			// All visitors
			$type = mysqli_real_escape_string($dbc, 2);
		}
		
		//Check if the a date has a value and it is in a correct format.
		if (empty($_POST['startDate'])) {
			$err[] = 'You forgot to enter a date that the announcement can begin.';
		} elseif (!preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/", ($_POST['startDate']))) {
			$err[] = 'You did not enter the date in the YYYY-MM-DD format..';
		} elseif (!isDate($_POST['startDate'])) {
			$err[] = 'You did not enter a valid date.';
		} else {
			$startDate = mysqli_real_escape_string($dbc, trim($_POST['startDate']));
		}
		
		if (empty($_POST['endDate'])) {
				$err[] = 'You forgot to enter a date that the announcement expires.';
			} elseif (!preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/", ($_POST['endDate']))) {
				$err[] = 'You did not enter the date in the YYYY-MM-DD format..';
			} elseif (!isDate($_POST['endDate'])) {
				$err[] = 'You did not enter a valid date.';
			} else {
				$date = new DateTime(mysqli_real_escape_string($dbc, trim($_POST['endDate'])));
				$start = new DateTime(mysqli_real_escape_string($dbc, trim($_POST['startDate'])));
				if($date < $start) {
					$err[] = 'End date cannot be before start date.';
				} else {
					$endDate = mysqli_real_escape_string($dbc, trim($_POST['endDate']));
				}
			}
			
		// If there is no error, run the query and display a message.
		if(empty($err)) {
			$query = "UPDATE announcements SET Subject='$title', Body='$announcement', StartDate='$startDate',
			 Type='$type', EndDate='$endDate' WHERE AnnouncementId = $announcementId;";
			$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
			// if the query did not run, tell the user about the error.
			If (!$run)
			{
				echo 'There was an error when creating the announcement. Please try again!';
			} else {
				echo "Thank you for Updating your Announcement!";
			}
		} else {
				//List each Error msg that is stored in the array.
				Foreach($err as $m)
				{
					echo " $m <br />";
				} echo "Please correct the errors.";
			
			}	
		}

		// This block is to get id value from edit link and when we hit submit it will post it in the board 
		// This code was inspired by Wiiliam
		If (isset($_GET['id']) ) {
			$announcementId = $_GET['id'];
		} Else {
			$announcementId = $_POST['id'];
		}
	
		// It was written by Mark.	
		$announcementQuery = "SELECT AnnouncementId, Subject, Body, StartDate, Type, EndDate, IsActive FROM announcements WHERE AnnouncementId = $announcementId;";
		$selectQuery = @mysqli_query($dbc, $announcementQuery);	
		$headerCounter = mysqli_num_fields($selectQuery);
		$row = mysqli_fetch_array($selectQuery, MYSQLI_NUM);
		
		//The following variable is to set the starting column from our query array $row.
		$a = 1;
		//this code was inspired by Wiiliam
		// The previous variable is increased in value to assign the appropriate values from our query array to each variable.
		$title = "{$row[$a]}";
		$body = "{$row[$a+1]}";
		$startDate = "{$row[$a+2]}";
		$type = "{$row[$a+3]}";
		$endDate = "{$row[$a+4]}";
		
		
?>
			
	<!--Takes information to create a new announcement in the db.-->
	<h1>Edit Announcement</h1>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="editannouncement" method="post">
			<fieldset>
				<input type="hidden" value="<?php if (isset($announcementId)) echo $announcementId; ?>" name="id" />
			  	<p>Who will view this Announcement?:
					<select name="type">
						<option <?php if(isset($_POST['type'])=="Public") echo'selected="selected"'; ?>    value="Public">Public</option>
						<option <?php if(isset($_POST['type'])=="Private") echo'selected="selected"'; ?>    value="Private">Private</option>
					</select>
				</p>	
				<p>Title: <input type="text" name="title" size="15" maxlength="50" value="<?php echo $title; ?>" </input></p>
				<p>Announcement: <br/><textarea name="announcement" style="width:250px;height:150px;" value=""><?php echo $body;?></textarea><br />
				<p>Start Date(YYYY-MM-DD): <input type="text" name="startDate" size="10" maxlength="10" value="<?php if (isset($_POST['startDate'])) echo $_POST['startDate']; ?>" /></p>
				<p>End Date(YYYY-MM-DD): <input type="text" name="endDate" size="10" maxlength="10" value="<?php if (isset($_POST['endDate'])) echo $_POST['endDate']; ?>" /></p>
				<p><input type="submit" value="Submit" /></p>
			</fieldset>
		</form>
<?php
	include ("includes/Footer.php");
?>	
	
	