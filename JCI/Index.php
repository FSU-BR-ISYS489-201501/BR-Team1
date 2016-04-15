<?php

/*********************************************************************************************
 * Original Author: Shane Workman
 * Date of origination: 02/08/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose of Page: This is the index.php and will serve as the home page content of the site.
 ********************************************************************************************/
	$page_title = 'Home';
	include ('includes/Header.php');
	include('includes/TableRowHelper.php');
	require('../DbConnector.php');
	
	$tableStart= "<table><tbody>";
	$tableHeader = "<th>Announcements</th>";
	$tableEnd= "</table></tbody>";
	$success = '';
	$currentDate = date("Y-m-d");
	$contentBody = '';
	
	$query = "SELECT Body FROM announcements WHERE IsActive = 1 AND StartDate <= '{$currentDate}' 
		AND EndDate > '{$currentDate}';";
	
	// Stole from Shane Workman's Register code
	$selectQuery = @mysqli_query($dbc, $query);
	
	$headerCounter = mysqli_num_fields($selectQuery);
	$tableBody = tableRowGenerator($selectQuery, $headerCounter);
	
	$pageContentQuery = "SELECT Body FROM pagecontent WHERE PageContentId = 1;";
	$pageContentSelectQuery = @mysqli_query($dbc, $pageContentQuery);
	if ($row = mysqli_fetch_array($pageContentSelectQuery, MYSQLI_ASSOC)) {
		$contentBody = $row['Body'];
	}
?>
<?php echo $success; ?>
<br>
<center>
	<H1>Welcome to JCI</H1>
	<?php 
		// This code was borrowed from Search.php, written by Shane Workman.
		if (!empty($tableBody)){
			echo $tableStart;
			echo $tableHeader;
			echo $tableBody;
			echo $tableEnd;
		}
	?>
</center>
<br>

<br>

<!--
	Grabbed from link below
	http://csswizardry.com/2011/10/fully-fluid-responsive-css-carousel/
-->	
<center>
<div class=carousel>

  <ul class=panes>

    <li>
      <img src="styles/images/DSCN3333.JPG" alt="" style="width:60%;height:60%;">
    </li>

    <li>
      <img src="styles/images/DSCN0029.JPG" alt="" style="width:60%;height:60%;">
    </li>

    <li>
      <img src="styles/images/DSCN0179.JPG" alt="" style="width:60%;height:60%;">
    </li>

    <li>
      <img src="styles/images/Volume7WelcomeMessage.PNG" alt="" style="width:40%;height:40%;">
    </li>

    <li>
      <img src="../uploads/AfterHoursSummary.pdf" alt="" style="width:60%;height:60%;">
    </li>

  </ul>

</div>
</center>

<p>
<?php echo $contentBody; ?>
</p>

<?php
	include ('includes/Footer.php');
?>
