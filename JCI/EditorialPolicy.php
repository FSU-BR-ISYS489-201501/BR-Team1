<?php
/*********************************************************************************************
 * Original Author: Benjamin Brackett
 * Date of origination: 03/28/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose of Page: This is the EditorialPolicy.php and will serve as the Editorial Policy 
 * content of the site.
 ********************************************************************************************/

  $page_title = 'Editorial Policy';
	include ('includes/Header.php');
	include('includes/TableRowHelper.php');
	require('../DbConnector.php');
	
	$contentBody = '';
	
	$pageContentQuery = "SELECT Body FROM pagecontent WHERE PageContentId = 5;";
	$pageContentSelectQuery = @mysqli_query($dbc, $pageContentQuery);
	if ($row = mysqli_fetch_array($pageContentSelectQuery, MYSQLI_ASSOC)) {
		$contentBody = $row['Body'];
	}
?>

<?php echo $contentBody; ?>

<?php
	include ('includes/Footer.php');
?>