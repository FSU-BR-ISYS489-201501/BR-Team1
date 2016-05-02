
<?php
/*********************************************************************************************
 * Original Author: Faisal Alfadhli
 * Date of origination: 02/10/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: This page is used to let an author to submit cases for review. 
 * Credit: I learnd many of this code from Larry Uldman's PHP book and these websites: 
 * https://www.youtube.com/channel/UCzEYvv6Ciw_fnRIqK0cFdRQ
 *  tutor: William Quigley, Email : mnewrath@gmail.com
 *  www.W3schools.com/php/
 * Tizag.com/category/php/
 * Tutorialspoints.com/php/
 * www.php.net
 *
 * Revision 1.1: 02/14/2016 authors: Faisal $ Mark 
 * Mark:edited some peices of code and still not finish. Faial: edited the variables 
 * names added input for title and include the some function. 
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
 * Revision 1.5: 03/27/2016 Author: Faisal
 * Description of Change: added email fields, and queries to update data into db
 * 
 * Revision 1.6: 04/01/2016 Author: Faisal
 * Description of Change: added Function to dynamicly add file upload buttons if the user requires them.
 * 
 * Revision 1.7: 04/02/2016 Author: Mark Bowman
 * Description of Change: I redesigned most of the file to allow dynamic input of authors and key words.
 * 
 * Revision 1.8: 04/05/2016 Author: Mark Bowman
 * Description of Change: I redesigned the SQL queries to insert all of the dynamic input. I also assigned
 * the upcoming JournalId to the Critical Incident and the Files. I also made the system input new users
 * if an author didn't exist in the database.
 * 
 * Revision 1.9: 04/18/2016 Author: Mark Bowman
 * Description of Change: I added code to require a user to be an author or an editor.
 * 
 ********************************************************************************************/

	session_start();
	//Grab the db connector.
	require ('../DbConnector.php');
	include ("includes/LoginHelper.php");
	include ("includes/ValidationHelper.php");
	include ("includes/Header.php");
	include("includes/FileHelper.php");
	if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor' || $_SESSION['Type'] == 'Author' || $_SESSION['Type'] == 'author') {
		
		$currentDate = date("Y-m-d");
		
		// Mark Bowman: This gets the current volume in development.
		$submissionWindowQuery = 	"SELECT OpenDate, CloseDate
						 	FROM journalofcriticalincidents
						 	WHERE InDevelopement = 1;";
		// The idea for this code was inspired by Shane.
		$submissionWindowSelectQuery = @mysqli_query($dbc, $submissionWindowQuery);
		if ($row = mysqli_fetch_array($submissionWindowSelectQuery, MYSQLI_ASSOC)) {
			$openDate = $row['OpenDate'];
			$closeDate = $row['CloseDate'];
			if (isset($openDate) && isset($closeDate)) {
				if ($currentDate > $openDate && $currentDate < $closeDate) {
					
					//Set up as an arrary for errors
					$err = array();
					// define variables
					$userid = array();
					$ids = array();
					$types = array();
					$journalIds = array();
					$critIncidentId;
					$authorFname; 
					$authorLname;
					$email;
					$title;
					$keywords;
					$fieldcount = 1;
					
					// Mark Bowman: This gets the current volume in development.
					$nextVolumeIdQuery = 	"SELECT JournalId
									 	FROM journalofcriticalincidents
									 	WHERE InDevelopement = 1;";
					// The idea for this code was inspired by Shane.
					$nextVolumeIdSelectQuery = @mysqli_query($dbc, $nextVolumeIdQuery);
					if ($row = mysqli_fetch_array($nextVolumeIdSelectQuery, MYSQLI_ASSOC)) {
						$latest = $row['JournalId'];
					}
					
					// Mark Bowman: These variables track the number of fields.
					$nameCount = 1;
					$keyWordCount = 1;
					$fileCount = 1;
					
					// Mark Bowman: These variables generate the HTML for input fields.
					$authors = "
						First Name: <input type='text' name='authorFname[0]'>
						Last Name: <input type='text' name='authorLname[0]'>
						Email: <td><input type='text' name='email[0]' ><br>
						<br>
					";
						
					$keyWords = "
						<input type='text' name='keyword[0]'><br>
					";
					
					$files = "
						<input type='file' name='uploadedFile[]' /><br>
					";
					
					// Mark Bowman: These check to see if variables are set in order to retrive values.
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
					
					if (isset($_GET['fileCount'])) {
						$fileCount = $_GET['fileCount'];
					}
					
					// Mark Bowman: These add additional text fields to the form, based on the retrieved values.
					for($a = 1;$a < $nameCount;$a++) {
						$authors = $authors . "
							First Name: <input type='text' name='authorFname[$a]'>
							Last Name: <input type='text' name='authorLname[$a]'>
							Email: <td><input type='text' name='email[$a]' ><br>
							<br>
						";
					}
					
					for($a = 1;$a < $keyWordCount;$a++) {
						$keyWords = $keyWords . "
							<input type='text' name='keyword[$a]'><br>
						";
					}
					
					for($a = 1;$a < $fileCount;$a++) {
						$files = $files . "
							<input type='file' name='uploadedFile[]' /><br>
						";
					}
					
					// Only do this stuff if the submitCase button was clicked
					if(isset($_POST['submitCase'])){
						if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
							// make this check all of the authors names being submitted.
							// require 1 author, but allow multiple. if 1 author isn't input, show an error. If 2 authors aren't, don't show an error, but don't include that information in the database.
							for($i = 0; $i < $nameCount; $i++) {
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
							for($i = 0; $i < $nameCount; $i++) {
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
							for($i = 0; $i < $nameCount; $i++) {
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
							for($i = 0; $i < $keyWordCount; $i++) {
								if(empty($_POST["keyword"][$i]) && ($i==0)) {
									$err[]= 'Type the keywords, please..!';
								}
							}
							// make this check all of the files being uploaded.
							// Mark Bowman: Changed fileDoc[] to uploadedFile[].
							for($i = 0; $i < ($files); $i++) {
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
								// Mark Bowman: I changed the static number to a variable.
								for($i = 0; $i < $nameCount; $i++) {
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
									if (!$run){
										//tell user ...
										echo 'There was an error selecting a user by email. Please try again!';
									//if query successful ...
									} else {
										//and current array index of authorFname is not empty ...
										if(!empty($_POST["authorFname"][$i])) {
											//and $row is empty ...
											if (empty($row)){
												//build insert query for user data ...
												$query = "INSERT INTO users (FName, LName, Email)
														  VALUES ('$authorFname', '$authorLname', '$email');";
												//Run the query...
												$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
												//if query not successful ...
												if (!$run){
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
								// Mark Bowman: I added the JournalId to the criticalincident table insert query.
								$query = "INSERT INTO criticalincidents (Title, JournalId)
										  VALUES ('$title', $latest);";
								//Run the query...
								$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
								//use mysqli_insert_id function to set $critIncidentId variable
								$critIncidentId = mysqli_insert_id($dbc);
								//if query not successful ...
								if (!$run){
									//tell user ...
									echo 'There was an error with the submission. Please try again!';
								}
								
								
								// Mark Bowman: I changed the static number to a variable.
								for($i = 0; $i < count($userid); $i++) {
									//set $keywords variable ...
									$user = $userid[$i];
									// build insert query ...
									$query = "INSERT INTO authorcases (CriticalIncidentId, UserId)
										      VALUES ('$critIncidentId', '$user');";
									//Run the query...
									$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
									//if query unsuccessful ...
									if (!$run){
										//tell user ...
										echo 'There was an error with the submission. Please try again!';
									}
								}
								
								//Loop through keywords ...
								// Mark Bowman: I changed the static number to a variable.
								for($i = 0; $i < $keyWordCount; $i++) {
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
										if (!$run){
											//tell user ...
											echo 'There was an error with the submission. Please try again!';
										}
									}
								}
								
								for($a = 0;$a < $fileCount;$a++) {
									array_push($ids, $critIncidentId);
									array_push($types, 'Word');
									array_push($journalIds, $latest);
								}
								
								switch (uploadFile($dbc, "uploadedFile", "../uploads/", $ids, $types, $journalIds)) {
									case 0:
										echo 'Upload failed. Contact the system administrator.';
										break;
									case 1:
										{
											// Dr. Herrington helped me with this block	
											// loop authers Fname and LName to post them in usermessage and editorMsg.
											$userMsg = "Authors: ";
											for($i = 0; $i < $nameCount; $i++) {
												// this code was inspired by William.
												if ($i=$nameCount - 1){
													$userMsg = $userMsg . $_POST['authorFname'][$i] . " ";
												} else {
													$userMsg = $userMsg . $_POST['authorFname'][$i] . ", ";
												}							   
				                            }
											$userMsg = $userMsg . ".Thank you for your submission! You will be contacted shortly.";
											
											// a message to be sent to editor
											$editorMsg = "Authors: ";
											for($i = 0; $i < $nameCount; $i++) {
												if ($i=$nameCount - 1){
													$editorMsg = $editorMsg . $_POST['authorFname'][$i] . " ";
												} else {
													$editorMsg = $editorMsg . $_POST['authorFname'][$i] . ", ";
												}							   
				                            }
											$editorMsg = $editorMsg . " made a new submission.";
											
											// email header
											$header = "do-not-reply@jci.com\r\n";
											
											// send email notification to an author
											for($i = 0; $i < $nameCount; $i++) {
												if(!empty($_POST["email"][$i])) {
											       $rtnVal = mail($_POST['email'][$i], "File uploaded, thank you..!" ,$userMsg, $header);
											    }
											}
				
											if ($rtnVal == 1) {
												// send email notification to editor
												$rtnVal = mail("alfadhf@ferris.edu", "New Submission", $editorMsg, $header);
												if ($rtnVal == 1) {
													// display Thank you Message
													header("Location: http://br-t1-jci.sfcrjci.org/Index.php?success = Y"); 
												}  else  {
													echo "ERROR: Message not sent to editor.";
												}
											} else {
												echo "ERROR: Messages not sent.";
											}
											echo '<br> Thank you for your submission. You will recieve an email message within the next five minutes. <br>';
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
				}
				else {
					echo "Please return during $openDate and $closeDate in order to submit a Critical Incident for review.";
					include ("includes/Footer.php");
					exit;
				}
			}
			else {
				echo "Please return at a later date in order to submit a Critical Incident for review.";
				include ("includes/Footer.php");
				exit;
			}
		}
	}
	else {
		echo "In order to submit a Critical Incident for review, you must be logged in.";
		include ("includes/Footer.php");
		exit;
	}
?>
	
	<!-- Create html Form -->
	<h2>Submit a Case</h2>
	
	<form method="post" enctype="multipart/form-data"  multiple = "multiple">
		<fieldset>
			Select the number of authors, keywords, and files before filling out the form.
			<br>
			<br>
		<h4>Critical Incident Title:</h4>
		Title: <input type="text" name="title" value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>">
		<br>
		<h4>Author(s):</h4>
			<?php echo $authors ?>
			<a href='SubmitCase.php?nameCount=
			<?php echo $nameCount + 1 ?>&keyWordCount=<?php echo $keyWordCount ?>&fileCount=<?php echo $fileCount ?>' class = 'button4'>Add Author</a>
		</table>
		<br>
		<br>
		<br>
		<h4>Key Word(s):</h4>
			<?php echo $keyWords ?>
			<a href='SubmitCase.php?nameCount=
			<?php echo $nameCount ?>&keyWordCount=<?php if ($keyWordCount < 5) {echo $keyWordCount + 1;} else {echo $keyWordCount;}?>&fileCount=
			<?php echo $fileCount ?>' class = 'button4'>Key Word</a>
		<br>
		<br>
		<br>
		<!-- use for uploading fils -->
		<h4>File(s)</h4>
		<br><br>  
		<!-- loop through results of upfileBody from our uploadfilefields function and display them on webpage -->
		<!-- <?php foreach($upfileBody as $result) { echo $result, '<br>'; } ?> -->
		<label for='uploadedFile'>Select only Microsoft Word document files to upload:</label> 
		<br>
		<br>
		<?php echo $files ?>
		<br>
		<br>
		<a href='SubmitCase.php?nameCount=<?php echo $nameCount ?>&keyWordCount=<?php echo $keyWordCount ?>&fileCount=
			<?php if ($fileCount < 6) {echo $fileCount + 1;} else {echo $fileCount;}?>' class = 'button4'>Add a File</a> 
		<br>
		<br>
		<input name="submitCase" class = "button5" type="submit" value="Submit" name="uploadedFile" />
		</fieldset>
	</form>
<?php
	include ("includes/Footer.php");
?>