<?php

// This code was taken from "PHP and MySQL for Dynamic Web Sites", written by Larry Ullman.

// This file contains the database access information. 
// This file also establishes a connection to MySQL, 
// selects the database, and sets the encoding.

// Set the database access information as constants:
DEFINE ('DB_USER', 'db_connector');
DEFINE ('DB_PASSWORD', 'rV);R8PriM*8');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'isys489c-BT1-JCI');


// Make the connection:
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );


// Set the encoding...
mysqli_set_charset($dbc, 'utf8');
?>
