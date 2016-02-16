<?php
/**********************************************
 * Original Author: Conor Jager.
 * Date of origination: 02/07/2016.
 * Page created for use in the JCI Project.
 * ISYS489: Ferris State University.
 * Searched preg_match function from http://stackoverflow.com/questions/17085738/php-only-allow-letters-numbers-spaces-and-specific-symbols-using-pregmatch
 *********************************************/

//Creat Function 
function CheckAlphanumeric($test)
{
	// Use preg_match function to check letters and numbers, also is case insensative.
	if (!preg_match('/^[a-z0-9 .\/-@#+*=_&^()!$%,.?;:]+$/i',$test)) // This if statement tests the variable for alphanumerics and special symbols
	{
        return FALSE;
	
	}  else 
		{
		return TRUE;
		}
}

?>
