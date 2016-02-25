<?php
/*********************************************************************************************
 * Original Author: Shane Workman
 * Date of origination: 02/24/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: Modular code, function to be used in multiple pages.
 * Credit: http://php.net/manual/en/function.checkdate.php  /venadder at yahoo dot ca
 *                
 * Function:  Function isDate($string)
 * Purpose: This function test to see if the date given in a string is a valid date.
 ********************************************************************************************/
function isDate( $string )
{
  $stamp = strtotime( $string );
  $month = date( 'm', $stamp );
  $day   = date( 'd', $stamp );
  $year  = date( 'Y', $stamp );

  return checkdate( $month, $day, $year );
}
?>