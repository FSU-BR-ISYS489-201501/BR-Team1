
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
 * Revision 1.1: 02/14/2016 authors: Faisal $ Mark 
 * Mark:edited some peices of code and still not finish. Faial: edited the variables names added input for title and include the some function. 
 * 
 * Revision 1.2: 02/15/2016 Author: Mark Bowman
 * Description of Change: Altered code to make it funcitonal
 * 
 * Revision 1.3: 02/16/2016 Author: Faisal
 * Description of Change: added email function to send notifications to author and editor
 * 
 * Revision 1.4: 02/20/2016 Author: Ben Brackett
 * Description of change: added checkLogin function and included LoginHelper.php
 ********************************************************************************************/
	//Ben Brackett: Call checkLogin function
	include ("includes/LoginHelper.php");
	include ("includes/ValidationHelper.php");
	include ("includes/Header.php");
	//include("includes/CheckEmail.php");
	//include("includes/CheckEmail.php");
	//Call checkFile function 
	//include ("includes/CheckFile.php");
	
	include("includes/FileHelper.php");
	//Grab the db connector.
 	require ('../DbConnector.php');
	//Set up as an arrary for errors
	$err = array();
	// define variables
	$author; 
	$title;
	$email;
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// make this check all of the authors names being submitted.
		// require 1 author, but allow multiple. if 1 author isn't input, show an error. If 2 authors aren't, don't show an error, but don't include that information in the database.
		for($i = 0; $i < 4; $i++) {
			//$i > means at least 1 author is input.
			// Mark Bowman: Changed authors[] to author[]
			if (empty($_POST["author"][$i]) && ($i==0)) {
                            $err[]= 'Failed, at least one name is required';
			}
			// check if name only contains letters and whitespace
			else if (!preg_match("/^[a-zA-Z ]*$/", $_POST["author"][$i])) {
                            $err[]= 'Only letters and white space are allowed';	
			}
		} 

		// check if the title text has no value 
		if(empty($_POST["title"])) {
			$err[]= 'Type the title, please..!';
		}
		
		// check if the keywords text has no value 
		// Mark Bowman: Changed keywords[] to keyword[]
		for($i = 0; $i < 4; $i++) {
			if(empty($_POST["keyword"][$i]) && ($i==0)) {
				$err[]= 'Type the keywords, please..!';
			}
		}
		
		// ceck if the text has no value
		if(empty($_POST["email"])) {
			$err[]= 'Type your email, please..!';
		}
		else{
			// call the checkEmail function
			if(!checkEmail($_POST["email"])){
				$err[]= 'Type a valid email address..!';
			}
		}
	
		// make this check all of the files being uploaded.
		// Mark Bowman: Changed fileDoc[] to uploadedFile[].
		for($i = 0; $i < 5; $i++) {
			if (!file_exists($_FILES["uploadedFile"]['tmp_name'][$i])) {
				$err[]= 'Failed, you must upload five files';
			}
			else {
				// call checkFile function
				if (checkFile(($_FILES["uploadedFile"]["type"][$i]), 
					$_FILES['uploadedFile']['size'][$i]) == 0) {
						
					$err[] = "File number $i is not a word document.";
				}
				
			}
		}
		//Ben Brackett: Call checkLogin function
		if (!isset($_SESSION['USERID'])) {
				$err[]= 'User is not logged in..!';
			}
		// Mark Bowman: This block of code checks to see if the $err array has any contents.
		// If it does not, it uploads the files to the database and file server. It then sends
		// a confirmation email to the submitting author and the editor on file and then displays
		// a message on the page. If the $err array contains errors, it prints them on the screen.
		if (empty($err)) {
			switch (uploadFile($dbc, "uploadedFile", "../uploads/")) {
				case 0:
					echo 'Upload failed. Contact the system administrator.';
					break;
				case 1:
						{
							// Dr. Herrington helped me with this block 
							$userMsg = "Author: {$_POST['author'][$i]}.Thank you for your submission! You will be contacted shortly.";

							// a message to be sent to editor			
							$editorMsg = "Authors: {$_POST['author'][$i]}. made a new submission.";

							// email header
							$header = "do-not-reply@jci.com\r\n";

							// send email notification to an author 
							$rtnVal = mail($_POST['email'], "File uploaded, thank you..!" ,$userMsg, $header); 

							if ($rtnVal == true) {
								// send email notification to editor
								$rtnVal = mail("alfadhf@ferris.edu", "New Submission", $editorMsg);

								if ($rtnVal == true) {
									// display Thank you Message
									echo "Thank you for your submission, you will recieve an email message shortly."; 
								}  else  {
									echo "ERROR: Message not sent to editor.";
								}
							} else {
								echo "ERROR: Messages not sent.";
							}
					echo 'Upload Successful.';
						}
					break;
					
				case 2:
					echo 'Upload failed. There was an error with the file server.';
					break;
				case 3:
					echo 'Upload failed. There was an error with the database.';
					break;
				case 4:
					echo 'Upload failed. No files were attached.';
					break;
			}
		}
		else {
			for($i = 0; $i < count($err); $i++) {
				echo "$err[$i] <br />";
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
		<label for='uploadedFile'>Select only Microsoft Word document files to upload:</label>  
		<br><br>  
		<input type="file" name="uploadedFile[]" />
		<input type="file" name="uploadedFile[]" />
		<input type="file" name="uploadedFile[]" />
		<input type="file" name="uploadedFile[]" />
		<input type="file" name="uploadedFile[]" />
		<br><br>
		<input type="submit" value="Submit" name="uploadedFile" />
		<br><br>
	
	</form>
	
	
<?php
	include ("includes/Footer.php");
?>

