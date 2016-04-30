<?php
/*********************************************************************************************
 * Original Author:Meredith Purk
 * Date of origination: 04/09/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: To show the status of an individual Critical Incident/Author/Reviewer(s) on a page, and allow
 * 			the Editor to make changes/update those statuses in the database
 * Credit: Borrows code from Shane and Mark
 * 		References the W3 MYSQL resource
 * 		Took some advice from Bohemian (http://stackoverflow.com/questions/7506750/multiple-group-concat-on-different-fields-using-mysql) who
 * 			pointed out that you need to use joins and not just the DISTINCT keyword to avoid duplicates in the GROUP_CONCAT strings 
 * 		John Giotta demonstrated how to explode values from a comma separated string into a list of variables. I used that to research exploding
 * 			a comma-separated string into an array instead
 * 			(http://stackoverflow.com/questions/5597236/how-to-get-comma-seperated-values-from-the-string-in-php)
 * * Revision 1: 4/28/16
 * 		- This document will not be updated any more
 * 
 * ---------------------------------
 * THIS CODE WAS NOT IMPLEMENTED AND IS INCOMPLETE
 ********************************************************************************************/
include ("includes/Header.php");
include("includes/TableRowHelper.php");
session_start();
	
if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor')
	{
	require('../DbConnector.php');
	$page_title = 'Edit Status';
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
		{
		//Set up Error msg array.
		$err = array();
		
		//Check if the first name text box has a value.
		if (empty($_POST['id']))
			{
			$err[] = 'No valid Critical Incident ID Found';
			}
		else
			{
			$CI_Id = mysqli_real_escape_string($dbc, trim($_POST['id']));
			}
		//print_r($_POST); // Debug string for the array of values
		updateCIStatus($dbc); // This will cycle through and run update queries for our data
		}
	// it will get id value from edit link and when we hit submit it will post it in the board 
		// this code was inspired by Wiiliam
		//Value of a variable
		If (isset($_GET['id']) ) {
			$CI_Id = $_GET['id'];
		} Else {
			$CI_Id = $_POST['id'];
		}
	// Here is where we will need to set up our forms. We're going to have a List Box for the status of each item (The Critical Incident,
		// the Author, and any Reviewer(s). The default value should be set to what we pull from the database as the current status.
		// There will be a textbox next to that which will hold the current statusDate value.
		
		// Updating the status of these will be done by having the Editor change the values, and press the SAVE button at the bottom of the form.
		// Anything that has changed will be sent to the database in an Update Query)

	// Written by Meredith Purk, used references from the W3 resource on GROUP_CONCAT and a LOT of trial and error runs in the MYSQL Admin
	// (http://www.w3resource.com/mysql/aggregate-functions-and-grouping/aggregate-functions-and-grouping-group_concat.php)
	$critincQuery = "SELECT Title AS CI_Title, c.status AS CI_Status, c.statusDate AS CI_Date,
					a.UserId AS Auth_Id, a.status AS Auth_Status, a.statusDate AS Auth_Date, GROUP_CONCAT(r.ReviewerId) AS Revwr_Id,
					GROUP_CONCAT(r.status) AS Revwr_Status, GROUP_CONCAT(r.statusDate) AS Revwr_Date FROM criticalincidents c
					LEFT JOIN authorcases a ON c.CriticalIncidentId = a.CriticalIncidentId
					LEFT JOIN reviewcis r ON c.CriticalIncidentId = r.CriticalIncidentId WHERE c.CriticalIncidentId = $CI_Id GROUP BY c.CriticalIncidentId;";
	/* The query above pulls the CI ID, Title, Status and Status Date from the DB, and author ID, Status and Date,
	 * and then groups the reviewer ID, Status, and Date (if any) into concantonated strings */					
	
	//$critincIdQuery = "SELECT CriticalIncidentId FROM criticalincidents WHERE CriticalIncidentId = $CI_Id;";
	
	// Written by Shane Workman.
	$selectQuery = @mysqli_query($dbc, $critincQuery); // This is used to create a simple list of the Critical Incident IDs
	//$idSelectQuery = @mysqli_query($dbc, $critincIdQuery);
	
	$headerCounter = 3; // Hard coding this rather than basing it off the number of fields in the query, because we will be nesting the results,
	// not printing it as one long table row

	// Based on the code from the TableRowHelper.php file with a lot of tweaks by Meredith Purk
	$tableBody = '';
	// This block will retrieve an array from the database, which will be used to assign values
	// to an HTML table.
	$row = @mysqli_fetch_array($selectQuery);
	$tableBody = $tableBody . "<tr>"; // Our first row: This is going to be the Critical Incident Row			 
		
	// Clear our Select values for our status listbox
	$selectValue0 = "";
	$selectValue1 = "";
	$selectValue2 = "";
	$selectValue3 = "";
		
	switch ($row['CI_Status'])
		{ // Since the value of status is stored as an integar, we want to display a textual representation of it
		case 0: $selectValue0 = " selected='selected'"; break;
		case 1: $selectValue1 = " selected='selected'"; break;
		case 2: $selectValue2 = " selected='selected'"; break;
		case 3: $selectValue3 = " selected='selected'"; break;
		}
		
	// Enter our case result into a listbox
	$tableBody = $tableBody . "<td><input type='hidden' name='CIId' value='{$CI_Id}'> </input>{$row['CI_Title']}</td><td> &nbsp &nbsp &nbsp &nbsp &nbsp <select name='CIStatusBox'><option value=0{$selectValue0}>Initial Submission</option>
										<option value=1{$selectValue1}>Review Round One</option>
										<option value=2{$selectValue2}>Review Round Two</option>
										<option value=3{$selectValue3}>Final Reviews</option></select></td>";													
	$tableBody = $tableBody . "<td><input type='text' size='35' maxLength='10' name='CIDateBox' value='{$row['CI_Date']}'></td>";
											
	// End our CI row, start our Author Row
	$tableBody = $tableBody . "</tr><tr><td style='border-bottom: none'>&nbsp</td><td style='border-bottom: none'><br>
								<table><tr><th>Author ID</th><th>Current Status</th><th>Last Status Date</th><tr>";
	//This is our Author Row, and we'll be nesting a new table here (indented by means of a non-breaking space)
	$tableBody = $tableBody . "<td><input type='hidden' name='authId' value='{$row['Auth_Id']}'> </input>{$row['Auth_Id']}</td>";
								
	// Clear our Select values for our listbox
	$selectValue0 = "";
	$selectValue1 = "";
	$selectValue2 = "";
	$selectValue3 = "";
			
	switch ($row['Auth_Status'])
		{ // Since the value of 'status' is stored as an integar, we want to display a textual representation of it
		case 0: $selectValue0 = " selected='selected'"; break;
   		case 1: $selectValue1 = " selected='selected'"; break;
		case 2: $selectValue2 = " selected='selected'"; break;
		case 3: $selectValue3 = " selected='selected'"; break;
		}
	$tableBody = $tableBody . "<td><select name='authStatusBox'><option value=0{$selectValue0}>Initial Submission Received</option>
										<option value=1{$selectValue1}>Revisions Pending</option>
										<option value=2{$selectValue2}>Revisions Received</option>
										<option value=3{$selectValue3}>Revisions Overdue</option></select></td><td><input type='text' size='35' maxLength=10 name='authDateBox' value='{$row['Auth_Date']}'></input></td>";
		
	$tableBody = $tableBody . "</tr></table></td></tr>";
	// Next is Reviewer Row. We may have different amounts of reviewers for
	// each Critical Incident (or even a NULL/empty value if no reviewers have been assigned yet)
	// so these values are returned as concantonated strings, separated by commas
			
	if ($row['Revwr_Id'] == '')
		{ // If Reviewer ID is blank, it means we have no reviewers assigned
		$tableBody = $tableBody . "<tr><td style='border-bottom: none'>&nbsp</td><td style='border-bottom: none'><br><table><tr><td>No Reviewers Assigned</td></tr></table><br></td>";					
		}
	else
		{ 	// Explode all our GROUP_CONCAT strings into arrays so we can cycle through them
		$RevwrId = explode(',', $row['Revwr_Id']); // Inspired by John Giotta
		$RevwrStatus = explode(',', $row['Revwr_Status']); 
		$RevwrDate = explode(',', $row['Revwr_Date']);
		
		$tableBody = $tableBody . "<tr><td>&nbsp</td><td><br><table><tr><th>Reviewer ID</th><th>Current Status</th><th>Last Status Date</th>"; // Start the new, nested table for reviewer info
		for ($a = 0; $a < count($RevwrId); $a++)
			{ // Cycle through our array of reviewers
			$tableBody = $tableBody . "</tr><tr><td><input type='hidden' name='reviewId{$a}' value='{$RevwrId[$a]}'> </input>{$RevwrId[$a]}</td>"; // We'll close the previous row/start a new one each iteration
				
			// Clear our Select values for our listbox
			$selectValue0 = "";
			$selectValue1 = "";
			$selectValue2 = "";
			$selectValue3 = "";
				
			switch ($RevwrStatus[$a])
				{ // Since the value of 'status' is stored as an integar, we want to display a textual representation of it
				case 0: $selectValue0 = " selected='selected'"; break;
   				case 1: $selectValue1 = " selected='selected'"; break;
				case 2: $selectValue2 = " selected='selected'"; break;
				case 3: $selectValue3 = " selected='selected'"; break;
				}
			$tableBody = $tableBody . "<td><select name='reviewStatusBox{$a}'><option value=0{$selectValue0}>No Documents to Review<</option>
												<option value=1{$selectValue1}>Review Pending</option>
												<option value=2{$selectValue2}>Review Received</option>
												<option value=3{$selectValue3}>Review Overdue</option></select></td><td><input type='text' size='35' maxLength=10 name='reviewDateBox{$a}' value='{$RevwrDate[$a]}'></input></td>"; 
			}
	
		$tableBody = $tableBody . "</table><br></td>"; // Close the reviewer sub-table
		}
		// Now that we are done with the reviewer section, let's close up the table and add our submit/save button
		$tableBody = $tableBody . "</tr><tr><td style='border-bottom: none'>&nbsp</td><td style='border-bottom: none'><input type='submit' Value='Save Changes' class='button2'></input></td></tr></table>";
	}
else
	{
		header('Location: http://br-t1-jci.sfcrjci.org/Index.php');
		exit; // Exit to the home page if we aren't signed in as an Editor
	}			
		
	function updateCIStatus($dbc)
	{ // This will run through the contents of the boxes/dropdown lists and perform update queries to the DB
	$counter = 0; // This is used for the reviewers section, in case we need to cycle through multiple
	
	$updatesMade = 0; //This will keep track of the number of records updated by the query below
		
	$updateCIId = ($_POST['CIId']); // CI ID
	$updateCIStatus = ($_POST['CIStatusBox']); // New CI Status
	$updateCIDate = ($_POST['CIDateBox']); // New CI Date
	
	// Create/run the update Critical Incident Status query
	$updateQuery = "UPDATE criticalincidents SET status='$updateCIStatus', statusDate='$updateCIDate' WHERE CriticalIncidentId='$updateCIId';";
	$run = @mysqli_query($dbc, $updateQuery)or die("Errors are ".mysqli_error($dbc));
	if (!$run)
		echo 'There was an error when updating the Critical Incident Status records. Please try again!';
	else
		$updatesMade++; // Increment number of successful updates
				
	$updateAuthId = ($_POST['authId']); // Author ID
	$updateAuthStatus = ($_POST['authStatusBox']); // New Author Status
	$updateAuthDate = ($_POST['authDateBox']); // New Author Date
	
	// Create/run the update author status query - remember to pass the CIId in the update WHERE so we update the correct author+CI records
	$updateQuery = "UPDATE authorcases SET status='$updateAuthStatus', statusDate='$updateAuthDate' WHERE UserId='$updateAuthId' AND CriticalIncidentId='$updateCIId';";
	$run = @mysqli_query($dbc, $updateQuery)or die("Errors are ".mysqli_error($dbc));
	if (!$run)
		echo 'There was an error when updating the Author Status records. Please try again!';
	else
		$updatesMade++; // Increment number of successful updates
			
	while (!empty($_POST['reviewId' . $counter])) // Cycle through each of the Reviewers
		{
		$updateReviewId = ($_POST['reviewId' . $counter]); // ReviewerID
		$updateReviewStatus = ($_POST['reviewStatusBox' . $counter]); // New Reviewer Status
		$updateReviewDate = ($_POST['reviewDateBox' . $counter]); // New Reviewer Date
		
		// Create and run the Reviewer Status query - remember to pass the CIId in the update WHERE so we update the correct reviewer+CI records
		$updateQuery = "UPDATE reviewcis SET status='$updateReviewStatus', statusDate='$updateReviewDate' WHERE ReviewerId='$updateReviewId' AND CriticalIncidentId='$updateCIId';";
		$run = @mysqli_query($dbc, $updateQuery)or die("Errors are ".mysqli_error($dbc));
		if (!$run)
			echo 'There was an error when updating the Reviewer Status records. Please try again!';
		else
			$updatesMade++; // Increment number of successful updates
		
		$counter++; // increment our counter for the next loop
		}
	if ($updatesMade > 0)
		echo 'Successfully updated ' . $updatesMade . ' records(s).';
	}
	
?>

	<h1>Critical Incidents Status</h1>
	<div id = 'ciStatusViewer'>
		<form method='post'>
		<table>
			<tr>
				<th>C.I. Title</th>
        		<th>Current Status</th>
        		<th>Last Status Date</th>
			</tr>
			<?php echo $tableBody; ?>
		</table>
		</form>
	</div>
	
<?php
	include('includes/Footer.php');
?>