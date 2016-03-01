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
  *Revision1.1: 32/01/2016 Author: Faisal Alfadhli: edited the sql command
  ********************************************************************************************/

	include ("includes/Header.php");
	require ('../DbConnector.php');
	// value of a variable	
	$getId = $_GET['AnnouncementId'];
	$title = $_POST['Subject']; 
	$body = $_POST['Body'];
	$startDate = $_POST['StartDate'];
	$endDate = $_POST['EndDate'];
	
	// if a user click save button the changes will be updated into announcement table in db.
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		 
		//Set up as an arrary for errors
		$err= array();
		// check if all field has values or not 
		if (empty($_POST['Subject'])) {
			$err[] = 'Failed You did not enter the Subject.';
		}	else {
				$title = mysqli_real_escape_string($dbc, trim($_POST['Subject']));
			}
		
		if (empty($_POST['Body'])) {
			$err[] = 'Failed, You did not typed the body.';
		} 	else {
				$body= mysqli_real_escape_string($dbc, trim($_POST['Body']));
			}
		// stole from Shane announcement code 
		//Check if the first name text box has a value.
		if (empty($_POST['EndDate'])) {
			$err[] = 'You forgot to enter a date that the announcement expires.';
		} elseif (!preg_match("/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/", ($_POST['EndDate']))) {
			$err[] = 'You did not enter the date in the MM/DD/YYYY format..';
		} elseif (!isDate($_POST['EndDate'])) {
			$err[] = 'You did not enter a valid date.';
		} elseif (isset($_POST['EndDate']) < ($_POST['$startDate'])) {
			$err[] = 'The date you enterd passed, please try again.';
		}
		else {
				$endDate = mysqli_real_escape_string($dbc, trim($_POST['EndDate']));
		}
		
		
		if(empty($err)) {
			//Creat the query that dumps info into the DB.
			$update = mysql_query("UPDATE Announcements SET Subject='$title', Body='$body', StartDate='$startDate', EndDate='$endDate' WHERE AnnouncementId='$getid'");
		
			//Run update query
			$run = @mysqli_query($dbc, $update)or die("We could not update, please try again.".mysqli_error($dbc));
			
			// this block is taken from Shane code.
			If (!$run)
			{
				echo 'There was an error when updating the announcement. Please try again!';
			}else {
				echo "Update is done!";
			}
		}else {
			//List each Error msg that is stored in the array.
			Foreach($err as $m)
			{
				echo " $m <br />";
			} echo "Please correct the errors.";
		
		}	
	}


	include ("includes/Footer.php");
?>	
	
	