<?php
/*********************************************************************************************
 * Original Author:Meredith Purk
 * Date of origination: 04/13/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: To show a list of users, and allow the editor to update/verify the Society for Case Research (SCR) Membership numbers
 * Credit: Borrows code from Shane and Mark
 * Revision 1: 4/18/16
 * 	- Added clearer instructions to the page
 * 	- Added the Update box so that only records with the Update checkbox marked will receive
 * 	an update query (rather than updating all user records in the database)
 * Revision 2: 4/20/16
 * 	- Removed unnecessary horizontal rules (<hr> tags) as they conflicted with the table borders
 * 	declared in CSS
 * 	- Added an ORDER BY clause to the SELECT query to order users by last name
 * 	- Moved hidden INPUT to a column on the row above, instead of its own row
 * 	- Adjusted rowspan and inline borders on the table
 * 	- Added class to submit button
 * Revision 3: 4/27/16
 * 	- Changed Textarea control for SCR code to a textbox
 * 	- Added session check to ensure that only users logged in as Editors can access this page
 * 	- Removed the unnecessary include for TableRowHelper.php because those functions weren't
 * 		being used in this file any more
 ********************************************************************************************/
	include ("includes/Header.php");

session_start();
	
if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor')
	{ // Check the session data to ensure we are logged in as an Editor
	require('../DbConnector.php');
	$page_title = 'Validate SCR Membership';
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
		{
			// We are updating fields on the form, so we want to run those update queries now. That way,
			// when we get to the main query, it will pull in the updated version of the tables after
			// saving current changes
			updateSCRRecords($dbc);
		}
	
	// Query all records in the users table to pull in a full list. In the future, we could ad code to do a sort or search to limit records
	$authorQuery = "SELECT UserId AS authUserId, FName AS authFirstName, LName AS authLastName, Email AS authEmail, MemberCode AS authSCRNumber, VerifiedMemberCode AS SCRBeenVerified FROM users ORDER BY authLastName ASC;"; 
	$selectQuery = @mysqli_query($dbc, $authorQuery); // Pull in the user list
	
	$userCount = 0; // Start a counter to keep track of our iteration and set up our arrays
	$tableBody = "";	
	
	echo("<p>Use this form to compare and verify SCR Membership Codes. Empty or incorrect codes can be corrected.<p>To update a record, enter the correct SCR Membership Code in the box, check the verified Membership code as necessary, and check the Update box for each user being updated. Then click on the Save Changes button at the bottom of the screen.");
	
	while ($row = mysqli_fetch_array($selectQuery)) // Pull in our rows, one at a time
		{
		$currentAuthorSCR[$userCount] = $row['authSCRNumber']; // Pull their current SCR Membership Code from the DB, if any
		$membershipCodeValidated[$userCount] = $row['SCRBeenVerified']; // pull the value of the been verified field.
		if ($membershipCodeValidated[$userCount] == NULL)
			$membershipCodeValidated[$userCount] == FALSE; // This is supposed to be stored as a boolean, currently a 'null' is the same as a false
		if ($membershipCodeValidated[$userCount] == TRUE)
			$checkBoxState = " checked = 'checked'"; // A checked box reflects a 'true' boolean value
		else
			$checkBoxState = ""; // an empty/false field should equate to an un-checked box		
		
		// Based on the code from the TableRowHelper.php file with a lot of tweaks by Meredith Purk		
		$tableBody = $tableBody . "<tr>"; // Our first row: This will hold the author information
		$tableBody = $tableBody . "<td style='border-bottom: none'>{$row['authLastName']}, {$row['authFirstName']}</td><td style='border-bottom: none'>{$row['authEmail']}</td><td style='border-bottom: none' rowspan='2'><input type='checkbox' name='saveChangesBox{$userCount}'>Update</input></td></tr>";
	
		// Skip to our next row, which will be the SCR Field and Verified Checkbox
		$tableBody = $tableBody . "<tr><td><input type='text' value='{$currentAuthorSCR[$userCount]}' maxLength=15 name='textBox{$userCount}'></input></td>"; // SCR Textbox
		$tableBody = $tableBody . "<td><input type='checkbox' name='verifiedSCRBox{$userCount}'{$checkBoxState}>Verified Membership Code</input>"; // Verified Checkbox Control
		$tableBody = $tableBody . "<input type='hidden' name='authUserId{$userCount}' value='{$row['authUserId']}'> </input></td></tr>"; // Hidden input box lets us keep track of our userID
		$userCount++; // increment our count for the next iteration
	}
	
	// Once we've iterated through all rows in our user table, create a Save Changes Button/submit button for the form
	$tableBody = $tableBody . "<tr><td style='border-bottom: none'><input type='submit' Value='Save Changes' class='button1'></input</td></tr><tr><td style='border-bottom: none'>Save changes made on this form and update the database.</td></tr>";
	
	}
else
	{ // If we are not logged in as an Editor, redirect us to the index page
	header('Location: Index.php');
	exit;
	}	
	
	function updateSCRRecords($dbc)
	{
	//echo("<p>Running Update Records"); // Debug string
	$updatesMade = 0; //This will keep track of the number of records updated by the query below
	$counter = 0;
	while (!empty($_POST['authUserId' .  $counter]))
		{
		if (!empty($_POST['saveChangesBox' . $counter])) 
			{ // We only want to do this if the saveChanges checkbox was ticked
			$currUserId = $_POST['authUserId' . $counter];
			$newSCRCode = $_POST['textBox' . $counter];
			if (empty($_POST['verifiedSCRBox' . $counter]))
				{
				$verifiedSCR = FALSE;
				}
			else
				{
				$verifiedSCR = TRUE;
				}
		
			//Run the update query
			$updateQuery = "UPDATE users SET MemberCode='$newSCRCode', VerifiedMemberCode='$verifiedSCR' WHERE userId='$currUserId';";
			// echo($updateQuery); // Debug string

			$run = @mysqli_query($dbc, $updateQuery)or die("Errors are ".mysqli_error($dbc));
			If (!$run)
				echo 'There was an error when updating the records for ' . $newSCRCode . '. Please try again!';
			else
				$updatesMade++; // Increment number of successful updates
			}
		$counter++; // increment our counter for the next loop
		}
	if ($updatesMade > 0)
		echo 'Successfully updated ' . $updatesMade . ' records(s).';
	}
	
?>



	<h1>SCR Membership Code Verification</h1>
	<div id = 'SCRMembershipViewer'>
		<form method='post'>
		<table>
			<tr>
				<th>Last Name, First Name</th>
				<th>Email Address</th>
			</tr>
			<?php echo $tableBody; ?>
		</table>
		</form>
	</div>
	
<?php
	include('includes/Footer.php');
?>
