<?php
 /*********************************************************************************************
 * Original Author: Shane Workman
 * Date of origination: 02/06/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: This page is used to collect user information whom wish to register for the JCI site.
 * Credit: A bulk of this code is derived in some part from code I used and learned in ISYS288.
 *			We used Larry Uldman's PHP book
 * 
 * Function:  checkPsw($pass)
 * Purpose: To make sure the password supplied by the user meets complexity.
 * Variable: $pass is the variable passed into the function from the form text pass1.
 *
 * Revision1.1: 02/09/2016 Author: Shane Workman 
 * Added the checkPsw() function to the page.
  * 
 * Revision1.2: 02/14/2016 Author: Shane Workman 
 * Added an email to the registered user. Next update should include validation of email with a token.
 ********************************************************************************************/
 include ("includes/Header.php");
 include ("includes/CheckPsw.php");
 $page_title = 'Register';
 
 //Grab the db connector.
 require ('../DbConnector.php');
 
 //Set up Error msg array.
 $err[] = array();
	
//Begin Validation... 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
	//Grab the db connector.
 	require ('../DbConnector.php');
 
 	//Set up Error msg array.
 	$err[] = array();
	
	//Set prefix sql string.
	$prefix = mysqli_real_escape_string($dbc, trim($_POST['prefix']));
	
	//Check if the text box has a value or set it to null.
	if (empty($_POST['title'])) {
		$title = 'NULL';
		} else {
			$title = mysqli_real_escape_string($dbc, trim($_POST['title']));
		}
	
	//Check if the first name text box has a value.
	if (empty($_POST['fName'])) {
		$err[] = 'You forgot to enter your first name.';
		} else {
			$fname = mysqli_real_escape_string($dbc, trim($_POST['fName']));
		}
 	
	//Check if last name text box has a value.
	if (empty($_POST['lName'])) {
		$err[] = 'You forgot to enter your last name.';
		} else {
			$lname = mysqli_real_escape_string($dbc, trim($_POST['lName']));
		}
 	
 	//Check if last name text box has a value.
 	if (empty($_POST['suffix'])) {
		$sfx = 'NULL';
		} else {
			$sfx = mysqli_real_escape_string($dbc, trim($_POST['suffix']));
		}
 
 	//Check if email text box has a value.
 	//Need to add the check email mask function when completed.
 	if (empty($_POST['email'])) {
		$err[] = 'You forgot to enter your email.';
		} else {
			$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
		}

 	//Check if university text box has a value or set it to null.
 	if (empty($_POST['university'])) {
		$uni = 'NULL';
		} else {
			$uni = mysqli_real_escape_string($dbc, trim($_POST['university']));
		}		

 	//Check if SCR member id text box has a value or set it to null.
 	if (empty($_POST['memberID'])) {
		$mem = 'NULL';
		} else {
			$mem = mysqli_real_escape_string($dbc, trim($_POST['memberID']));
		}
		
	//Check the password text boxes contain values and that both boxes are equal.
	//Shane Workman: Added checkPsw() function to make sure the password meets complexity.
 	if (empty($_POST['pass1'])) {
		$err[] = 'You forgot to enter your password.';
		} elseif (empty($_POST['pass2'])) {
			$err[] = 'You forgot to confirm your password.';
		} elseif (($_POST['pass1']) != ($_POST['pass2'])) {
			$err[] = 'Your passwords do not match!';		
		} elseif(checkPsw($_POST['pass1'])) {
			$pass = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
		} else {
			$err[] = 'Your password did not contain at least 1 uppercase, lowercase, number, and symbol.';
		}

	//Check if the array is empty, no ERRORS?
	If(empty($err)){
		//Creat the query that dumps info into the DB.
		$query = "Insert INTO users (prefix, Fname, Lname, suffix, email, employer, title, membercode, regdate, password_hash, password_salt)
				VALUES ('$prefix, $fName, $lName, $suffix, $email, $uni, $title, $mem, NOW(), $pass, $pass)";
				
		//Run the query...
		$run = @mysqli_query($dbc, $query);
		
		//Check to make sure the dbConnector didnt die!
		IF (!$run)
		{
			echo 'Error, You could not be registered please try again.';
		} else {
			//At some point a landing page of a profile sheet or default view needs to replace the following code!
			echo "Thank you for registering for our site, $fName $lName more miraculous things to come!";
			echo "An email has been sent to the address you provided for validation!";
				
				//The Following builds the email to be sent.
				//Email needs to change to reflect a webhost generic email.
				//Email validation with token to be added in the future. 
				$defaultEmail = "webmailer@JCI.com";
				$to = $email;
				$subject = "JCI Registration Validation";
				$message = "$fName $lName, Thank you for registering for JCI.";
			    $headers = 'From: ' . $defaultEmail . "\r\n" .
        		'Reply-To: ' . $defaultEmail . "\r\n" .
        		'X-Mailer: PHP/' . phpversion();
				//Builds email to send to the registered.
    			mail($to, $subject, $message, $headers);
			
			
		}		
	}else {
		//List each Error msg that is stored in the array.
		Foreach($err as $m)
		{
			echo " $m<br />";
		} echo "Please correct the errors.";
		
	}
	
	//Close the DB and wrap up shop!
	mysqli_close($dbc);
}				
 ?>
<h1>Register</h1>
<form action="register.php" id="regiForm" method="post">
	<fieldset>
		<p>Prefix: <select name="prefix">
			<option <?php if($prefixVar=="") echo'selected="selected"'; ?>    value=""></option>
			<option <?php if($prefixVar=="Ms") echo'selected="selected"'; ?>    value="Ms">Ms</option>
			<option <?php if($prefixVar=="Mrs") echo'selected="selected"'; ?>    value="Mrs">Mrs</option>
			<option <?php if($prefixVar=="Miss") echo'selected="selected"'; ?>    value="Miss">Miss</option>
			<option <?php if($prefixVar=="Mr") echo'selected="selected"'; ?>    value="Mr">Mr</option>
			<option <?php if($prefixVar=="Sir") echo'selected="selected"'; ?>    value="Sir">Sir</option>
			<option <?php if($prefixVar=="Prof") echo'selected="selected"'; ?>    value="Prof">Prof</option>
		</select></p>
		<p>Title: <input type="text" name="title" size="15" maxlength="50" value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>" /></p>
		<p>First Name: <input type="text" name="fName" size="15" maxlength="50" value="<?php if (isset($_POST['fName'])) echo $_POST['fName']; ?>" /></p>
		<p>Last Name: <input type="text" name="lName" size="15" maxlength="50" value="<?php if (isset($_POST['lName'])) echo $_POST['lName']; ?>" /></p>
		<p>Suffix: <input type="text" name="suffix" size="10" maxlength="10" value="<?php if (isset($_POST['suffix'])) echo $_POST['suffix']; ?>" /></p>
		<p>Email Address: <input type="text" name="email" size="20" maxlength="100" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"  /> </p>
		<p>Institution: <input type="text" name="university" size="20" maxlength="100" value="<?php if (isset($_POST['university'])) echo $_POST['university']; ?>" /></p>
		<p>SCR Member ID: <input type="text" name="memberID" size="15" maxlength="50" value="<?php if (isset($_POST['memberID'])) echo $_POST['memberID']; ?>" /></p>
		<p>Password: <input type="password" name="pass1" size="15" maxlength="20" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>"  /></p>
		<p>Confirm Password: <input type="password" name="pass2" size="15" maxlength="20" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>"  /></p>
		<p><input type="submit" value="Register" /></p>
	</fieldset>
</form>

<?php
include ("includes/Footer.php");
?>