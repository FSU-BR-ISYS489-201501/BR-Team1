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

<h2>POLICIES</h2>
<p>
Go to our <a href="EditorialPolicy.php" class="action">policies</a> page if you would like to cover areas like the critical incident format, review process, and publication ethics policy.
</p>

<h2>Publication Ethics Policy and Malpractice Statement</h2>
<p>
Go to our page on <a href="Ethics.php" class="action">ethics policy</a> if you would like to know what we expect from the authors, reviewers and editors.
</p>

<h2>JCI Mission and Purpose</h2>
<p>
The Journal of Critical Incidents does not publish long cases. JCI's focus is on brief incidents that tell about real situation in a real organization. The incident tells a story about an event, an experience, a blunder, or a success. Unlike a long case, the incident does not provide historical detail or how the situation developed. Rather, it provides a snapshot that stimulates student use of their knowledge to arrive at a course of action or analysis.
Critical incidents can be based on either field work or library research. The maximum length of the Critical incidents is three single-spaced pages. See the Style Guide for layout and submission requirements.

If you are interested in joining SCR, publishing in one of the journals or contacting the Officers of the Society, go to <a href="http://www.sfcr.org" class="action">www.sfcr.org</a>. To purchase copies of the Critical Incidents or Teaching Notes contact Joanne Tokle <a href="mailto:tokljoan@isu.edu">tokljoan@isu.edu</a>
</p>

<h2>Publication Information</h2>
<p>
The goals of the Society of Case Research <a href="http://www.sfcr.org" class="action">www.sfcr.org</a> are to help authors develop and publish worthy business case studies. The Journal of Critical Incidents (JCI) does not publish does not publish long cases. JCI’s focus is on brief incidents that tell about a real situation in a real organization (similar to end-of-chapter cases in textbooks). The critical incident tells a story about an event, an experience, a blunder, or a success. Unlike a long case, the incident provides only limited historical detail or how the situation developed. Rather, it focuses on a real time snapshot that stimulates student user of their knowledge to arrive at a course of action or analysis.
</p>
<p> 
Critical incidents can be based on either field work or library research. The maximum length of the critical incidents is three single-spaced pages. A teaching note must be submitted with the critical incident. The quality of the teaching note is a central factor in the review and acceptance process. Submissions are double-blind, peer reviewed. Formatted copies of acceptable critical requirements. The Journal of Critical Incidents is listed in <a href="http://www.cabells.com/">Cabell’s Directories of Publishing Opportunities</a> and is published annually in the Fall. 
</p>

<h2>PEOPLE</h2>
<p>
Send us a message on our <a href="ContactUs.php" class="action">Contact Us</a> page.
</p>

<h4 class="secondary">Meet the Editors</h4>
<img src="styles/images/Editors.JPG" alt="Editors" style="width:70%;height:70%;">
<p>
Dr. Timothy Redmer, Associate Editor (left) and Dr. Timothy Brotherton, Editor (right) pose above.
</p>

<?php
	include ('includes/Footer.php');
?>

 
