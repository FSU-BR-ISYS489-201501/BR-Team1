<?php
	/*******************************************************************************************************************
	 * 
	 * Original Author: Mark Bowman
	 * Date of Origination: 02/04/2016
	 * 
	 * Functions: checkIfFileExistsOnFileServer($filePath), uploadFile($htmlElement, $fileStorageLocation)
	 * , downloadFile($fileId)
	 * 
	 * Function: checkIfFileExistsOnFileServer($filePath)
	 * Purpose: This function will check if the input file name already exists on the file server. If it does, 
	 * this function will modify the name of the file until it finds a file name that doesn't exist on the file server.
	 * and if the input file name exists on the file server, it returns a file name that doesn't exist on the file server.
	 * Variable: $filePath includes the name of the file.
	 * 
	 * Function: uploadFile($htmlElement, $fileStorageLocation)
	 * Purpose: This function will recieve any number of files from an html form. This 
	 * function will then insert the location and name of the file into a database, and then save the actual file on 
	 * the file server. Finally, it will return $successMessage, which is described in the variables section.
	 * Variables: $htmlElement contains all of the uploaded files. 
	 * 			$fileStorageLocation is the destination file path for the uploaded files. 
	 * 			$uploadedFileNameSaveLocation is the destination file path for the uploaded files in to the file name. 
	 * 			$successMessage contains a number between 0 and 4; 0 means failure, 1 means success, 2 means 
	 * 				database error, 3 means file server error, and 4 means no files were uploaded.
	 * 
	 * Function: downloadFile($fileId)
	 * Purpose: This function will recieve the database ID for a file. It will query the database for that ID.
	 * If the ID exists in the database, it will return the file location for that record. Finally, this function will
	 * force the file to be downloaded to the client's system.
	 * Variables: $successMessage contains either a 0 or a 1; 0 means failure, and 1 means success.
	 * 
	 * Revision 1.1: 02/14/2016 Author: Mark Bowman
	 * Description of Change: Modified comments and altered header.
	 * 
	 * Revision 1.2: 02/15/2016 Author: Mark Bowman
	 * Description of Change: Added database connection into parameters for downloadFile and uploadFile
	 *******************************************************************************************************************/
	//TODO fix this function
	function checkIfFileExistsOnFileServer($filePath) {
		$counter = 1;
		while (file_exists($filePath)) {
			$counter++;
		}
		return $filePath . " ($counter)";
	};
	
	// This function will upload a file from the host's computer to the server. 
	// A string is returned that specifies if the upload was successful or not.
	function uploadFile($dbc, $htmlElement, $fileStorageLocation) {
		//This is the message that will be returned.
		$successMessage = 0;
		
		// This block is setting a counter for the number of 
		// files and how many have been uploaded.
		$fileUplaodSuccessCounter = 0;
		$numberOfFilesUploaded = count($_FILES["$htmlElement"]['tmp_name']);
		$i = 0;
		// This block is going through all of the uploaded files.
		for($i; $i < $numberOfFilesUploaded; $i++) {
			// This block contains variables for the browser's temporary name
			// for the uploaded file and the location it is going to be saved to.
			$tempUploadedFileName = $_FILES["$htmlElement"]['tmp_name'][$i];
			$uploadedFileNameSaveLocation = $fileStorageLocation . "{$_FILES["$htmlElement"]['name']["$i"]}";
			$insertFileLocationSqlQuery = "INSERT INTO Files (File_Location, File_Des)
				VALUES ('$tempUploadedFileName', '$uploadedFileNameSaveLocation')";
			// This block checks if a file has been submitted with the HTML form.
			if(file_exists($tempUploadedFileName)) {
				// This block performs an SQL query to insert file
				// location into the database.
				if ($stmt = mysqli_prepare($dbc, $insertFileLocationSqlQuery)) {
					mysqli_stmt_execute($stmt);
					mysqli_stmt_close($stmt);
					// This block moves the input file to the file server.
					if(move_uploaded_file($tempUploadedFileName, 
					$uploadedFileNameSaveLocation)) {
						$fileUplaodSuccessCounter += 1;
					}
					else {
						// This block ets the variable if the file could not be saved to the file server.
						$successMessage = 2;
					}	
				} 	
				else {
					// This block sets the variable if the file location could not be saved to the database.
					$successMessage = 3;
				}	
			}
			else {
				if ($i == 0) {
					// This block sets the variable if no files were uploaded.
					$successMessage = 4;
				}
				break;
			}
		}
		
		
		// This block sets the variable if all files were successfully uploaded to the database and file server.
		if ($i != 0) {
			if($i == $fileUplaodSuccessCounter) {
				$successMessage = 1;
			}
		}
		
		
		// This block closes the connection to the database.
		mysqli_close($dbc);
		return $successMessage;
	};
	
	// SQL function LOAD_FILE(Filename) must be used on server.
	function downloadFile($dbc, $fileId) {
		
		$successMessage = 0;
		$selectFileLocationSqlQuery = "SELECT File_Des FROM Files WHERE FileID = ?;";
		
		
		// This code was retrived from http://php.net/manual/en/mysqli.prepare.php.
		// A specific author was not specified, but the code from the manual was altered to 
		// meet the needs of the JCI website.
		if ($stmt = mysqli_prepare($dbc, $selectFileLocationSqlQuery)) {
		    mysqli_stmt_bind_param($stmt, "s", $fileId);
		    mysqli_stmt_execute($stmt);
		    mysqli_stmt_bind_result($stmt, $filePath);
		    mysqli_stmt_fetch($stmt);
			
			// This code was written by bebertjean at yahoo dot fr. This 
			// code was retrived from http://php.net/manual/en/function.header.php.
			header('Content-Type: application/download');
  			header("Content-Disposition: attachment; filename=\"" . basename($filePath) . "\"");
			readfile($filePath);

			
		    mysqli_stmt_close($stmt);
			mysqli_close($dbc);
			$successMessage = 1;
			
			return $successMessage;
		}
		else {
			return $successMessage;
		}
	};
	
	
	// This block calls the uploadFile function for testing.
	// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// $uploadMessage = uploadFile("uploadedFile", "../uploads/");
		// echo "$message";
	// }
// 	
	// // This block calls the downloadFile function for testing.
	// if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		// $downloadMessage = downloadFile("1");
	// }
?>