<?php
/*********************************************************************************************
 * Original Author: Shane Workman
 * Date of origination: 02/09/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: Modular code, function to be used in multiple pages.
 *                
 * Function:  Function checkPsw($pass)
 * Purpose: This function uses regex to check the mask of a password input to make sure it meets standards.
 * 				Checks for 10 chars, one number, one special char, one lower, one capital!
 * Variable: $myVar - Description of variable.
 * Variable: $varTwo - Another description.
 * 
 * Revision 1.1: 02/17/2016 Author: Shane Workman
 * Fixed the pattern to work corrently. Used a different PHP fuction to test new pattern
 ********************************************************************************************/
 
 // creates the function call
 // creates the function call
 function checkPsw($input_line)
 {
 	//Created the regex expression, Checks for 10 chars, one number, one special char, one lower, one capital!
    $pattern = "/^\S*(?=\S{10,})(?=\S*[a-z])(?=\S*[\W])(?=\S*[A-Z])(?=\S*[\d])\S*$/";
 	
 	if (!preg_match($pattern, $input_line))
	{
		   return FALSE;
	} else { return TRUE; }
 }
 ?>
