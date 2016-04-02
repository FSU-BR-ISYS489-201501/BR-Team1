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
	
	$success = "<br> Thank you for your submission. You will recieve an email message shortly. <br>";
	$currentDate = date("Y-m-d");
	$query = "SELECT AnnouncementId, Subject, Body FROM announcements WHERE IsActive = 1 AND StartDate < '{$currentDate}' 
		AND EndDate > '{$currentDate}';";
	
	// Stole from Shane Workman's Register code
	$selectQuery = @mysqli_query($dbc, $query);
	
	$headerCounter = mysqli_num_fields($selectQuery);
	$tableBody = tableRowGenerator($selectQuery, $headerCounter);
	
	if (isset($_POST['success'])) {
		$success = "<br>" . $_POST['success'] . "<br>";
	}
?>
<?php echo $success; ?>
<H1>Welcome to JCI</H1>
<div id = 'announcementViewer'>
	<table>
		<tr>
			<th></th>
			<th>Subject</th>
			<th>Announcement</th>
		</tr>
		<?php echo $tableBody; ?>
	</table>
</div>
<br>
<!--Lorem Ipsum coped from http://lorem-ipsum.perbang.dk/ -->
<p>
The Journal of Critical Incidents does not publish long cases. JCI's focus is on brief incidents that tell about real situation in a real organization. The incident tells a story about an event, an experience, a blunder, or a success. Unlike a long case, the incident does not provide historical detail or how the situation developed. Rather, it provides a snapshot that stimulates student use of their knowledge to arrive at a course of action or analysis.

Critical incidents can be based on either field work or library research. The maximum length of the Critical incidents is three single-spaced pages. See the Style Guide for layout and submission requirements.
</p>

<?php
	include ('includes/Footer.php');
?>
