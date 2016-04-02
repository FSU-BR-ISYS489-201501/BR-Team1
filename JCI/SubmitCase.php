
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
 * 
 * Revision 1.3: 03/27/2016 Author: Faisal
 * Description of Change: added email fields, and queries to update data into db
 * 
 * Revision 1.3: 04/01/2016 Author: Faisal
 * Description of Change: added Function to dynamicly add file upload buttons if the user requires them.
 *  NOT FINISHED YET.
 ********************************************************************************************/
	//Ben Brackett: Call checkLogin function
	include ("includes/LoginHelper.php");
	include ("includes/ValidationHelper.php");
	include ("includes/Header.php");
	include("includes/FileHelper.php");
	
	//Grab the db connector.
 	require ('../DbConnector.php');
	
	//Set up as an arrary for errors
	$err = array();
	// define variables
	$userid = array();
	$ids = array();
	$types = array();
	$critIncidentId;
	$authorFname; 
	$authorLname;
	$email;
	$title;
	$keywords;
	$fieldcount = 1;
	$nameCount = 1;
	$keyWordCount = 1;
	$authors = "
		First Name: <input type='text' name='authorFname[0]'><br>
		Last Name: <input type='text' name='authorLname[0]'><br>
		Email: <td><input type='text' name='email[0]' ><br>
		<br>
	";
		
	$keyWords = "
		Key Word: <input type='text' name='keyword[0]'><br>
		<br>
	";
	
	if (isset($_GET['fieldcount']) ) {
		$fieldcount = $_GET['fieldcount'];
	} elseif (isset($_POST['fieldcount']) ) {
		$fieldcount = $_POST['fieldcount'];
	}
	
	if (isset($_GET['nameCount'])) {
		$nameCount = $_GET['nameCount'];
	}
	
	if (isset($_GET['keyWordCount'])) {
		$keyWordCount = $_GET['keyWordCount'];
	}
	
	for($a = 1;$a < $nameCount;$a++) {
		$authors = $authors . "
			First Name: <input type='text' name='authorFname[$a]'><br>
			Last Name: <input type='text' name='authorLname[$a]'><br>
			Email: <td><input type='text' name='email[$a]' ><br>
		";
	}
	
	for($a = 1;$a < $keyWordCount;$a++) {
		$keyWords = $keyWords . "
			Key Word: <input type='text' name='keyword[$a]'><br>
		";
	}
	
	// Only do this stuff if the submitCase button was clicked
	if(isset($_POST['submitCase'])){
		if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
			// make this check all of the authors names being submitted.
			// require 1 author, but allow multiple. if 1 author isn't input, show an error. If 2 authors aren't, don't show an error, but don't include that information in the database.
			for($i = 0; $i < 4; $i++) {
				//$i > means at least 1 author is input.
				// Mark Bowman: Changed authors[] to author[]			
				if (empty($_POST["authorFname"][$i]) && ($i==0)) {
					$err[]= 'Failed, at least one name is required';
				}
				// check if name only contains letters and whitespace
				else if (!preg_match("/^[a-zA-Z ]*$/", $_POST["authorFname"][$i])) {
					$err[]= 'Only letters and white space are allowed';	
				}
			} 
			for($i = 0; $i < 4; $i++) {
				//$i > means at least 1 author is input.
				// Mark Bowman: Changed authors[] to author[]			
				if (empty($_POST["authorLname"][$i]) && ($i==0)) {
					$err[]= 'Failed, at least one name is required';
				}
				// check if name only contains letters and whitespace
				else if (!preg_match("/^[a-zA-Z ]*$/", $_POST["authorLname"][$i])) {
					$err[]= 'Only letters and white space are allowed';	
				}
			} 
			for($i = 0; $i < 4; $i++) {
				//$i > means at least 1 author is input.
				// Mark Bowman: Changed authors[] to author[]
				if (empty($_POST["email"][$i]) && ($i==0)) {
					$err[]= 'Type your email, please..!';
				}
				// check if email not empty and is email
				else if(!empty($_POST["email"][$i]) && !checkEmail($_POST["email"][$i])){
					$err[]= 'Type a valid email address..!';
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
			// make this check all of the files being uploaded.
			// Mark Bowman: Changed fileDoc[] to uploadedFile[].
			for($i = 0; $i < ($fieldcount - 1); $i++) {
				if (!file_exists($_FILES["uploadedFile"]['tmp_name'][$i]) && ($i==0) ) {
					$err[]= 'Failed, you must upload at least one file';
				} else {
					If (file_exists($_FILES["uploadedFile"]['tmp_name'][$i])){
						// call checkFile function
						if (checkFile(($_FILES["uploadedFile"]["type"][$i]), $_FILES['uploadedFile']['size'][$i]) == 0) {
							$err[] = "File number $i is not a word document.";
						}
					}
				}
			}
			//Ben Brackett: Call checkLogin function
			if (!isset($_SESSION['UserId'])) {
				$err[]= 'User is not logged in..!';
			}
			// Mark Bowman: This block of code checks to see if the $err array has any contents.
			// If it does not, it uploads the files to the database and file server. It then sends
			// a confirmation email to the submitting author and the editor on file and then displays
			// a message on the page. If the $err array contains errors, it prints them on the screen.
			if (empty($err)) {
				// Faisal Alfadhli: i add code lines 126-203 for insert database the user input for submit case.
				for($i = 0; $i < 4; $i++) {
					//get first name with current index value of $i
					$authorFname = $_POST["authorFname"][$i];
					//get last name with current index value of $i
					$authorLname = $_POST["authorLname"][$i];
					//get email address with current index value of $i
					$email = $_POST["email"][$i];
					//see if any user in database has the current email address
					$query = "SELECT UserId FROM users WHERE Email = '$email';";
					//Run the query...
					$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
					//set results of query to $row variable
					$row = mysqli_fetch_array($run, MYSQLI_NUM);
					//if query unsuccessful ...
					If (!$run){
						//tell user ...
						echo 'There was an error selecting a user by email. Please try again!';
					//if query successful ...
					} else {
						//and current array index of authorFname is not empty ...
						if(!empty($_POST["authorFname"][$i])) {
							//and $row is empty ...
							If (empty($row)){
								//build insert query for user data ...
								$query = "INSERT INTO users (FName, LName, Email)
										  VALUES ('$authorFname', '$authorLname', '$email');";
								//Run the query...
								$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
								//if query not successful ...
								If (!$run){
									//tell user ...
									echo 'There was an error inserting a user. Please try again!';
								//if query successful ...
								} else{
									//append inserted users userid from database to userid array with mysqli_insert_id function
									array_push($userid, mysqli_insert_id($dbc));
								}
							// if $row is not empty
							} else {
								//append userid from $row to $userid array
								array_push($userid, $row[0]);
							}
						}					
					}
				}
				//set $title
				$title = $_POST["title"];
				//build insert query
				$query = "INSERT INTO criticalincidents (Title)
						  VALUES ('$title');";
				//Run the query...
				$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
				//use mysqli_insert_id function to set $critIncidentId variable
				$critIncidentId = mysqli_insert_id($dbc);
				//if query not successful ...
				If (!$run){
					//tell user ...
					echo 'There was an error with the submission. Please try again!';
				}
				//Loop through keywords ...
				for($i = 0; $i < 5; $i++) {
					//if current keyword of index $i is not empty ...
					if (!empty($_POST["keyword"][$i])) {
						//set $keywords variable ...
						$keywords = $_POST['keyword'][$i];
						// build insert query ...
						$query = "INSERT INTO keywords (CriticalIncidentId, CIKeyword)
							      VALUES ('$critIncidentId', '$keywords');";
						//Run the query...
						$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
						//if query unsuccessful ...
						If (!$run){
							//tell user ...
							echo 'There was an error with the submission. Please try again!';
						}
					}
				}
				
				for($a = 0;$a < $fieldcount;$a++) {
					array_push($ids, $critIncidentId);
					array_push($types, 'Word');
				}
				
				switch (uploadFile($dbc, "uploadedFile", "../uploads/", $ids, $types)) {
					case 0:
						echo 'Upload failed. Contact the system administrator.';
						break;
					case 1:
						{
							// Dr. Herrington helped me with this block	
							// loop authers Fname and LName to post them in usermessage and editorMsg.
							$userMsg = "Authors: ";
							for($i = 0; $i < 4; $i++) {
								// this code was inspired by William.
								if ($i=3){
									$userMsg = $userMsg . $_POST['authorFname'][$i] . " ";
								} else {
									$userMsg = $userMsg . $_POST['authorFname'][$i] . ", ";
								}							   
                            }
							$userMsg = $userMsg . ".Thank you for your submission! You will be contacted shortly.";
							
							// a message to be sent to editor
							$editorMsg = "Authors: ";
							for($i = 0; $i < 4; $i++) {
								if ($i=3){
									$editorMsg = $editorMsg . $_POST['authorFname'][$i] . " ";
								} else {
									$editorMsg = $editorMsg . $_POST['authorFname'][$i] . ", ";
								}							   
                            }
							$editorMsg = $editorMsg . " made a new submission.";
							
							// email header
							$header = "do-not-reply@jci.com\r\n";

							// send email notification to an author
							for($i = 0; $i < 4; $i++) {
								if(!empty($_POST["email"][$i])) {
							       $rtnVal = mail($_POST['email'][$i], "File uploaded, thank you..!" ,$userMsg, $header);
							    }
							}

							if ($rtnVal == true) {
								// send email notification to editor
								$rtnVal = mail("alfadhf@ferris.edu", "New Submission", $editorMsg);

								if ($rtnVal == true) {
									// display Thank you Message
									header("Location: http://localhost/jci/Index.php?success=Y"); 
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
			} else {
				for($i = 0; $i < count($err); $i++) {
					echo "$err[$i] <br />";
				}
			}
		}
	}
	// assign uploadFileFields function return results to the variable upfileBody
	$upfileBody = uploadFileFields($fieldcount);
	?>
	
	<!-- Create html Form -->
	<h2>Fill The Form</h2>
	
	<form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" multiple = "multiple">
		<h3>Author(s):</h3>
			<?php echo $authors ?>
			<a href='SubmitCase.php?nameCount=<?php echo $nameCount + 1 ?>&keyWordCount=<?php echo $keyWordCount ?>'>Add Author</a>
		</table>
		<br><br>
		<h3>Critical Incident Title:</h3>
		Title: <input type="text" name="title" value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>">
		<br><br>
		<h3>Key Word(s):</h3>
			<?php echo $keyWords ?>
			<a href='SubmitCase.php?nameCount=<?php echo $nameCount ?>&keyWordCount=<?php echo $keyWordCount + 1?>'>Add Key Word</a>
		   
		
		<br><br>
		<!-- use for uploading fils -->
		<h3>File(s)</h3>
		<label for='uploadedFile'>Select only Microsoft Word document files to upload:</label>  
		<br><br>  
		<!-- loop through results of upfileBody from our uploadfilefields function and display them on webpage -->
		<?php foreach($upfileBody as $result) { echo $result, '<br>'; } ?>
		<br><br>
		<input name="submitCase" type="submit" value="Submit" name="uploadedFile" />
		<br><br>
	
	</form>
	
	
<?php

	/*function authorFields(){
		for($i = 0; $i < 4; $i++) {
			//get first name with current index value of $i
			$authorFname = $_POST["authorFname"][$i];
			//get last name with current index value of $i
			$authorLname = $_POST["authorLname"][$i];
			//get email address with current index value of $i
			$email = $_POST["email"][$i];
		}
	}*/
	
	// Function to dynamicly add file upload buttons if the user requires them
	function uploadFileFields($fieldcount){
		// create array to hold form fields
		$uff = array();
		// if field count is less than 7 do stuff
		if ($fieldcount < 7){
			// if fieldcount is greater than 1 do stuff
			If ($fieldcount > 1){
				// loop and add fields to the array
				for($a = 0;$a < $fieldcount;$a++) {
					$field = "<input type='file' name='uploadedFile[]' />";
					array_push($uff, $field);
				}
				// increase field count as we add more fields to the array
				$fieldcount = $fieldcount + 1;
				// hidden field to hold value of our fieldcount
				$field = "<input type='hidden' value='$fieldcount' name='fieldcount' />";
				array_push($uff, $field);
				// add the add field button to the array
				$field = "<input name='addfield' id='add' type='submit' value='Add File'>";
				array_push($uff, $field);
			// if the field count was not greater than 1 then do this stuff
			} else {
				// still have to increase the field count when adding a field
				$fieldcount = $fieldcount + 1;
				// still adding the fields to the array
				$field = "<input type='file' name='uploadedFile[]' />";
				array_push($uff, $field);
				// updating field count variable for the hidden field
				$field = "<input type='hidden' value='$fieldcount' name='fieldcount' />";
				array_push($uff, $field);
				// add that add file button
				$field = "<input name='addfield' id='add' type='submit' value='Add File'>";
				array_push($uff, $field);
			}
		// if field count is greater than 7 do this stuff
		} else {
			// loop and add all the fields to the array
			for($a = 0;$a < $fieldcount - 1;$a++) {
					$field = "<input type='file' name='uploadedFile[]' />";
					array_push($uff, $field);
				}
			// here is that hidden field count field again
			$field = "<input type='hidden' value='$fieldcount' name='fieldcount' />";
			array_push($uff, $field);
			// and that add file button again 
			$field = "<a href='SubmitCase.php?id='add'>Add File</a>";
			array_push($uff, $field);
			// finally warn user they can only upload a maximum of 6 files 
			$field = "You can only upload a maximum of 6 files per submission.";
			array_push($uff, $field);
		}
		// return all this stuff we did
		return $uff;
	}
?>
<?php
include ("includes/Footer.php");
?>