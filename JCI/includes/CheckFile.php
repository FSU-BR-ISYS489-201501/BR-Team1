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
 * Revision 1.1: 02/14/2016 Author: Faisal Alfadhli
 * Description of change: I chenge the return to 0 & 1.
 * 
 * Revision 1.2: 02/15/0016 Author: Mark Bowman
 * Description of change: I reorganized the structure of the code in order to check
 * for both file type and file size before returning 0 for false or 1 for true.
 * Also altered the filetype to check the MIME types for word documents.
 ********************************************************************************************/


	function checkFile($fileType, $fileSize) {
		$successMessage = 0;
		// Mark Bowman: changed the structure of this block
		// in order to check both file type and file size.
		
		// this block to check file type 
		if ($fileType== "application/msword" || 
		$fileType== "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
			// this block to check file size
			if($fileSize <= 10000000) {
				$successMessage = 1;                 
			}
		} 
		return $successMessage;
	}
?>
