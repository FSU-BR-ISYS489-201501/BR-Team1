<?php
/*********************************************************************************************
 * Original Author: Faisal
 * Date of origination: 02/10/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: function to be used in multiple pages.
 * Credit: 1- www.tizg.com  2- www.W3schools.com/php 3- http://io.hsoub.com/php 
 *
 * Function:  checkFile($fileType, $fileSize)
 * Purpose: uses to check the file type and size. If the file meets requirments return true if not return false.
 * Variable: $fileType - it must be .doc or .docx.
 * Variable: $fileSize - it must be 100KB( this may need to be increades later).
 * 
 *
 * Revision1.1: 02/13/2016 Author: Faisal Alfadhli
 * Description of change. I edited the header, and the code and add the parameters. Chenge the return to True & False instead of 0 & 1.
 ********************************************************************************************/


	function checkFile($fileType, $fileSize) {
		
	
		// this block to check file type 
		$fileType=$_FILES['uploadedFile']['fileType'];
		if ($fileType== "doc" OR $fileType== "docx") {
			return TRUE;    
		}
		else{
			return FALSE;
		}
		
		
		//this block to check file size 
		$fileSize=$_FILES['uploadedFile']['fileSize'];
			// Maximum file size  is 100 KB.
			if( ($fileSize <= 100000) ) {
				return TRUE;                  
			}
			else {
				return FALSE;
			}
			
			
	}
?>
