<?php
 /*********************************************************************************************
  * Original Author: Shane Workman
  * Date of origination: 04/14/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: This page is used to collect user information whom wish to register for the JCI site.
  * Credit: A bulk of this code is derived in some part from code I used and learned in ISYS288.
  *			We used Larry Uldman's PHP book. My own code. http://php.net/ was a resource.
  * 		Some code was taken from other parts within the site.
  ********************************************************************************************/
  $page_title = 'Create Review Board';
  include ("includes/Header.php");
  include('includes/TableRowHelper.php');
  require ('../DbConnector.php'); 
  
	//Got from mark to check the post back.
	if (isset($_GET['boardId'])) {
		$selectId = $_GET['boardId'];
		$deleteQuery = "UPDATE reviewboard SET Active = 0 WHERE boardId = $selectId ;";
		if(@mysqli_query($dbc, $deleteQuery)) {				
			header('Location: ReviewBoardEntry.php');
			//exit;
		} else {
			echo "If you see this message, please tell web admin! Thank you.";
			
		}
	}
 // Checks to see if the page is posting.
 if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
	$err = array();
	// Make sure there is a First name entered.
	if (empty($_POST['fName'])) {
			$err[]= "You didn't enter the persons First Name!";
		} else {
			$fName = mysqli_real_escape_string($dbc, trim($_POST['fName']));
		} 
	// Make sure there is a Last name entered.
	if (empty($_POST['lName'])) {
			$err[]= "You didn't enter the persons Last Name!";
		} else {
			$lName = mysqli_real_escape_string($dbc, trim($_POST['lName']));
		}
	// Make sure there is a Institute entered.
	if (empty($_POST['institution'])) {
			$err[]= "You didn't enter the persons Institution!";
		} else {
			$institution = mysqli_real_escape_string($dbc, trim($_POST['institution']));
		}		
	// Check that all textboxes had data.
	If(empty($err)){
		//Insert the reviewer into the reviewboard table.
		$query = "INSERT INTO reviewboard (fName, lName, institution, Active)
					VALUES ('$fName', '$lName', '$institution', 1);";
		$run = mysqli_query($dbc, $query);
	} else {
		
		//List each Error msg that is stored in the array.
		Foreach($err as $m)
		{
			echo " $m <br />";
		} echo "Please correct the errors.";
		

	}
	
	// Display Current Table anyway!
	// Queries to grab the data needed.
	$query = "SELECT fName, lName, institution FROM reviewboard WHERE Active = 1 ORDER BY lName;";
	$idQuery = "SELECT boardId FROM reviewboard WHERE Active = 1 ORDER BY lName;";
	//Execute the queries.
	$run = @mysqli_query($dbc, $query);
	$idRun = @mysqli_query($dbc, $idQuery);
	//Set up to use marks functions.
	$pageNames = array('ReviewBoardEntry.php');
	$variableNames = array('boardId');
	$titles = array('Delete');
	//Use marks functions to create the table to display.
	$headerCounter = @mysqli_num_fields($run);
	$editButton = tableRowLinkGenerator($idRun, $pageNames, $variableNames, $titles);
	$tableBody = tableRowGeneratorWithButtons($run, $editButton, 1, $headerCounter);
} else {
	// Not a postback, grab the data for the table.
	$query = "SELECT fName, lName, institution FROM reviewboard WHERE Active = 1 ORDER BY lName;";
	$idQuery = "SELECT boardId FROM reviewboard WHERE Active = 1 ORDER BY lName;";
	// Execute the queries.
	$run = @mysqli_query($dbc, $query);
	$idRun = @mysqli_query($dbc, $idQuery);
	// Set up for marks functions.
	$pageNames = array('ReviewBoardEntry.php');
	$variableNames = array('boardId');
	$titles = array('Delete');
	// Use marks functions to create the table to display.
	$headerCounter = @mysqli_num_fields($run);
	$editButton = tableRowLinkGenerator($idRun, $pageNames, $variableNames, $titles);
	$tableBody = tableRowGeneratorWithButtons($run, $editButton, 1, $headerCounter);
}
?>

<h1>Current Review Board</h1>
<fieldset>
		<table>
			<tr>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Institution</th>
			</tr>
			<?php echo $tableBody; ?>
		</table>
</fieldset>
<h1>Insert Review Member</h1>
<fieldset>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"  method="post">
			<p>First Name: <input type="text" name="fName" size="15" maxlength="50"  /></p>
			<p>Last Name: <input type="text" name="lName" size="15" maxlength="50"  /></p>
			<p>Institution: <input type="text" name="institution" size="15" maxlength="50"  /></p>
			<p>* All fields required.</p>
			<p><input type="submit" value="Submit" class="button3"</p>
	</form>		
</fieldset>
	  
<?php
include ("includes/Footer.php");
?>  
  
  
 