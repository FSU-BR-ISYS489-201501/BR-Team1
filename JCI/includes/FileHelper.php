<?php
	/*******************************************************************************************************************
	 * 
	 * Original Author: Mark Bowman
	 * Date of Origination: 02/04/2016
	 * 
	 * Functions: uploadFile($htmlElement, $fileStorageLocation), downloadFile($fileId)
	 * 
	 * Function: uploadFile($htmlElement, $fileStorageLocation)
	 * Purpose: This function will recieve any number of files from an html form. This 
	 * function will then insert the location and name of the file into a database, and then save the actual file on 
	 * the file server. Finally, it will return $successMessage, which is described in the variables section.
	 * 
	 * Credit: I asked Ryan Pomaski, a future co-worker, to look over the uploadFile function for critiques, and he
	 * suggested that I should look over the manual again, which lead to discover that I was using prepared statements
	 * incorrectly. I used code written by bebertjean in the downloadFile function, retrieved from 
	 * http://php.net/manual/en/function.header.php. Code was also retrived from http://php.net/manual/en/mysqli.prepare.php, 
	 * but a specific author was not specified. The code from the manual was altered to meet the needs of the JCI website.
	 * 
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
	 * 
	 * Revision 1.3: 04/09/2016 Author: Mark Bowman
	 * Description of Change: Revised SQL queries and changed the name of a file type.
	 * 
	 * Revision 1.4: 04/15/2016 Author: Mark Bowman
	 * Description of Change: Revised prepared statements, because I was using them wrong.
	 * 
	 * Revision 1.5: 04/17/2016 Author: Mark Bowman
	 * Description of Change: Removed unused function and added/changed comments.
	 * 
	 * Revision 1.6: 04/19/2016 Author: Mark Bowman
	 * Description of Change: I added a way to upload pictures for the website and test if there is only one upload at
	 * a time.
	 * 
	 *******************************************************************************************************************/
	
	// This function will upload a file from the host's computer to the server. 
	// A string is returned that specifies if the upload was successful or not.
	function uploadFile($dbc, $htmlElement, $fileStorageLocation, $ids, $types, $journalIds) {
		//This is the message that will be returned.
		$successMessage = 0;
		
		// This block is setting a counter for the number of 
		// files and how many have been uploaded.
		$fileUploadSuccessCounter = 0;
		$numberOfFilesUploaded = count($_FILES["$htmlElement"]['tmp_name']);
		$i = 0;
		$insertFileLocationSqlQuery = '';
		// This block is going through all of the uploaded files.
		for($i; $i < $numberOfFilesUploaded; $i++) {
			// This block contains variables for the browser's temporary name
			// for the uploaded file and the location it is going to be saved to.
			if (is_array($_FILES["$htmlElement"]['tmp_name'])) {
				$tempUploadedFileName = $_FILES["$htmlElement"]['tmp_name'][$i];
			}
			else {
				$tempUploadedFileName = $_FILES["$htmlElement"]['tmp_name'];
			}

			if (is_array($_FILES["$htmlElement"]['name'])) {
				$uploadedFileNameSaveLocation = $fileStorageLocation . "{$_FILES["$htmlElement"]['name']["$i"]}";
			}
			else {
				$uploadedFileNameSaveLocation = $fileStorageLocation . "{$_FILES["$htmlElement"]['name']}";
			}
			
			$fileName = $_FILES[$htmlElement]['name'][$i];
			$id = $ids[$i];
			$journalId = $journalIds[$i];
			$type = $types[$i];
			
			if ($types[$i] == 'Word' || $types[$i] == 'Summary' || $types[$i] == 'CI') {
				$insertFileLocationSqlQuery = "INSERT INTO files (CriticalIncidentId, JournalId, FileLocation, FileType, FileDes)
					VALUES (?, ?, ?, ?, ?)";
				$stmt = mysqli_prepare($dbc, $insertFileLocationSqlQuery);
				mysqli_stmt_bind_param($stmt, 'iisss', $id, $journalId, $uploadedFileNameSaveLocation, $type, $fileName);
			}
			else if ($types[$i] == 'Journal') {
				// I changed this, because I was using prepared statements wrong. 
				$insertFileLocationSqlQuery = "INSERT INTO files (JournalId, FileLocation, FileType, FileDes)
					VALUES (?, ?, ?, ?)";
				$stmt = mysqli_prepare($dbc, $insertFileLocationSqlQuery);
				mysqli_stmt_bind_param($stmt, 'isss', $journalId, $uploadedFileNameSaveLocation, $type, $fileName);
			}
			else if ($types[$i] == 'About' || $types[$i] == 'Slide') {
				// I added a way for pictures to be uploaded.
				$insertFileLocationSqlQuery = "INSERT INTO files (FileLocation, FileType, FileDes)
					VALUES (?, ?, ?)";
				$stmt = mysqli_prepare($dbc, $insertFileLocationSqlQuery);
				mysqli_stmt_bind_param($stmt, 'sss', $uploadedFileNameSaveLocation, $type, $fileName);
			}
			
			// This block checks if a file has been submitted with the HTML form.
			if(file_exists($tempUploadedFileName)) {
				// This block performs an SQL query to insert file
				// location into the database.
				if (mysqli_stmt_execute($stmt)) {
					mysqli_stmt_close($stmt);
					// This block moves the input file to the file server.
					if(move_uploaded_file($tempUploadedFileName, $uploadedFileNameSaveLocation)) {
						$fileUploadSuccessCounter += 1;
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
			if($i == $fileUploadSuccessCounter) {
				$successMessage = 1;
			}
		}
		// This block closes the connection to the database.
		return $successMessage;
	};
	
	// SQL function LOAD_FILE(Filename) must be used on server.
	function downloadFile($dbc, $fileId) {
		
		$successMessage = 0;
		$selectFileLocationSqlQuery = "SELECT FileLocation FROM files WHERE FileID = ?;";
		
		
		// Citation: Unknown
		if ($stmt = mysqli_prepare($dbc, $selectFileLocationSqlQuery)) {
		    mysqli_stmt_bind_param($stmt, "i", $fileId);
		    mysqli_stmt_execute($stmt);
		    mysqli_stmt_bind_result($stmt, $filePath);
		    mysqli_stmt_fetch($stmt);
			
			// Citation: bebertjean
			// This will set the file name of the file to be downloaded.
			header('Content-Type: application/download');
  			header("Content-Disposition: attachment; filename=\"" . basename($filePath) . "\"");
			readfile($filePath);

		    mysqli_stmt_close($stmt);
			$successMessage = 1;
		}
		else {
			return $successMessage;
		}
	};
?>