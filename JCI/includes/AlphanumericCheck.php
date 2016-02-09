<?php
/* Conor Jager
 02/07/16
 Searched preg_match function from http://stackoverflow.com/questions/17085738/php-only-allow-letters-numbers-spaces-and-specific-symbols-using-pregmatch
 */ 
 $test = 'Abrer 2+@183)'; // This variable is just a test variable
 
if (preg_match('/^[a-z0-9 .\/-@#+*=_&^()!$%,.?;:]+$/i',$test)) // This if statement tests the variable for alphanumerics and special symbols
{
        echo "The string $test consists of all letters, digits, special character, and spaces.\n";
}  
	;
?>