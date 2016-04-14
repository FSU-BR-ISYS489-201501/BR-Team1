<?php
/*********************************************************************************************
 * Original Author: Benjamin Brackett
 * Date of origination: 04/14/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: Include a overview of the page: Such as. This is the index.php and will serve as the home page content of the site.\
 * Credit: Give any attributation to code used within, not created by you.
 *
 * Function:  functionName($myVar, $varTwo)
 * Purpose: This is the description of what the function does.
 * Variable: $myVar - Description of variable.
 * Variable: $varTwo - Another description.
 *
 * Function:  functionNameTwo($anotherVar)
 * Purpose: This is the description of what the function does.
 * Variable: $anotherVar - Description of variable. 
 *
 * Revision1.1: MM/DD/YYYY Author: Name Here 
 * Description of change. Also add //Name: comments above your change within the code.
 ********************************************************************************************/
	$page_title = 'Edit';
 	include ("includes/Header.php");
	include ("includes/ValidationHelper.php");
	require ('../DbConnector.php');
	
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
 	{
		//Set up Error msg array.
		$err = array();
		