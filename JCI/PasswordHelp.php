<?php
 /*********************************************************************************************
  * Original Author: Shane Workman
  * Date of origination: 04/11/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: This page is used to help a User reset thier password given they know the registered Email.
  * Credit: http://php.net/ was a resource. 
  * 		http://stackoverflow.com/questions/8389195/what-server-variable-provide-full-url
  * 		http://stackoverflow.com/questions/30513624/sending-token-query-string-parameter-from-webpage-url-in-post-request  * 
  *************************************************************************************************/
 $page_title = 'Password Reset';
  include ("includes/Header.php");
  include ("includes/RandString.php");
  require ('../DbConnector.php');
  $form = "";
  //Begin Validation... 
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	  	//Set up Error msg array.
	 	$err = array();
		//Check to make sure they entered an email.
		if (empty($_POST['email'])) {
				$err[] = 'Please type in your email';
			} else {
				$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
			}
		//Checks to see if array
		if (empty($err)) {
			$query = "SELECT Email FROM users WHERE Email = '$email';";	
			$run = @mysqli_query($dbc, $query);
			$count = mysqli_num_rows($run);
			if ($count > 0) {
				$token = randString(10);
				$iquery = "INSERT INTO tokens (Token, Email , Active) values ('$token', '$email', 1)";
				$irun = @mysqli_query($dbc, $iquery);
				
				$defaultEmail = "webmailer@JCI.com";
				$url = 'http://'. $_SERVER['HTTP_HOST'] ;
				$to = $email;
				$subject = "JCI password Reset";
				$message = 
				'
				Password help for JCI website
				Click on the given link to reset your password '.$url.'/Reset.php?token='.$token.'';
			    $headers = 'From: ' . $defaultEmail . "\r\n" .
        		'Reply-To: ' . $defaultEmail . "\r\n" .
        		'X-Mailer: PHP/' . phpversion();
				//Builds email to send to the registered.
    			mail($to, $subject, $message, $headers);
				echo '<h2> Password Reset. </h2>
				<fieldset> <p>An email has been sent to the email provided! Check it and follow instructions to reset your password.
				It may take 3-5 minutes to receive the email!</p></fieldset>';
				
			} else {
				echo '<h1>Password Reset</h1> <fieldset>Email not registered: <a href="Register.php">Register!</a></fieldset>';
			}
			
		} else {
			Foreach($err as $m)
			{
				echo " $m <br />";
			} echo "Please correct the errors.";
			$form = '<h1>Password Reset</h1>
				<fieldset>	
					<form action="PasswordHelp.php" id="regiForm" method="post">
					<p>To reset your password, just enter the email address you use to log into your JCI account. <br />
						This may be the email address you used when you first registered on JCI.<br /><br />
						Email Address: <input type="text" name="email" size="15" maxlength="50" /></p>		
						<input type="submit" value="Reset My Password" />
					</form>
				</fieldset>';	  
		}
  } else {
  	$form = '<h1>Password Reset</h1>
				<fieldset>	
					<form action="PasswordHelp.php" id="regiForm" method="post">
					<p>To reset your password, just enter the email address you use to log into your JCI account. <br />
						This may be the email address you used when you first registered on JCI.<br /><br />
						Email Address: <input type="text" name="email" size="15" maxlength="50" /></p>		
						<input type="submit" value="Reset My Password" />
					</form>
				</fieldset>';
  }
?>
<?php echo "$form"; ?>
<?php 
include ("includes/Footer.php");
?>
