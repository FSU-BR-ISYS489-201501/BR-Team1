<?PHP
/*********************************************************************************************
 * Original Author: Benjamin Brackett
 * Date of origination: 02/09/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: Login code
 * Credit: https://github.com/Goatella/Simple-PHP-Login/blob/master/login.php
 *
 * Revision1.1: 02/13/2016 Author: Benjamin Brackett
 * Description of change. Changed a lot to make it sessions instead of cookies
 ********************************************************************************************/


// Set the database access information as constants:
DEFINE ('DB_USER', 'db_connector');
DEFINE ('DB_PASSWORD', 'rV);R8PriM*8');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'isys489c-BT1-JCI');


//Connects to your Database 
$conect = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );


// Set the encoding...
mysqli_set_charset($dbc, 'utf8');

session_start(); 

//start tracking user
$_SESSION['user'] = $user_id;

//Checks if someone is logged in
 if (isset($_SESSION['user'])) {
   // logged in...WHERE TO DIRECT?
   {
    header("Location:index.php"); 
 }
 
 
 //if the login form is submitted 
 if (isset($_SESSION['submit'])) {
	// makes sure they filled it in
 	if(!$_SESSION['username']){
 		die('You did not fill in a username.');
 	}
 	if(!$_SESSION['pass']){
 		die('You did not fill in a password.');
 	}
 	// checks it against the database
 	if (!get_magic_quotes_gpc()){
 		$_SESSION['email'] = addslashes($_SESSION['email']);
 	}
 	$check = mysqli_query($conect, "SELECT * FROM users WHERE username = '".$_SESSION['username']."'")or die(mysql_error());
 //Gives error if user dosen't exist
 $check2 = mysqli_num_rows($check);
 if ($check2 == 0){
	die('That user does not exist in our database.<br /><br />If you think this is wrong <a href="login.php">try again</a>.');
}
while($info = mysqli_fetch_array( $check )){
	$_SESSION['pass'] = stripslashes($_SESSION['pass']);
 	$info['password'] = stripslashes($info['password']);
 	$_SESSION['pass'] = md5($_SESSION['pass']);
	//gives error if the password is wrong
 	if ($_SESSION['pass'] != $info['password']){
 		die('Incorrect password, please <a href="login.php">try again</a>.');
 	}
	
	
?>

 <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 

 <table border="0"> 

 <tr><td colspan=2><h1>Login</h1></td></tr> 

 <tr><td>Username:</td><td> 

 <input type="text" name="username" maxlength="40"> 

 </td></tr> 

 <tr><td>Password:</td><td> 

 <input type="password" name="pass" maxlength="50"> 

 </td></tr> 

 <tr><td colspan="2" align="right"> 

 <input type="submit" name="submit" value="Login"> 

 </td></tr> 

 </table> 

 </form> 

<?php
include ("includes/Footer.php");
?>				  	 