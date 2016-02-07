<?php

//Faisal: (Refrences:1- www.tizg.com 
// 2- www.W3schools.com/php
// 3- http://io.hsoub.com/php  
function checkFile()
{
	
	
	// Faisal: this block to check file type 
	$fileType=$_FILES['uploadedFile']['type'];
	if ($fileType== "pdf" OR $fileType== "docs"){
	
		echo  "the file type is valid ";     //Faisal : if file type valid.
												}
	else
	{
		echo "the file type is invalid";   //Faisal: if file type invalid 
	}
	
	//Faisal: this block to check file size 
	$fileSize=$_FILES['uploadedFile']['size'];
	if( ($fileSize > 100000) ) //Faisal: Maximum file size  is 100 KB.
                    {
                     echo "The file size is invalid ";                  
                    }
	else 
	{
					echo "The file size is valid";
	}
}
?>
