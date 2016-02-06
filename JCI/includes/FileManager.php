<?php
	// Put code here for functions that will help downloading and uploading files
	
		// Mark Bowman: This function will upload a file from the host's computer to the server.
		function uploadFile($divName, $fileStorageLocation) {
			
			
			// Mark Bowman: This block is setting a counter for the number of files and how many have been uploaded.
			$fileUplaodSuccessCounter = 0;
			$numberOfFilesUploaded = count($_FILES["$divName"]['tmp_name']);
			$i = 0;
			
			// Mark Bowman: This block is going through all of the uploaded files.
			for($i; $i < $numberOfFilesUploaded; $i++) {
	
			
				// Mark bowman: This block contains variables for the browser's temporary name
				// for the uploaded file and the location it is going to be saved to.
				$tempUploadedFileName = $_FILES["$divName"]['tmp_name'][$i];
				$uploadedFileNameSaveLocation = $fileStorageLocation . "{$_FILES["$divName"]['name']["$i"]}";
				
				
				// Mark Bowman: This block checks if a file has been submitted with the HTML
				// form and then moves it to the final storage location.
				if(file_exists($tempUploadedFileName)) {
					if(move_uploaded_file($tempUploadedFileName, 
						$uploadedFileNameSaveLocation)) {
							$fileUplaodSuccessCounter += 1;
					}
					else {
						echo '<p> Upload was not successful! </p>';
						
					}		
				}
				else {
					if ($i == 0) {
						echo '<p> You must attach a file first. </p>';
					}
					break;
				}
			}
			
			
			
			// Mark Bowman: This block displays a success message if all of the files have successfully uploaded.
			if ($i != 0) {
				if($i == $fileUplaodSuccessCounter) {
					echo '<p> You did it! </p>';
				}
			}
			
		};
		
		// SQL function LOAD_FILE(Filename) must be used on server.
		function fileDownload() {
			
		};
		
		
		// Mark Bowman: This block calls the uploadFile function for testing.
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			uploadFile("uploadedFile", "../uploads/");
		}
		
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			fileDownload();
		}
?>