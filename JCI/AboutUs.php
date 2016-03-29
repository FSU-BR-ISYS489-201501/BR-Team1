<?php

/*********************************************************************************************
 * Original Author: Benjamin Brackett
 * Date of origination: 03/25/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose of Page: This is the AboutUs.php and will serve as the About Us content of the site.
 ********************************************************************************************/
 
 $page_title = 'About Us';
	include ('includes/Header.php');
	include('includes/TableRowHelper.php');
	require('../DbConnector.php');

	
?>

<H1>ABOUT THE JOURNAL</H1>


<h2>PEOPLE</h2>
<p>Send us a message on our <a href="ContactUs.php" class="action">Contact Us</a> page.</p>
<h4 class="secondary">Meet the Editors</h4>
<img src="images/Editors.JPG">
<p>Dr. and Dr. pose above at the  </p>
<h2>POLICIES</h2>
<p>Go to our <a href="EditorialPolicy.php" class="action">Policies</a> page if you would like to cover areas like the critical incident format, review process, and publication ethics policy.</p>
<h2>SCR Mission and Purpose</h2>
<p>
	The Society for 
</p>

<?php
	include ('includes/Footer.php');
?>

 
