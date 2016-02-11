
<?php

/*
 *  Author: Faisal Alfadhli
 * Date : 02/10/2016
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class
 * ISYS489: Ferris State University.
 * from code I used and learned in ISYS288.
 * We used Larry Uldman's PHP book
 * http://www.larryullman.com/category/php/
 * www.W3schools.com/php/
 * Tizag.com/category/php/
 *Tutorialspoints.com/php/
 * www.php.net
 
*/

	include ("includes/Header.php");
 

	// define variables and set to empty values
	$nameErr; 
	$emailErr;
	$fileErr;
	$name; 
	$email;
	$file;

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["name"])) {
     		$nameErr = "Name is required";
   		} 
	else {
		$name = test_input($_POST["name"]);
    		// check if name only contains letters and whitespace
     		if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
       			$nameErr = "Only letters and white space allowed"; 
     		}
   }
   
   if (empty($_POST["email"])) {
 		// call check email function
   		CheckEmail();
   }
     
	 
	if (empty($_POST["filedoc"])) {
		// call check file type and siez function 
		CheckFile();
	   
	 	 // send email notification 
		mail($email,"File uploaded",$msg);
	}
	}

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>

	<!-- Create html Form -->
	<h2>Fill The Form</h2>
		<p><span class="error">* required field.</span></p>

	<form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
 
		E-mail: <input type="text" name="email">
			<span class="error">* <?php echo $emailErr;?></span>
		<br><br>
   		Title: <input type="text" name="name">
			<span class="error">* <?php echo $nameErr;?></span>
		<br><br>
   		Keyword:<textarea name="comment" rows="5" cols="40"></textarea>
		<br><br>
   

		<br /><br />
	<!-- use for uploading fils -->
	<label for='uploaded_file'>Select only doc File To Upload:</label>  
	<br><br>  
	<input type="file" name="filedoc" id="filedoc" /><br />	<br />
		<span class="error"><?php echo $fileErr;?></span>    
	<input type="submit" value="Submit" name="upload_doc" />
	<br><br>

	</form>


<?php
	include ("includes/Footer.php");
?>

