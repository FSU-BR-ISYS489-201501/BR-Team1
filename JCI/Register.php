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
  * 
  * Revision1.3: 02/15/2016 Author: Shane Workman
  * Fixed A bug in the line 161-169 sticky not working correctly.
  * 
  * Revision1.4: 02/20/2016	Author: Shane Workman /Via Mark Computer.
  * Fixed a variable bug. Needed to capitalize a few letets.
  * 
  * Revision1.5: 02/22/2016 Author: Shane Workman
  * Added the CheckEmail.php funciton to the validation. Spelled out a few variables that were abbriviated.
  * 
  * Revision1.6: 04/05/2016 Author: Mark Bowman
  * Added code to insert the Author usertype into the usertypes table.
  * 
  * Revision1.7: 04/07/2016 Author: Donald Dean
  * Added password encryption.
  ********************************************************************************************/
 $page_title = 'Register';
 include ("includes/Header.php");
 include ("includes/ValidationHelper.php");

 
 //Grab the db connector.
 //require ('../mysqli_connect.php');
 require ('../DbConnector.php');
  
	
//Begin Validation... 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
 	//Set up Error msg array.
 	$err = array();
	

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
			$fName = mysqli_real_escape_string($dbc, trim($_POST['fName']));
		}
 	
	//Check if last name text box has a value.
	if (empty($_POST['lName'])) {
			$err[] = 'You forgot to enter your last name.';
		} else {
			$lName = mysqli_real_escape_string($dbc, trim($_POST['lName']));
		}
 	
 	//Check if last name text box has a value.
 	if (empty($_POST['suffix'])) {
			$suffix = 'NULL';
		} else {
			$suffix = mysqli_real_escape_string($dbc, trim($_POST['suffix']));
		}
 
 	//Check if email text box has a value.
 	//Need to add the check email mask function when completed.
 	if (empty($_POST['email'])) {
			$err[] = 'You forgot to enter your email.';
		} elseif (checkEmail($_POST['email']) == 0) {
			$err[] = 'The email submitted doesnt have the correct syntax.';
		} else {
			$testEmail = mysqli_real_escape_string($dbc, trim($_POST['email']));
			$testQ = "SELECT * FROM users WHERE Email = '$testEmail';"; 
			$result = mysqli_query($dbc, $testQ);
			if (@mysqli_fetch_array($result)) { 
				$err[] = 'This email is already registered! Please check <a href="PasswordHelp.php">Forgot Password?</a>';
			} else {
				$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
				
			}
		}

 	//Check if university text box has a value or set it to null.
 	if (empty($_POST['university'])) {
		$university = 'NULL';
		} else {
			$university = mysqli_real_escape_string($dbc, trim($_POST['university']));
		}		

 	//Check if SCR member id text box has a value or set it to null.
 	if (empty($_POST['memberID'])) {
		$member = 'NULL';
		} else {
			$member = mysqli_real_escape_string($dbc, trim($_POST['memberID']));
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
	If(empty($err)) {
		// Donald Dean: I borrowed this idea from sourcewareinfo. Credit https://www.youtube.com/watch?v=LvNCFffK-y0.
		$salt = "5v4tws27NONtZjBA7Zhn";
		// $salt = randString(10); Shane: Would like to implement this. would have to add some query to loginFunction.
		$pass = $pass.$salt;
		$pass = sha1($pass);
		//Creat the query that dumps info into the DB.
		$query = "INSERT INTO users (Prefix, FName, LName, Suffix, Email, Employer, Title, MemberCode, Regdate, PasswordHash, PasswordSalt)
				VALUES ('$prefix', '$fName', '$lName', '$suffix', '$email', '$university', '$title', '$member', NOW(), '$pass', '$salt');";
				
		//Run the query...
		$run = @mysqli_query($dbc, $query);
		
		// Mark Bowman: I borrowed this line of code from SubmitCase.php. Credit given to William.
		$critIncidentId = mysqli_insert_id($dbc);
		
		// Mark Bowman created a query that will make the registered user an Author in usertypes.
		$query = "INSERT INTO usertypes(UserId, Type)
				VALUES($critIncidentId, 'Author');";
				
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
		} else {
			//List each Error msg that is stored in the array.
			Foreach($err as $m)
			{
				echo " $m <br />";
			} echo "Please correct the errors.";
		
		}
	}
	//Close the DB and wrap up shop!
	mysqli_close($dbc);			
 ?>
<h1>Register</h1>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="regiForm" method="post">
	<fieldset>
		<p>Prefix: 
		<select name="prefix">
			<option <?php if(isset($_POST['prefix'])=="NULL") echo'selected="selected"'; ?>    value="NULL"></option>
			<option <?php if(isset($_POST['prefix'])=="Ms") echo'selected="selected"'; ?>    value="Ms">Ms</option>
			<option <?php if(isset($_POST['prefix'])=="Mrs") echo'selected="selected"'; ?>    value="Mrs">Mrs</option>
			<option <?php if(isset($_POST['prefix'])=="Miss") echo'selected="selected"'; ?>    value="Miss">Miss</option>
			<option <?php if(isset($_POST['prefix'])=="Mr") echo'selected="selected"'; ?>    value="Mr">Mr</option>
			<option <?php if(isset($_POST['prefix'])=="Sir") echo'selected="selected"'; ?>    value="Sir">Sir</option>
			<option <?php if(isset($_POST['prefix'])=="Dr") echo'selected="selected"'; ?>    value="Dr">Dr</option>
		</select></p>
		<p>* First Name: <input type="text" name="fName" size="15" maxlength="50" value="<?php if (isset($_POST['fName'])) echo $_POST['fName']; ?>" /></p>
		<p>* Last Name: <input type="text" name="lName" size="15" maxlength="50" value="<?php if (isset($_POST['lName'])) echo $_POST['lName']; ?>" /></p>
		<p>Suffix: <input type="text" name="suffix" size="10" maxlength="10" value="<?php if (isset($_POST['suffix'])) echo $_POST['suffix']; ?>" /></p>
		<p>* Email Address: <input type="text" name="email" size="20" maxlength="100" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"  /> </p>
		<p>Title: <input type="text" name="title" size="15" maxlength="50" value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>" /></p>
		<p>Institution: <input type="text" name="university" size="20" maxlength="100" value="<?php if (isset($_POST['university'])) echo $_POST['university']; ?>" /></p>
		<p>SCR Member ID: <input type="text" name="memberID" size="15" maxlength="50" value="<?php if (isset($_POST['memberID'])) echo $_POST['memberID']; ?>" /></p>
		<p>Password Requirements:
			<ul>
				<li>At least 10 characters long.</li>
				<li>1 special character.</li>
				<li>1 number.</li>
				<li>1 capital letter.</li>
				<li>1 lower case letter.</li>
			</ul>
		</p>
		<p>* Password: <input type="password" name="pass1" size="15" maxlength="20" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>"  /></p>
		<p>* Confirm Password: <input type="password" name="pass2" size="15" maxlength="20" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>"  /></p>
		<p>* Required</p>
		
		<p><input type="submit" value="Submit" class="button3"</p>
	</fieldset>
	<p>Please only Register if you intend on either submitting a Critical Incident, or being a reviewer for the editorial staff!
		Thank you. ~ Staff</p>
</form>

<?php
include ("includes/Footer.php");
?>