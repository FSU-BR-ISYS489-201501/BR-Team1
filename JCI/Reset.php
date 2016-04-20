<?php
 /*********************************************************************************************
  * Original Author: Shane Workman
  * Date of origination: 04/12/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: This page is used to help a User reset thier password given they know the registered Email.
  * Credit: My own code or borrowed from within our site. http://php.net/ was a resource.
  * 
  **********************************************************************************************/  
  if (isset($_Get('token')))	{
  		$token = $_GET('token');
  	}
  $page_title = 'Password Reset';
  include ("includes/Header.php");
  include ("includes/RandString.php");
  require ('../DbConnector.php');
  $form = "";
  //Check to see if the link if from the email or a post back.
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  	//Set up Error msg array.
 	$err = array();
	
	$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
	//Check the password text boxes contain values and that both boxes are equal.
	//Uses checkPsw() function to make sure the password meets complexity.
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
	if (empty($err)){
		// Donald Dean: I borrowed this idea from sourcewareinfo. Credit https://www.youtube.com/watch?v=LvNCFffK-y0.
		$salt = "5v4tws27NONtZjBA7Zhn";
		$pass = $pass.$salt;
		$pass = sha1($pass);
		//Creat the query that updates info into the DB.
		$query = "UPDATE users SET PasswordHash= '$pass' WHERE `Email`= '$email';";
		$run = @mysqli_query($dbc, $query);
				//The Following builds the email to be sent.
				//Email needs to change to reflect a webhost generic email.
				$defaultEmail = "webmailer@JCI.com";
				$to = $email;
				$subject = "JCI Password reset";
				$message = 'The password has been reset for the login ' .$email.'!';
			    $headers = 'From: ' . $defaultEmail . "\r\n" .
        		'Reply-To: ' . $defaultEmail . "\r\n" .
        		'X-Mailer: PHP/' . phpversion();
				//Builds email to send to the registered.
    			mail($to, $subject, $message, $headers);
		echo '<h1>Password Reset</h1><fieldset><p>You have successfully changed your password.</p></fieldset>';
		
	} else {
		//List each Error msg that is stored in the array.
			Foreach($err as $m)
			{
				echo " $m <br />";
			} echo "Please correct the errors.";
			$form = '<h1>Password Reset</h1>
				<fieldset>	
					<form action="Reset.php" id="regiForm" method="post">
						<p>Please create a new password.<br />
						<p>* Password: <input type="password" name="pass1" size="15" maxlength="20"  /></p>
						<p>* Confirm Password: <input type="password" name="pass2" size="15" maxlength="20" /></p>
						<p>Password Requirements:
							<ul>
								<li>At least 10 characters long.</li>
								<li>1 special character.</li>
								<li>1 number.</li>
								<li>1 capital letter.</li>
								<li>1 lower case letter.</li>
							</ul>
						</p>
						<input type="hidden" name="email" value="' . $email. '" />
						<input type="submit" value="Reset My Password" />
					</form>
				</fieldset>';
	}
	
  } else {
	  echo $token;
	  $query = "SELECT Email FROM tokens WHERE Token = '$token';";
	  echo $query;
	  $run = @mysqli_query($dbc, $query);
	  
	  if (mysqli_num_rows($run > 0)){
	  		$form = '<h1>Password Reset</h1>
				<fieldset>	
					<form action="Reset.php" id="regiForm" method="post">
						<p>Please create a new password.<br />
						<p>* Password: <input type="password" name="pass1" size="15" maxlength="20"  /></p>
						<p>* Confirm Password: <input type="password" name="pass2" size="15" maxlength="20" /></p>
						<p>Password Requirements:
							<ul>
								<li>At least 10 characters long.</li>
								<li>1 special character.</li>
								<li>1 number.</li>
								<li>1 capital letter.</li>
								<li>1 lower case letter.</li>
							</ul>
						</p>
						<input type="hidden" name="email" value="' . $run. '" />
						<input type="submit" value="Reset My Password" />
					</form>
				</fieldset>';
			$dQuery = "DELETE FROM tokens WHERE Token ='$token';";
			$drun = @mysqli_query($dbc, $dQuery);
	  } else {
	  	echo '<h1>Password Reset</h1><fieldset><p>The link was invalid, or already used to reset the password. <a href="PasswordHelp.php">Get new link!</a></p></fieldset>';
	  }
  }
?>
<?php echo "$form"; ?>
<?php 
  include ("includes/Footer.php");
?>	