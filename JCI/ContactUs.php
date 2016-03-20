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
include ("includes/Header.php");
$page_title = 'Contact an Editor';
require ('../DbConnector.php');
 ?>
<form name="contactform" method="post" action="sendFormEmail.php">
	<table>
	 	<tr>
			<td>
	 			<label for="first_name">First Name *</label>
			</td>
			<td >
				<input  type="text" name="first_name" maxlength="50" size="30">
			</td>
		</tr>
		<tr>
			<td >
	 			<label for="last_name">Last Name *</label>
	 		</td>
	 		<td >
	 			<input  type="text" name="last_name" maxlength="50" size="30">
	 		</td>
		</tr>
	 	<tr>
	 		<td >
	 			<label for="email">Email Address *</label>
	 		</td>
			<td >
				<input  type="text" name="email" maxlength="80" size="30">
	 		</td>
		</tr>
	 	<tr>
	 		<td >
	 			<label for="telephone">Telephone Number</label>
	 		</td>
			<td >
	 			<input  type="text" name="telephone" maxlength="30" size="30">
	 		</td>
		</tr>
		<tr>
	 		<td >
	 			<label for="comments">Comments *</label>
	 		</td>
	 		<td >
				<textarea  name="comments" maxlength="1000" cols="25" rows="6"></textarea>
	 		</td>
		</tr>
		<tr>
	 		<td colspan="2" style="text-align:center">
				<input type="submit" value="Submit"> 
	 		</td>
	 	</tr>
 	</table>
 </form>
 
<?php
include ('includes/Footer.php');
?>
