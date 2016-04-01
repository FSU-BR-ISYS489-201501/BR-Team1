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
  *********************************************************************************************/
  $page_title = 'Journals';
  require ('../DbConnector.php');
  include ("includes/Header.php");
  include ("includes/TableRowHelper.php");
  //Diplay the journals in the Database.
  $query = "Select JournalVolume, PublicationYear FROM journalofcriticalincidents;";
  $idSelectQuery = "SELECT JournalID FROM journalofcriticalincidents;";
  $run = mysqli_query($dbc, $query);
  $idSelectRun = mysqli_query($dbc, $idSelectQuery);
  $headerCounter = mysqli_num_fields($run);
  
  $pageNames = array('PdfViewer.php');
  $titles = array('View');
  $variableName = array('JournalID');
  $editButton = tableRowLinkGenerator($idSelectRun, $pageNames, $variableName, $titles);
  $tableBody = tableRowGeneratorWithButtons($run, $editButton, 1, $headerCounter);
  
?>

<h1>Published Journals</h1>
<fieldset>
	<table>
		<tr>
			<th>Journal Volume</th>
			<th>Publication Year</th>
		</tr>
		<tbody>
			<?php echo $tableBody; ?>
		</tbody>
	</table>
</fieldset>

<?php
include ("includes/Footer.php");
?>
