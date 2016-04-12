<?php
 /*********************************************************************************************
  * Original Author: Shane Workman
  * Date of origination: 04/12/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: create a random string for various things throught the project.
  * Credit:  used http://stackoverflow.com/questions/4356289/php-random-string-generator as a
  * 	referance to help.
  *********************************************************************************************/
function randString($length) {
    $validCharacters = "ABCDEFGHIJKLMNPQRSTUXYVWZ123456789";
    $validCharNumber = strlen($validCharacters);
    $result = "";

    for ($i = 0; $i < $length; $i++) {
        $index = mt_rand(0, $validCharNumber - 1);
        $result .= $validCharacters[$index];
    	}
	return $result;}
?>