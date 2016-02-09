<?php
/**********************************************
 * Original Author: Shane Workman
 * Date of origination: 02/09/2016
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class
 * ISYS489: Ferris State University.
 *********************************************/
 
 // creates the function call
 function checkPSW($pass)
 {
 	// uses a regex expression, Checks for 10 chars, for one number, for one special char, one lower, one cap!
 	if (!preg_match_all('$\S*(?=\S{10,})(?=\S*[\d])(?=\S*[\W])\S*)(?=\S*[a-z])(?=\S*[A-Z])$', $pass))
	{
		// doesnt match return false
		return FALSE;
	} else { return TRUE; }
 }
 ?>