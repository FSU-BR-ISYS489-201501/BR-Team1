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
<img src="styles/images/Editors.JPG" alt="Editors" style="width:304px;height:228;">
<p>Dr. Timothy Brotherton, Editor and Dr. Timothy Redmer, Associate Editor pose above.</p>
<h2>POLICIES</h2>
<p>Go to our <a href="EditorialPolicy.php" class="action">Policies</a> page if you would like to cover areas like the critical incident format, review process, and publication ethics policy.</p>
<h2>SCR Mission and Purpose</h2>
<p>
	The Society for Case Research (SCR) facilitates the exchange of ideas leading to the improvement of case research, writing, and teaching; assists in the publication of written cases or case research and other scholarly work; and provides recognition for excellence in case research, writing and teaching. The society publishes three scholarly journals:
<ul>
	<li>Business Case Journal</li>
	<li>Journal of Case Studies</li>
	<li>Journal of Critical Incidents</li>
</ul>
If you are interested in joining SCR, publishing in one of the journals or contacting the Officers of the Society, go to www.sfcr.org. To purchase copies of the Critical Incidents or Teaching Notes contact Roy Cook at cook_r@fortlewis.edu
</p>
<h2>Publication Information</h2>
<p>
The goals of the Society of Case Research <a href="http://www.sfcr.org">www.sfcr.org</a> are to help authors develop and publish worthy business case studies. The Journal of Critical Incidents (JCI) does not publish does not publish long cases. JCI’s focus is on brief incidents that tell about a real situation in a real organization (similar to end-of-chapter cases in textbooks). The critical incident tells a story about an event, an experience, a blunder, or a success. Unlike a long case, the incident provides only limited historical detail or how the situation developed. Rather, it focuses on a real time snapshot that stimulates student user of their knowledge to arrive at a course of action or analysis.
</p>
<p> 
Critical incidents can be based on either field work or library research. The maximum length of the critical incidents is three single-spaced pages. A teaching note must be submitted with the critical incident. The quality of the teaching note is a central factor in the review and acceptance process. Submissions are double-blind, peer reviewed. Formatted copies of acceptable critical requirements. The Journal of Critical Incidents is listed in <a href="http://www.cabells.com/">Cabell’s Directories of Publishing Opportunities</a> and is published annually in the Fall. 
</p>

<?php
	include ('includes/Footer.php');
?>

 
