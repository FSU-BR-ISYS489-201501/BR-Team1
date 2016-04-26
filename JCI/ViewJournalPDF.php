<?php
  /*********************************************************************************************
  * Original Author: Shane Workman
  * Date of origination: 03/29/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: The purpose of this page is to allow people to send an email to the editor.
  * Credit: My own code, with inspiration and use of others functions within the project.
  * http://php.net/ was a resource.
  * 
  * Revision1.1: 04/06/2016 Author: Mark Bowman
  * I changed the query to only show journal volumes that are not in development.
  *********************************************************************************************/
  $page_title = 'Journals';
  require ('../DbConnector.php');
  include ("includes/Header.php");
  include ("includes/TableRowHelper.php");
  //Diplay the journals in the Database.
  //Mark Bowman: Ichanged the query to only show journal volumes that are not in development.
  $query = "Select JournalVolume, PublicationYear FROM journalofcriticalincidents WHERE InDevelopement = 0 ORDER BY JournalID;";
  $idSelectQuery = "SELECT JournalID FROM journalofcriticalincidents WHERE InDevelopement = 0 ORDER BY JournalID DESC;";
  $run = mysqli_query($dbc, $query);
  $idSelectRun = mysqli_query($dbc, $idSelectQuery);
  $headerCounter = mysqli_num_fields($run);
  
  $pageNames = array('PdfViewerJournal.php');
  $titles = array('View');
  $variableName = array('JournalId');
  $editButton = tableRowLinkGenerator($idSelectRun, $pageNames, $variableName, $titles);
  $tableBody = tableRowGeneratorWithButtons($run, $editButton, 1, $headerCounter);
  
  //Begin code to display the review board.
  $rQuery = "SELECT fName, lName, institution FROM reviewboard WHERE Active = 1 ORDER BY lName;";
  $reviewResults = mysqli_query($dbc, $rQuery);
  $reviewHeaderCounter = mysqli_num_fields($reviewResults);
  $tableBody2= tableRowGenerator($reviewResults, $reviewHeaderCounter);
?>
<div style="float:right">
<h1>Current Review Board</h1>
	<table>
		<tr>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Institution</th>
		</tr>
		<tbody>
		<?php echo $tableBody2; ?>
		</tbody>
	</table>
</div>
<div style="float:left">
<h1>Published Journals</h1>
	<table>
		<tr>
			<th>Journal Volume</th>
			<th>Publication Year</th>
		</tr>
		<tbody>
			<?php echo $tableBody; ?>
		</tbody>
	</table>
</div>
<?php
include ("includes/Footer.php");
?>
