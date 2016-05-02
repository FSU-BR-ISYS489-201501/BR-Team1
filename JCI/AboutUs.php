<?php

/*********************************************************************************************
 * Original Author: Benjamin Brackett
 * Date of origination: 03/25/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose of Page: This is the AboutUs.php and will serve as the About Us content of the site.
 * 
 * Revision1.1: 04/24/2016 Author: Mark Bowman
 * Description of change: Added code to make the page pull content from the database instead 
 * of static HTML.
 ********************************************************************************************/
 // Coded by mark to Added code to make the page pull content from the database instead 
// of static HTML.
 $page_title = 'About Us';
	include ('includes/Header.php');
	include('includes/TableRowHelper.php');
	require('../DbConnector.php');
	
	$contentBody = '';
	
	$pageContentQuery = "SELECT Body FROM pagecontent WHERE PageContentId = 2;";
	$pageContentSelectQuery = @mysqli_query($dbc, $pageContentQuery);
	if ($row = mysqli_fetch_array($pageContentSelectQuery, MYSQLI_ASSOC)) {
		$contentBody = $row['Body'];
	}
	
	$editorsQuery = "SELECT Body FROM pagecontent WHERE PageContentId = 3;";
	$editorsSelectQuery = @mysqli_query($dbc, $editorsQuery);
	if ($row = mysqli_fetch_array($editorsSelectQuery, MYSQLI_ASSOC)) {
		$editors = $row['Body'];
	}
	
	$query = "SELECT FileLocation FROM files WHERE FileType = 'About';";
	
	if ($selectQuery = @mysqli_query($dbc, $query)) {
		while ($row = mysqli_fetch_array($selectQuery, MYSQLI_NUM)) {
			$aboutUs = $aboutUs . "<img src=$row[0] alt='' style='width:60%;height:60%;'>";
		}
	}
?>
<p>
<?php echo $contentBody; ?>
</p>
<p>
<?php echo $aboutUs; ?>
</p>
<p>
<?php echo $editors; ?>
</p>
<?php
	include ('includes/Footer.php');
?>

 
