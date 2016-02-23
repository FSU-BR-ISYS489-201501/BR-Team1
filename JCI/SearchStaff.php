<?php
 /*********************************************************************************************
  * Original Author: Shane Workman
  * Date of origination: 02/22/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: The purpose of this page is to allow people search for Users and what they are "linked" too.
  * Credit:
  *********************************************************************************************/
include ("includes/Header.php");
$page_title = 'Search Staff';
require ('../DbConnector.php');
  
  
?>
<h1>Search Criteria</h1>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="announcement" method="post">
	<fieldset>
		<p>First Name: <input type="text" name="fName" size="15" maxlength="50" value="<?php if (isset($_POST['fName'])) echo $_POST['fName']; ?>" /></p>
		<p>Last Name: <input type="text" name="lName" size="15" maxlength="50" value="<?php if (isset($_POST['lName'])) echo $_POST['lName']; ?>" /></p>
		<p>Email: <input type="text" name="email" size="15" maxlength="50" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" /></p>
		<p><input type="submit" value="Submit" /></p>
	</fieldset>
</form>  


<?php
include ("includes/Footer.php");
?>