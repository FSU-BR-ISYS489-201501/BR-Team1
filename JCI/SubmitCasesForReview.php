
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
	
	//TODO: Set up as an arrary for errors
	$nameErr; 
	$emailErr;
	$fileErr;
	
	$name; 
	$email;
	$file;
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		//TODO: make this check all of the authors names being submitted.
		//TODO: require 1 author, but allow multiple. if 1 author isn't input, show an error. If 2 authors aren't, don't show an error, but don't include that information in the database.
		for($i = 0; $i < 4; $i++) {
			if (empty($_POST["author[$i]"])) {
				$nameErr = "Name is required";
			}
			else {
			// check if name only contains letters and whitespace
				if (!preg_match("/^[a-zA-Z ]*$/", $_POST["author[$i]"])) {
					$nameErr = "Only letters and white space allowed"; 
				}
			}
		} 
		if (!empty($_POST["email"])) {
			// call check email function
			CheckEmail($_POST["email"]);
		}
		else {
		   	$emailErr = "Email field is empty";
		}
		     
		if (!empty($_POST["filedoc"])) {
			// call check file type and siez function 
			CheckFile();
			
			//TODO: make this check all of the files being uploaded.
		 	 // send email notification 
			mail($email,"File uploaded",$msg);
		}
	}
	
	// function testInput($data) {
		// $data = trim($data);
		// $data = stripslashes($data);
		// $data = htmlspecialchars($data);
		// return $data;
	// }
	?>
	
	<!-- Create html Form -->
	<h2>Fill The Form</h2>
	
	<form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" multiple = "multiple">
	 
		Authors: <input type="text" name="author[]">
		<input type="text" name="author[]">
		<input type="text" name="author[]">
		<input type="text" name="author[]">
		<br><br>
		Title: <input type="text" name="title">
		<br><br>
		Keyword:<input type="text" name="keyword1">
		Keyword:<input type="text" name="keyword2">
		Keyword:<input type="text" name="keyword3">
		Keyword:<input type="text" name="keyword4">
		Keyword:<input type="text" name="keyword5">
		<br><br>
		   
		
		<br><br>
		<!-- use for uploading fils -->
		<label for='uploadedFile'>Select only doc File To Upload:</label>  
		<br><br>  
		<input type="file" name="filedoc[]" />
		<input type="file" name="filedoc[]" />
		<input type="file" name="filedoc[]" />
		<input type="file" name="filedoc[]" />
		<input type="file" name="filedoc[]" />
		<br><br>
		<input type="submit" value="Submit" name="uploadedFile" />
		<br><br>
	
	</form>
	
	
	<?php
		include ("includes/Footer.php");
?>

