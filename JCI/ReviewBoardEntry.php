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
  
  	//Got from mark to check the post back.
  	if (isset($_GET['boardId'])) {
			$deleteQuery = "DELETE FROM reviewboard WHERE boardID = {$_GET['activateId']};";
			$run = @mysqli_query($dbc, deleteQuery);
			if($run){
				header('Location: ManageAnnouncements.php');
				exit;
			}
		}
	$query = "SELECT fName, lName, institution FROM reviewboard;";
	$idQuery = "SELECT boardId FROM reviewboard;";
	
	$run = @mysqli_query($dbc, $query);
	$idRun = @mysqli_query($dbc, $idQuery);
	
	$pageNames = array('ReviewBoardEntry.php');
	$variableNames = array('boardID');
	$titles = array('Delete');
	
	$headerCounter = mysqli_num_fields($run);
	$editButton = tableRowLinkGenerator($idRun, $pageNames, $variableNames, $titles);
	$tableBody = tableRowGeneratorWithButtons($run, $editButton, 1, $headerCounter);
?>

<h1>Review Board</h1>>
		<table>
			<tr>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Institution</th>
			</tr>
			<?php echo $tableBody; ?>
		</table>

	  
<?php
include ("includes/Footer.php");
?>  
  
  
 