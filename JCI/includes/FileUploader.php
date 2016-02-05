<?php
	// Put code here for functions that will help downloading and uploading files
	
	// Mark Bowman: This function will upload a file from the host's computer to the server.
		
				// Mark bowman: This block contains variables for the browser's temporary name
				// for the uploaded file and the location it is going to be saved to.
				
				for($i = 0; $i < 5; $i++) {
				
					$tempUploadedFileName = $_FILES["uploadedFile"]['tmp_name'][$i];
					$uploadedFileNameSaveLocation = "../uploads/{$_FILES['uploadedFile']['name']["$i"]}";
					
					//Mark Bowman: This block checks if a file has been submitted with the HTML
					// form and then moves it to the final storage location.
					if(file_exists($tempUploadedFileName)) {
						if(move_uploaded_file($tempUploadedFileName, 
							$uploadedFileNameSaveLocation)) {
								echo '<p> Upload was successful! </p>';
						}
						else {
							echo '<p> Upload was not successful! </p>';
						}		
					}
					else {
						echo '<p> You must attach a file first. </p>';
					}
				}
		
?>