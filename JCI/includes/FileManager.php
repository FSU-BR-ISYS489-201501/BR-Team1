<?php
	// Put code here for functions that will help downloading and uploading files
		
		// Mark Bowman: Comment
		// Mark Bowman: This function checks if the input file name exists on the file server
		// and returns a file name that doesn't exist on the file server.
		function checkIfFileExistsOnFileServer($filePath) {
			$counter = 1;
			while (file_exists($filePath)) {
				$counter++;
			}
			return $filePath . " ($counter)";
		};
		
		// Mark Bowman: This function will upload a file from the host's computer to the server. 
		// A string is returned that specifies if the upload was successful or not.
		function uploadFile($divName, $fileStorageLocation) {
			//This is the message that will be returned.
			$successMessage = "Upload failed.";
			
			// Mark Bowman: This block is setting a counter for the number of 
			// files and how many have been uploaded.
			$fileUplaodSuccessCounter = 0;
			$numberOfFilesUploaded = count($_FILES["$divName"]['tmp_name']);
			$i = 0;
			// Mark Bowman: This allows access to the database connection information.
			include('DbConnector.php');
			// Mark Bowman: This block is going through all of the uploaded files.
			for($i; $i < $numberOfFilesUploaded; $i++) {
				// Mark bowman: This block contains variables for the browser's temporary name
				// for the uploaded file and the location it is going to be saved to.
				$tempUploadedFileName = $_FILES["$divName"]['tmp_name'][$i];
				$uploadedFileNameSaveLocation = $fileStorageLocation . "{$_FILES["$divName"]['name']["$i"]}";
				$insertFileLocationSqlQuery = "INSERT INTO files (content, file_des, fileid)
					VALUES ('$tempUploadedFileName', '$uploadedFileNameSaveLocation', '$i')";
				// Mark Bowman: This block checks if a file has been submitted with the HTML
				// form and then moves it to the final storage location.
				if(file_exists($tempUploadedFileName)) {
					if(move_uploaded_file($tempUploadedFileName, 
						$uploadedFileNameSaveLocation)) {
							//TODO: Alter this to be a prepared statement.
							// Mark Bowman: This block performs an SQL query to insert file
							// location into the database.
							if (mysqli_query($dbc, $insertFileLocationSqlQuery)) {
							    $fileUplaodSuccessCounter += 1;
							} 
					}
					else {
						$successMessage = "File did not save to file server.";
					}		
				}
				else {
					if ($i == 0) {
						$successMessage = "Attach a file first.";
					}
					break;
				}
			}
			
			
			// Mark Bowman: This block displays a success message if all of the 
			// files have successfully uploaded.
			if ($i != 0) {
				if($i == $fileUplaodSuccessCounter) {
					$successMessage = "All files were uploaded successfully.";
				}
			}
			
			
			// Mark Bowman: This block closes the connection to the database.
			mysqli_close($dbc);
			return $successMessage;
		};
		
		// SQL function LOAD_FILE(Filename) must be used on server.
		function downloadFile($fileId) {
			
			// Mark Bowman: If a 0 is returned, an error was encountered. If a 1 is returned,
			// then the download was successful.
			$successMessage = 0;
			
			include('DbConnector.php');
			$selectFileLocationSqlQuery = "SELECT File_Des FROM Files WHERE FileID = ?;";
			
			
			// Mark Bowman: This code was retrived from http://php.net/manual/en/mysqli.prepare.php.
			// A specific author was not specified, but the code from the manual was altered to 
			// meet the needs of the JCI website.
			if ($stmt = mysqli_prepare($dbc, $selectFileLocationSqlQuery)) {
			    /* bind parameters for markers */
			    mysqli_stmt_bind_param($stmt, "s", $fileId);
			
			    /* execute query */
			    mysqli_stmt_execute($stmt);
			
			    /* bind result variables */
			    mysqli_stmt_bind_result($stmt, $filePath);
			
			    /* fetch value */
			    mysqli_stmt_fetch($stmt);
				
				// Mark Bowman: This code was written by bebertjean at yahoo dot fr. This 
				// code was retrived from http://php.net/manual/en/function.header.php.
				header('Content-Type: application/download');
	  			header("Content-Disposition: attachment; filename=\"" . basename($filePath) . "\"");
				readfile($filePath);
			
			    /* close statement */
			    mysqli_stmt_close($stmt);
				mysqli_close($dbc);
				
				$successMessage = 1;
				return $successMessage;
			}
			else {
				return $successMessage;
			}
		};
		
		
		// Mark Bowman: This block calls the uploadFile function for testing.
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$uploadMessage = uploadFile("uploadedFile", "../uploads/");
			echo "$message";
		}
		
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$downloadMessage = downloadFile($fileId);
		}
?>