
<?php
/*********************************************************************************************
 * Original Author: Faisal Alfadhli
 * Date of origination: 02/10/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: This page is used to let an author to submit cases for review. 
 * Credit: I learnd many of this code from Larry Uldman's PHP book and these websites: https://www.youtube.com/channel/UCzEYvv6Ciw_fnRIqK0cFdRQ
 *  www.W3schools.com/php/
 * Tizag.com/category/php/
 * Tutorialspoints.com/php/
 * www.php.net
 *
 * Revision: 02/14/2016 authors: Faisal $ Mark 
 * Mark:edited some peices of code and still not finish. Faial: edited the variables names added input for title and include the some function. 
 ********************************************************************************************/

	include ("includes/Header.php");
	//include("includes/CheckEmail.php");
	include("includes/CheckEmail.php");
	// Call checkFile function 
	include ("includes/CheckFile.php");
	
	//Grab the db connector.
 	require ('../DbConnector.php');
	//Set up as an arrary for errors
	$Err = array();
	// define variables
	$author; 
	$title;
	$fileDoc;
	$email;
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		//TODO: make this check all of the authors names being submitted.
		//TODO: require 1 author, but allow multiple. if 1 author isn't input, show an error. If 2 authors aren't, don't show an error, but don't include that information in the database.
		for($i = 0; $i < 4; $i++) {
			//$i > means at least 1 author is input.
			if (empty($_POST["author[$i]"]) && ($_POST["author[$i]"]==0)) {
				$Err[]= 'Failed, at least one name is required';
			}
			// check if name only contains letters and whitespace
			else if (!preg_match("/^[a-zA-Z ]*$/", $_POST["author[$i]"])){
				$Err[]= 'Only letters and white space allowed';	
			}
			
		} 

		// check if the title text has no value 
		if(empty($_POST["title"])) {
			$Err[]= 'Type the title, please..!';
		}
		
		// check if the keywords text has no value 
		if(empty($_POST["keywords[]"])) {
			$Err[]= 'Type the keywords, please..!';
		}
		
		// ceck if the text has no value
		if(empty($_POST["email"])) {
			$Err[]= 'Type your email, please..!';
		}
		else{
			// call the checkEmail function
			if(checkEmail($_POST["email"])){
				
			}
		}
	
		// make this check all of the files being uploaded.
		for($i = 0; $i < 5; $i++) {
			if (empty($_POST["fileDoc[$i]"])) {
				$Err[]= 'Failed, you must upload five files';
			}
			else {
				// call checkFile function
				checkFile(($_POST["fileDoc[$i]"]));
				
			}
			
		 	// crdeit: https://www.youtube.com/watch?v=lh1UNGA518s
		 	//  $_POST['email'] : allows us to know who to reply to
		 	// uploadedFile is the name of submit button, if a user click submit button the user will recieve notification email.
			if(isset($_POST[uploadedFile])) {
				$msg = 'Authors: ' . $_POST['author[]'] . "\n"
				. 'Email: ' . $_POST['email'];
		 	 	// send email notification 
				mail($email,"File uploaded, thank you..!",$msg);
				//https://nicolamustone.com/2015/01/21/customize-thank-you-message-woocommerce-subscriptions/
				// this is thank you message after submission.
				$successMessage = "Thank you for your submission, you will recieve an email message shortly";
				echo "$successMessage";
			}
		}
	}
	
	
	?>
	
	<!-- Create html Form -->
	<h2>Fill The Form</h2>
	
	<form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" multiple = "multiple">
	 
		Authors: <input type="text" name="author[]">,
		<input type="text" name="author[]">,
		<input type="text" name="author[]">,
		<input type="text" name="author[]">
		<br><br>
		Email: <input type="text" name="email">
		<br><br>
		Title: <input type="text" name="title">
		<br><br>
		Keyword1:<input type="text" name="keyword[]">
		<br><br>
		Keyword2:<input type="text" name="keyword[]">
		<br><br>
		Keyword3:<input type="text" name="keyword[]">
		<br><br>
		Keyword4:<input type="text" name="keyword[]">
		<br><br>
		Keyword5:<input type="text" name="keyword[]">
		<br><br>
		   
		
		<br><br>
		<!-- use for uploading fils -->
		<label for='uploadedFile'>Select only doc File To Upload:</label>  
		<br><br>  
		<input type="file" name="fileDoc[]" />
		<input type="file" name="fileDoc[]" />
		<input type="file" name="fileDoc[]" />
		<input type="file" name="fileDoc[]" />
		<input type="file" name="fileDoc[]" />
		<br><br>
		<input type="submit" value="Submit" name="uploadedFile" />
		<br><br>
	
	</form>
	
	
	<?php
		include ("includes/Footer.php");
?>

