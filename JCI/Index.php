<?php

/*********************************************************************************************
 * Original Author: Shane Workman
 * Date of origination: 02/08/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose of Page: This is the index.php and will serve as the home page content of the site.
 * 
 * Revision1.1: 04/24/2016 Author: Mark Bowman
 * Description of change: Added code to make the page pull content from the database instead 
 * of static HTML.
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
	$slideShow = '';
	
	//Mark Bowman: This block will display public and private announcements if the user is logged in.
	if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor' || $_SESSION['Type'] == 'author' || $_SESSION['Type'] == 'Author') {
		$query = "SELECT Body FROM announcements WHERE IsActive = 1 AND StartDate <= '{$currentDate}' 
		AND EndDate > '{$currentDate}';";
	
		// The idea for this code was inspired by Shane.
		$selectQuery = @mysqli_query($dbc, $query);
		
		$headerCounter = mysqli_num_fields($selectQuery);
		$tableBody = tableRowGenerator($selectQuery, $headerCounter);
	}
	//Mark Bowman: This block will display only public announcements if the user is not logged in.
	else {
		$query = "SELECT Body FROM announcements WHERE IsActive = 1 AND Type = 1 AND StartDate <= '{$currentDate}' 
		AND EndDate > '{$currentDate}';";
	
		// The idea for this code was inspired by Shane.
		$selectQuery = @mysqli_query($dbc, $query);
		
		$headerCounter = mysqli_num_fields($selectQuery);
		$tableBody = tableRowGenerator($selectQuery, $headerCounter);
	}
	
	//Mark Bowman: This block will get the page content from the database and then dispaly it on the page.
	$pageContentQuery = "SELECT Body FROM pagecontent WHERE PageContentId = 1;";
	$pageContentSelectQuery = @mysqli_query($dbc, $pageContentQuery);
	if ($row = mysqli_fetch_array($pageContentSelectQuery, MYSQLI_ASSOC)) {
		$contentBody = $row['Body'];
	}
	
	//Mark Bowman: This block will get the picture locations from the database and use that data to show
	//pictures on the slidedshow.
	$query = "SELECT FileLocation FROM files WHERE FileType = 'Slide';";
	
	if ($selectQuery = @mysqli_query($dbc, $query)) {
		while ($row = mysqli_fetch_array($selectQuery, MYSQLI_NUM)) {
			$slideShow = $slideShow . "<li><img src=$row[0] alt='' style='width:60%;height:60%;'></li>";
		}
	}
?>
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

    <?php
    	echo $slideShow;
    ?>

  </ul>

</div>
</center>

<p>
<?php echo $contentBody; ?>
</p>

<?php
	include ('includes/Footer.php');
?>
