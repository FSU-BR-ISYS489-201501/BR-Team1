<?php

//Faisal: (Refrences:1- www.tizg.com 
// 2- www.W3schools.com/php
// 3- http://io.hsoub.com/php  

	function checkFile() {
		$successMsg = 0;
	
		// this block to check file type 
		$fileType=$_FILES['uploadedFile']['type'];
		if ($fileType== "doc" OR $fileType== "docx") {
			$successMsg = 1;    
		}
		return $successMsg;
		
		
		//this block to check file size 
		$fileSize=$_FILES['uploadedFile']['size'];
			// Maximum file size  is 100 KB.
			if( ($fileSize <= 100000) ) {
				$successMsg = 1;                  
			}
			return $successMsg;
			
			
	}
?>
