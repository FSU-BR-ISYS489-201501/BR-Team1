<?php
 /*********************************************************************************************
  * Original Author: Donald Dean
  * Date of origination: 04/15/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: The purpose of this page is to collect data for file management.
  * Credit: http://php.net/manual/en/index.php
  ********************************************************************************************/
  	$page_title = 'Edit Profile';
	include ("includes/LoginHelper.php");
	include ("includes/ValidationHelper.php");
	include ("includes/Header.php");
	require ('../DbConnector.php');
	session_start();
	$r=$_SESSION['UserId'];
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$err = array();
		$fname = mysqli_real_escape_string($dbc, trim($_POST['fName']));
		$lname = mysqli_real_escape_string($dbc, trim($_POST['lName']));
		$suffix = mysqli_real_escape_string($dbc, trim($_POST['suffix']));
		$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
		$title = mysqli_real_escape_string($dbc, trim($_POST['title']));
		$institution = mysqli_real_escape_string($dbc, trim($_POST['university']));
		$membercode = mysqli_real_escape_string($dbc, trim($_POST['memberID']));
		$prefix = mysqli_real_escape_string($dbc, trim($_POST['prefix']));
		if (empty($email)) {
			$err[] = 'You forgot to enter your email.';
		} elseif (checkEmail($_POST['email']) == 0) {
			$err[] = 'The email submitted doesnt have the correct syntax.';
		} elseif (1 == 2){
			
		} else {
			$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
			$testQ = "SELECT Email FROM Users WHERE Email = '$email' AND UserId != $r;";
			$result = mysqli_query($dbc, $testQ);
			if (mysqli_num_rows($result) > 0){
				$err[] = 'This email is already registered!';
			} else {
				// $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
			}
		}
		if (empty($fname)) {
			$err[] = 'You forgot to enter your first name.';
		}
		if (empty($lname)) {
			$err[] = 'You forgot to enter your last name.';
		}
		If(empty($err)) {
			//Creat the query that dumps info into the DB.
			$updatequery = "UPDATE users SET  Prefix = '$prefix', FName = '$fname', LName = '$lname', Suffix = '$suffix', Email = '$email', Title = '$title', 
			Employer = '$institution', MemberCode = '$membercode' WHERE UserId = $r;";
			$run = @mysqli_query($dbc, $updatequery)or die("Errors are ".mysqli_error($dbc));
			echo "Your profile has been updated!";
			}
			else {
			//List each Error msg that is stored in the array.
			Foreach($err as $m)
			{
				echo " $m <br />";
			} echo "Please correct the errors.";
		
		}
	}
	
			
	
		// Borrowed idea from Mark's ManageAnnouncements
		$query = "SELECT Prefix, FName, LName, Suffix, Email, Employer, Title, MemberCode FROM users WHERE UserId = $r;";
		$IdQuery = "SELECT UserId FROM users WHERE UserId = $r;";
		$idSelectQuery = @mysqli_query($dbc, $IdQuery);
		$selectQuery = @mysqli_query($dbc, $query);
		$row = mysqli_fetch_array($selectQuery, MYSQLI_NUM);
		
		//The following variable set the starting column from our query array $row.
		$a = 1;
		//this code was inspired by Wiiliam
		//The previous variable is increased in value to assign the appropriate values from our query array to each variable.
		$FName = "{$row[$a]}";
		$LName = "{$row[$a+1]}";
		$Suffix = "{$row[$a+2]}";
		$Email = "{$row[$a+3]}";
		$Institution = "{$row[$a+4]}";
		$Title = "{$row[$a+5]}";
		$MemberCode = "{$row[$a+6]}";
		
	
		

?>
	<h1>Edit Profile</h1>
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
		<p>* First Name: <input type="text" name="fName" size="15" maxlength="50" value="<?php echo $FName; ?>" /></p>
		<p>* Last Name: <input type="text" name="lName" size="15" maxlength="50" value="<?php echo $LName; ?>" /></p>
		<p>Suffix: <input type="text" name="suffix" size="10" maxlength="10" value="<?php echo $Suffix; ?>" /></p>
		<p>* Email Address: <input type="text" name="email" size="20" maxlength="100" value="<?php echo $Email; ?>"  /> </p>
		<p>Title: <input type="text" name="title" size="15" maxlength="50" value="<?php echo $Title; ?>" /></p>
		<p>Institution: <input type="text" name="university" size="20" maxlength="100" value="<?php echo $Institution; ?>" /></p>
		<p>SCR Member ID: <input type="text" name="memberID" size="15" maxlength="50" value="<?php echo $MemberCode; ?>" /></p>
		<p>* Required</p>
		<p><input type="submit" value="Update"  class="button4"</p>
	</fieldset>

</form>
	
<?php

	include('includes/Footer.php');
?>