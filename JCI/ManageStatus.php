<?php
/*********************************************************************************************
 * Original Author:Meredith Purk
 * Date of origination: 04/05/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: To show a list of critical incidents, and their author and assigned reviewers,
 * to show their current status and provide a link for the Editor to edit that status.
 * Credit: Borrows code from Shane and Mark
 * 		References the W3 MYSQL resource
 * 		Took some advice from Bohemian (http://stackoverflow.com/questions/7506750/multiple-group-concat-on-different-fields-using-mysql) who
 * 			pointed out that you need to use joins and not just the DISTINCT keyword to avoid duplicates in the GROUP_CONCAT strings 
 * 		John Giotta demonstrated how to explode values from a comma separated string into a list of variables. I used that to research exploding
 * 			a comma-separated string into an array instead
 * 			(http://stackoverflow.com/questions/5597236/how-to-get-comma-seperated-values-from-the-string-in-php)
 * Revision 1: 4/28/16
 * 		- This document will not be updated any more
 * 
 * ---------------------------------
 * THIS CODE WAS NOT IMPLEMENTED AND IS INCOMPLETE
 ********************************************************************************************/
	include('includes/Header.php');
	include('includes/TableRowHelper.php');
	require('../DbConnector.php');
	
	// Written by Meredith Purk, used references from the W3 resource on GROUP_CONCAT and a LOT of trial and error runs in the MYSQL Admin
	// (http://www.w3resource.com/mysql/aggregate-functions-and-grouping/aggregate-functions-and-grouping-group_concat.php)
	$critincQuery = "SELECT c.CriticalIncidentId AS CI_Id, Title AS CI_Title, c.status AS CI_Status, c.statusDate AS CI_Date,
					a.UserId AS Auth_Id, a.status AS Auth_Status, a.statusDate AS Auth_Date, GROUP_CONCAT(r.ReviewerId) AS Revwr_Id,
					GROUP_CONCAT(r.status) AS Revwr_Status, GROUP_CONCAT(r.statusDate) AS Revwr_Date FROM criticalincidents c
					LEFT JOIN authorcases a ON c.CriticalIncidentId = a.CriticalIncidentId
					LEFT JOIN reviewcis r ON c.CriticalIncidentId = r.CriticalIncidentId GROUP BY c.CriticalIncidentId;";
	/* The query above pulls the CI ID, Title, Status and Status Date from the DB, and author ID, Status and Date,
	 * and then groups the reviewer ID, Status, and Date (if any) into concantonated strings */					
	
	$critincIdQuery = "SELECT CriticalIncidentId FROM criticalincidents;";
	
	// Written by Shane Workman.
	$selectQuery = @mysqli_query($dbc, $critincQuery); // This is used to create a simple list of the Critical Incident IDs
	$idSelectQuery = @mysqli_query($dbc, $critincIdQuery);
	
	// Declare our variables for the edit buttons that will be on
	$pageNames = array('EditStatus.php');
	$variableNames = array('id');
	$titles = array('Edit Status');
	
	$editButton = tableRowLinkGenerator($idSelectQuery, $pageNames, $variableNames, $titles);
	$editButtonID = 0;

	$headerCounter = 4; // Hard coding this rather than basing it off the number of fields in the query, because we will be nesting the results,
	// not printing it as one long table row

	// Based on the code from the TableRowHelper.php file with a lot of tweaks by Meredith Purk
	$tableBody = '';
	// This block will retrieve an array from the database, which will be used to assign values
	// to an HTML table.
	while ($row = mysqli_fetch_array($selectQuery))
		{/* Here is where we'll start pulling a row of values from the result set as an array. Cheat-sheet of fields below
		 * 0 = CI_Id, 1 = CI_Title, 2 = CI_Status, 3 = CI_Date, 4 = Auth_Id
		 * 5 = Auth_Status, 6 = Auth_Date, 7 = Revwr_Id, 8 = Revwr_Status, 9 = Revwr_Date */
			
		$tableBody = $tableBody . "<tr>"; // Our first row: This is going to be the Critical Incident Row			 
		
		// We used to use a 'for' loop to just go through each value in the array, but let's scrap that since
		// we can also pull each value from the row by column name as well. Also better for readabiliy, and doesn't
		// require us to pull the values in the same order in which we queried them
		$tableBody = $tableBody . "<td>{$row['CI_Title']}</td>";
		
		switch ($row['CI_Status'])
			{ // Since the value of status is stored as an integar, we want to display a textual representation of it
   			case 0: $tableBody = $tableBody . "<td>Initial Submission</td>"; break;
   			case 1: $tableBody = $tableBody . "<td>Review Round One</td>"; break;
			case 2: $tableBody = $tableBody . "<td>Review Round Two</td>"; break;
			case 3: $tableBody = $tableBody . "<td>Final Reviews</td>"; break;
			}										
		$tableBody = $tableBody . "<td>{$row['CI_Date']}";
		// Add our edit button to the row
		$tableBody = $tableBody . "{$editButton[$editButtonID]}</td>";
		$editButtonID++; // Increment our button counter array		
											

		$tableBody = $tableBody . "</tr><tr><td style='border-bottom: none'>&nbsp</td><td style='border-bottom: none'><br>
									<table><tr><th>Author ID</th><th>Current Status</th><th>Last Status Date</th><tr>";
							//This is our Author Row, and we'll be nesting a new table here (indented by means of a non-breaking space)
		$tableBody = $tableBody . "<td>{$row['Auth_Id']}</td>";
									
		switch ($row['Auth_Status'])
			{ // Since the value of 'status' is stored as an integar, we want to display a textual representation of it
			case 0: $tableBody = $tableBody . "<td>Initial Submission Received</td>"; break;
   			case 1: $tableBody = $tableBody . "<td>Revisions Pending</td>"; break;
			case 2: $tableBody = $tableBody . "<td>Revisions Received</td>"; break;
			case 3: $tableBody = $tableBody . "<td>Revisions Overdue</td>"; break;
			}
		$tableBody = $tableBody . "<td>{$row['Auth_Date']}</td>";

		$tableBody = $tableBody . "</tr></table></td></tr>";// Next is Reviewer Row. We may have different amounts of reviewers for
		// each Critical Incident (or even a NULL/empty value if no reviewers have been assigned yet) so these values are returned as
		// concantonated strings, separated by commas
			
		if ($row['Revwr_Id'] == '')
			{ // If Reviewer ID is blank, it means we have no reviewers assigned
			$tableBody = $tableBody . "<tr><td style='border-bottom: none'>&nbsp</td><td style='border-bottom: none'><br><table><tr><td>No Reviewers Assigned</td></tr></table><br></td>";					
			}
		else
			{ 	// Explode all our GROUP_CONCAT strings into arrays so we can cycle through them
			$RevwrId = explode(',', $row['Revwr_Id']); // Inspired by John Giotta
			$RevwrStatus = explode(',', $row['Revwr_Status']); 
			$RevwrDate = explode(',', $row['Revwr_Date']);
			
			$tableBody = $tableBody . "<tr><td style='border-bottom: none'>&nbsp</td><td style='border-bottom: none'><br><table><tr><th>Reviewer ID</th><th>Current Status</th><th>Last Status Date</th>"; // Start the new, nested table for reviewer info
			for ($a = 0; $a < count($RevwrId); $a++)
				{ // Hey, look, it's that 'for' loop we eliminated earlier. ;)
				$tableBody = $tableBody . "</tr><tr><td>{$RevwrId[$a]}</td>"; // We'll close the previous row/start a new one each iteration
				switch ($RevwrStatus[$a])
					{ // Since the value of 'status' is stored as an integar, we want to display a textual representation of it
   					case 0: $tableBody = $tableBody . "<td>No Documents to Review</td>"; break;
	   				case 1: $tableBody = $tableBody . "<td>Review Pending</td>"; break;
					case 2: $tableBody = $tableBody . "<td>Review Received</td>"; break;
					case 3: $tableBody = $tableBody . "<td>Review Overdue</td>"; break;							
					}
				$tableBody = $tableBody . "<td>{$RevwrDate[$a]}</td>"; 
				}
			$tableBody = $tableBody . "</table><br></td>";
			}
		$tableBody = $tableBody . "</tr>"; // Close the Row, and go back to the beginning
		}

?>



	<h1>Critical Incidents Status</h1>
	<div id = 'ciStatusViewer'>
		<table>
			<tr>
				<th></th>
				<th>C.I. Title</th>
        		<th>Current Status</th>
        		<th>Last Status Date</th>
			</tr>
			<?php echo $tableBody; ?>
		</table>
	</div>
	
<?php
	include('includes/Footer.php');
?>