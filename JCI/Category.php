 <?php
 /*********************************************************************************************
 * Original Author:Faisal Alfadhli
 * Date of origination: 04/16/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: The purpose of this file is to display a journal that is in development with a link to allow the editor create a category for this journal 
 *
 * Credit: I used code written by Shane to make database queries and some code from other file in this project.
 * tutor: William Quigley, Email : mnewrath@gmail.com
 * www.php.net
 * www.stackoverflow.com
 * www.W3schools.com
 * Revision 1.0: 04/29/2016 Author: Faisal Alfadhli.
 * Description of change:added a link for edit category page 
 ********************************************************************************************/
 
 	include('includes/Header.php');
	include('includes/TableRowHelper.php');
	require('../DbConnector.php');

	// this is select statemants to get data from db.
	$devJournalsQuery = "SELECT criticalincidents.CriticalIncidentId, criticalincidents.Title, criticalincidents.Category, criticalincidents.JournalId FROM criticalincidents
						 INNER JOIN journalofcriticalincidents ON criticalincidents.JournalId=journalofcriticalincidents.JournalId
						 WHERE journalofcriticalincidents.InDevelopement='1';";
	$critincIdQuery = "SELECT CriticalIncidentId FROM criticalincidents
					   INNER JOIN journalofcriticalincidents ON criticalincidents.JournalId=journalofcriticalincidents.JournalId
					   WHERE journalofcriticalincidents.InDevelopement='1';";				   
	// It was written by Shane Workman.
	$selectQuery = @mysqli_query($dbc, $devJournalsQuery);
	$ciIdSelectQuery = @mysqli_query($dbc, $critincIdQuery);
	$headerCounter = mysqli_num_fields($selectQuery);
	$pageNames = array('NewCategory.php', 'SelectCategory.php', 'EditCategory.php');	
	$titles = array('New', 'Select', 'Edit');
	
	$assignButton = tableRowEditGenerator($ciIdSelectQuery, $pageNames, $titles);
	// it will add two links in every row 
	$rowCount = mysqli_num_rows($ciIdSelectQuery);
	if ($rowCount > 0) {
		$buttonCounter = count($assignButton)/$rowCount;
		$tableBody = tableRowGeneratorWithButtons($selectQuery, $assignButton, $buttonCounter, $headerCounter);
	} else {
		$tableBody = "<tr><td>No results available to display.</td></tr>";
	}
	if (isset($_POST['submit'])){
		echo $_POST['slctCategory'];
		if (!empty($_POST['slctCategory'])) {
			if ($_POST['slctCategory'] = "New"){
				header('Location: http://localhost/BR-Team1/JCI/NewCategory.php');
				
			} else {
				$catNameToInsert = $_POST['slctCategory'];
				$catYearToInsert = $_POST['catgyYear'];
				//I build insert query into categorys table.
				$query = "INSERT INTO categorys (CategoryName, CategoryYear)
						  VALUES ('$catNameToInsert', '$catYearToInsert');";
				//Run the query...
				$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
				
				//if query is unsuccessful tell a user there is an error.
				If (!$run){
					echo "There was an error with the submission. Please try again!";
				} else {
					echo "Your category has been added.";
				}
			}
		} else {
			echo "You must enter both a category name and a category year.";
		}
	}
?>

	<h1>CI Categorys</h1>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="newcategory" method="post">
		<div id = 'ciCategorys'>
			<table>
				<tr>
					<th>C.I. Id</th>
					<th>Title</th>
					<th>Category</th>
					<th>Journal Id</th>
				</tr>
				<?php echo $tableBody; ?>
			</table>
		</div>
	</form>

<?php
include ("includes/Footer.php");
?>