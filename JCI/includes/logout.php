<?php
//Author: Benjamin Brackett
//Email: brackeb1@ferris.edu
//Date: 02/08/2016
//This is logout code that I found online 
//https://github.com/Goatella/Simple-PHP-Login/blob/master/logout.php
//The actual author of this code is Angela Bradley

//
 $past = time() - 100; 
 //this makes the time in the past to destroy the cookie 
 setcookie(ID_my_site, gone, $past); 
 setcookie(Key_my_site, gone, $past); 
 header("Location: login.php"); 
?>