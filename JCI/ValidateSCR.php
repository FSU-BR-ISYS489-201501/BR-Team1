<?php
/*********************************************************************************************
 * Original Author:Meredith Purk
 * Date of origination: 04/13/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: To show a list of users, and allow the editor to update/verify the Society for Case Research (SCR) Membership numbers
 * Credit: Borrows code from Shane and Mark
 ********************************************************************************************/
	include ("includes/Header.php");
	include("includes/TableRowHelper.php");
	require ('../DbConnector.php');
	$page_title = 'Validate SCR Membership';
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
		{
			// We are updating fields on the form, so we want to run those update queries now. That way,
			// when we get to the main query, it will pull in the updated version of the tables after
			// saving current changes
			updateSCRRecords($dbc);
		}
	
	// Query all records in the users table to pull in a full list. In the future, we could ad code to do a sort or search to limit records
	
	$authorQuery = "SELECT UserId AS authUserId, FName AS authFirstName, LName AS authLastName, Email AS authEmail, MemberCode AS authSCRNumber, VerifiedMemberCode AS SCRBeenVerified FROM users;"; 
	$selectQuery = @mysqli_query($dbc, $authorQuery); // Pull in the user list
	
	$userCount = 0; // Start a counter to keep track of our iteration and set up our arrays
	$tableBody = "";	
	
	echo("<p>Use this form to compare and verify SCR Membership Codes. Empty or incorrect codes can be corrected.");
	
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
		$tableBody = $tableBody . "<td>{$row['authLastName']}, {$row['authFirstName']}</td><td>{$row['authEmail']}</td></tr>";
	
		// Skip to our next row, which will be the SCR Field and Verified Checkbox
		$tableBody = $tableBody . "<tr><td><textarea cols='20' rows='1' maxLength=15 name='textBox{$userCount}'>{$currentAuthorSCR[$userCount]}</textarea></td>"; // SCR Textbox	
		$tableBody = $tableBody . "<td><input type='checkbox' name='verifiedSCRBox{$userCount}'{$checkBoxState}>Verified Membership Code</input></td></tr>"; // Verified Checkbox Control
		$tableBody = $tableBody . "<tr><td><input type='hidden' name='authUserId{$userCount}' value='{$row['authUserId']}'</input><hr></td><td><hr></td></tr>";
		$userCount++; // increment our count for the next iteration
	}
	
	// Once we've iterated through all rows in our user table, create a Save Changes Button/submit button for the form
	$tableBody = $tableBody . "<tr><td><input type='submit' Value='Save Changes'></input</td></tr><tr><td>Save changes made on this form and update the database.</td></tr>";
	
	//print_r($_POST); // This was a debug to just print the value of the POST array
	
	function updateSCRRecords($dbc)
	{
	//echo("<p>Running Update Records"); // Debug string
	$updatesMade = 0; //This will keep track of the number of records updated by the query below
	$counter = 0;
	while (!empty($_POST['authUserId' .  $counter]))
		{
		$currUserId = $_POST['authUserId' . $counter];
		$newSCRCode = $_POST['textBox' . $counter];
		if (empty($_POST['verifiedSCRBox' . $counter]))
			$verifiedSCR = FALSE;
		else
			$verifiedSCR = TRUE;
		//Run the update query
		$updateQuery = "UPDATE users SET MemberCode='$newSCRCode', VerifiedMemberCode='$verifiedSCR' WHERE userId='$currUserId';";
		// echo($updateQuery); // Debug string
		$counter++; // increment our counter  
		$run = @mysqli_query($dbc, $updateQuery)or die("Errors are ".mysqli_error($dbc));
		If (!$run)
			echo 'There was an error when updating the records for ' . $currUserID . '. Please try again!';
		else
			$updatesMade++; // Increment number of successful updates
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
				<th>eMail Address</th>
			</tr>
			<?php echo $tableBody; ?>
		</table>
		</form>
	</div>
	
<?php
	include('includes/Footer.php');
?>