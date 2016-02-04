<?php
	// Put code here for functions that will help downloading and uploading files
	
	// Mark Bowman: This function will upload a file from the host's computer to the server.
		
		if($_SERVER["REQUEST_METHOD"] == "POST") {
		
			if(isset($_FILES["uploadedFile"])){
				
				$uploadedFile = $_FILES["uploadedFile"];
				
				// TODO: Mark Bowman use a function to check the file type here
				if($uploadedFile) {
				//	move_uploaded_file($uploadedFile, $destination);
				echo("File uploaded");
				}
			}
			
			else {
				echo("You must attach a file before submitting.");
			}
		}

?>
