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
 ********************************************************************************************/
 
 // creates the function call
 function checkPsw($pass)
 {
 	// uses a regex expression, Checks for 10 chars, one number, one special char, one lower, one capital!
 	if (!preg_match_all('$\S*(?=\S{10,})(?=\S*[\d])(?=\S*[\W])\S*)(?=\S*[a-z])(?=\S*[A-Z])$', $pass))
	{
		// doesnt match return false
		return FALSE;
	} else { return TRUE; }
 }
 ?>