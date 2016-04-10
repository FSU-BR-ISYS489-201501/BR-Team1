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
	$query = "SELECT Body FROM announcements WHERE IsActive = 1 AND StartDate <= '{$currentDate}' 
		AND EndDate > '{$currentDate}';";
	
	// Stole from Shane Workman's Register code
	$selectQuery = @mysqli_query($dbc, $query);
	
	$headerCounter = mysqli_num_fields($selectQuery);
	$tableBody = tableRowGenerator($selectQuery, $headerCounter);
	
	if (isset($_GET['success'])) {
		$success = "<br> Thank you for your submission. You will recieve an email message within the next five minutes. <br>";
	}
?>
<?php echo $success; ?>
<br>
<center>
	<H1>Welcome to JCI</H1>
	<?php 
		// This code was borrowed from Search.php, written by Shane Workman.
		iF (!empty($tableBody)){
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
<b>WELCOME</b> to Volume 7 of the <i>Journal of Critical Incidents</i>! We have made it to our fourth year as editor. With 40 critical incidents this year, Volume 7 is the largest <i>JCI</i> ever. How long can we continue this growth trajectory? Who knows? We want to grow bigger AND better every year. We hope that you find that we have continued to maintain the high standards that you have come to expect from every <i>Society of Case Research</i>  publications.
</p>
<p>	
I would like to personally thank the authors for their contribution of many high quality critical incidents. The success or failure of any journal is ultimately due to the efforts of its authors and we had some good ones again this year. There was a mix of new and experienced authors in this volume and we hope that each of the authors found value in the critical incident creation process. In addition, I can’t thank the reviewers enough for their willingness to volunteer their valuable time during their busy summers in order to give constructive feedback to the authors at every stage of the process. 
</p>
<p>
I especially want to thank our Associate Editor, Tim Redmer. He worked very hard again this year assisting authors and reviewers all summer. He excels at writing, reviewing, AND editing case studies. I continue to enjoy working with him and he is an important asset to <i>JCI</i>. 
</p>
<p>
I wish to thank my intern, Brady Stockwell. An English student minoring Integrated Marketing Communications at Ferris State University, he has helped with the final editing of all the CIs and did much of the formatting for this volume. He has worked very hard to make this volume as perfect as humanly possible. 
</p>
<p>
We hope that you will continue to support our ongoing efforts at continuous improvement. Several of the SCR Editors and Board members are re-evaluating the current SCR publication guidelines. You can expect that a number of changes will be proposed and implemented for volume 8 of JCI (e.g. the use of Learning Outcomes rather than Learning Objectives). If you have any suggestions for improvements to the guidelines, please let me know.
</p>
<p>
Finally, please read the critical incidents and consider adopting them for use in your courses. Members of the Society of Case Research should be our own best customers. 
</p>
<p>
Thank you again for everyone’s time and efforts this year. We look forward to working with each of you in the years ahead. I hope to see you in Chicago next March.
</p>
<p>
Sincerely,
</p>
<p>
Tim Brotherton
</p>
<p>
2014 JCI Editor
</p>

<?php
	include ('includes/Footer.php');
?>
