<?php
 /*********************************************************************************************
  * Original Author: Shane Workman
  * Date of origination: 03/19/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: The purpose of this page is to allow people to send an email to the editor.
  * Credit: my own code, from my Final project in ISYS288.
  *********************************************************************************************/
$page_title = 'Contact an Editor';
include ("includes/Header.php");
require ('../DbConnector.php');
 ?>
 <h1>Contact Us</h1>
 <fieldset>
	<form name="contactform" method="post" action="sendFormEmail.php">
		<label for="first_name">First Name *</label>
		<input  type="text" name="first_name" maxlength="50" size="30">
		<label for="last_name">Last Name *</label>
		<input  type="text" name="last_name" maxlength="50" size="30">
		<label for="email">Email Address *</label>
		<input  type="text" name="email" maxlength="80" size="30">
		<label for="telephone">Telephone Number</label>
		<input  type="text" name="telephone" maxlength="30" size="30">
		<label for="comments">Comments *</label>
		<textarea  name="comments" maxlength="1000" cols="25" rows="6"></textarea><br />
		<label for="annotate">* Required</label> 
		<input type="submit" value="Submit"> 
	 </form>
 </fieldset>
 
<?php
include ('includes/Footer.php');
?>
