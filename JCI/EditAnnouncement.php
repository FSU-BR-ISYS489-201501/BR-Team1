<?php
/*********************************************************************************************
  * Original Author: Faisal Alfadhli
  * Date of origination: 02/22/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: this page is used for making changes in announcement when an editors click on edit button from manage announcement page
  *Credits: www.W3schools.com
  * www.php.net
  *Revision1.1: 03/01/2016 Author: Faisal Alfadhli: edited the sql command
  *Revision1.2: 03/11/2016 Author: Faisal Alfadhli: edited tables names 
  *Revision1.3: 03/12/2016 Author: Faisal Alfadhli: fixed bugs and made it functional 
  ********************************************************************************************/

	include ("includes/Header.php");
	include ("includes/ValidationHelper.php");
	require ('../DbConnector.php');
	$page_title = 'Edit Announcements';
	
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
		if (empty($_POST['id'])) {
			$err[] = 'You forgot to enter an announcement.';
		} else {
			$announcementId = mysqli_real_escape_string($dbc, trim($_POST['id']));
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
			} elseif (!isDate($_POST['endDate'])) {
				$err[] = 'You did not enter a valid date.';
			} else {
					$endDate = mysqli_real_escape_string($dbc, trim($_POST['endDate']));
			}

		//Check to see if any errors exist in the validation array.
		if(empty($err)) {
			//Creat the query that dumps info into the DB.
			$query = "UPDATE announcements SET Subject='$title', Body='$announcement', EndDate='$endDate' WHERE AnnouncementId = $announcementId;";
					
			//Run the query...
			$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
			
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
	// it will get id value from edit link and when we hit sibmit it will post it in the board 
	// this code was inspired by Wiiliam
	//Value of a variable
	If (isset($_GET['id']) ) {
		$announcementId = $_GET['id'];
	} Else {
		$announcementId = $_POST['id'];
	}
    	
	$announcementQuery = "SELECT AnnouncementId, Subject, Body, StartDate, Type, EndDate, IsActive FROM announcements WHERE AnnouncementId = $announcementId;";
	$selectQuery = @mysqli_query($dbc, $announcementQuery);	
	$headerCounter = mysqli_num_fields($selectQuery);
	$row = mysqli_fetch_array($selectQuery, MYSQLI_NUM);
	//The following variable set the starting column from our query array $row.
    $a = 1;
	//this code was inspired by Wiiliam
	//The previous variable is increased in value to assign the appropriate values from our query array to each variable.
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
		  <select name="board">
			<option <?php if(isset($type)=="Public") echo'selected="selected"'; ?>    value="Public">Public</option>
			<option <?php if(isset($type)=="Private") echo'selected="selected"'; ?>    value="Private">Private</option>
		  </select></p>	
		  <p>Title: <input type="text" name="title" size="15" maxlength="50" value="<?php echo $title; ?>" </input></p>
		  <p>Announcement: <br/><textarea name="announcement" style="width:250px;height:150px;" value=""><?php echo $body;?></textarea><br />
		  <p>End Date(MM/DD/YYYY): <input type="text" name="endDate" size="10" maxlength="10" value="<?php echo $endDate; ?>" /></p>
		  <p><input type="submit" value="Submit" /></p>
	    </fieldset>
     </form>
   <?php
	include ("includes/Footer.php");
?>	
	
	