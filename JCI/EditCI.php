<?php
/*********************************************************************************************
 * Original Author: Benjamin Brackett
 * Date of origination: 04/14/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: Include a overview of the page: Such as. This is the index.php and will serve as the home page content of the site.\
 * Credit: Give any attributation to code used within, not created by you.
 *
 * Function:  functionName($myVar, $varTwo)
 * Purpose: This is the description of what the function does.
 * Variable: $myVar - Description of variable.
 * Variable: $varTwo - Another description.
 *
 * Function:  functionNameTwo($anotherVar)
 * Purpose: This is the description of what the function does.
 * Variable: $anotherVar - Description of variable. 
 *
 * Revision1.1: MM/DD/YYYY Author: Name Here 
 * Description of change. Also add //Name: comments above your change within the code.
 ********************************************************************************************/
	$page_title = 'EditCriticalIncident';
 	include ("includes/Header.php");
	include ("includes/ValidationHelper.php");
	require ('../DbConnector.php');
	
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
 	{
		//Set up Error msg array.
		$err = array();
		
		//Check for CI Id value.
		if (empty($_POST['CriticalIncidentId'])) {
			$err[] = 'You forgot to enter a Critical Incident.';
		} else {
			$CriticalIncidentId = mysqli_real_escape_string($dbc, trim($_POST['id']));
			}
		
		//Check Keyword value
		if (empty($_POST['CIKeyword'])) {
			$err[] = 'You forgot to enter a Critical Incident.';
		} else {
			$CIKeyword = mysqli_real_escape_string($dbc, trim($_POST['id']));
			}
		
		//Check category value
		if (empty($_POST['Category'])) {
			$err[] = 'You forgot to select.';
		} else {
			$Category = mysqli_real_escape_string($dbc, trim($_POST['id']));
			}
		
		//Check to see if any errors exist in the validation array.
		if(empty($err)) {
			//Creat the query that dumps info into the DB.
			$query = "UPDATE announcements SET Subject='$title', Body='$announcement', StartDate='$startDate', Type='$type', EndDate='$endDate' WHERE AnnouncementId = $announcementId;";
					
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
		// this code was inspired by Wiliam
		//Value of a variable	
		If (isset($_GET['id']) ) {
			$CriticalIncidentId = $_GET['id'];
		} Else {
			$CriticalIncidentId = $_POST['id'];
		}
		
		// from Mark code	
		$editQuery = "SELECT AnnouncementId, Subject, Body, StartDate, Type, EndDate, IsActive FROM announcements WHERE AnnouncementId = $announcementId;";
		$selectQuery = @mysqli_query($dbc, $editQuery);	
		$headerCounter = mysqli_num_fields($selectQuery);
		$row = mysqli_fetch_array($selectQuery, MYSQLI_NUM);
		
		//The following variable set the starting column from our query array $row.
		$a = 1;
		//this code was inspired by Wiiliam
		//The previous variable is increased in value to assign the appropriate values from our query array to each variable.
		$title = "{$row[$a]}";
		$body = "{$row[$a+1]}";
		$type = "{$row[$a+2]}";
		
		//Changing category
		//Get all categories for specific journal drop down
		//Changing keyword text box if the field 
		//Edit all other info about CIs
?>

	<!--Takes information to create a new announcement in the db.-->
	<h1>Edit Critical Incidents</h1>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="editCriticalIncident" method="post">
			<fieldset>
				<input type="hidden" value="<?php if (isset($CriticalIncidentId)) echo $CriticalIncidentId; ?>" name="id" />
			  	<p>Category:
					<!-- Idea from http://www.plus2net.com/php_tutorial/list-table.php -->
						<?php
						$sql="SELECT CriticalIncidentId, CategoryName FROM categorys order by CategoryName"; 
						
						echo "<select name=categorys value=''>Category Name</option>"; // list box select command
						
						/* Option values are added by looping through the array */ 
						foreach ($dbo->query($sql) as $row){//Array or records stored in $row
												
						echo "<option value=$row[CriticalIncidentId]>$row[CategoryName]</option>"; 
												
						}
						
						 echo "</select>";// Closing of list box
						?>
				</p>	
				<p>Title: <input type="text" name="title" size="15" maxlength="50" value="<?php echo $title; ?>" </input></p>
				<p>Keywords: <br/>
				<?php
						$sql="SELECT KeywordId, CIKeyword FROM keywords order by CIKeyword"; 
						
						echo "<select name=CIKeyword value=''>Keywords </option>"; // list box select command
						
						/* Option values are added by looping through the array */ 
						foreach ($dbo->query($sql) as $row){//Array or records stored in $row
						
						<html>						
						<p>Keywords: <textarea name="keywords" style="width:250px;height:150px;" value=""><php echo $body; ?></textarea></p>
												
						}
						
						 echo "</textarea>";// Closing of list box
						?>
				<p><input type="submit" value="Submit" /></p>
			</fieldset>
		</form>		
		
		
		