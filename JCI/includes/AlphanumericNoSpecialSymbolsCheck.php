<?php
/* Conor Jager
 02/07/16
 Searched ctype_alnum function from http://php.net/manual/en/function.ctype-alnum.php
 */ 
 $test = 'Abrer2183';

    if (ctype_alnum($test)) {
        echo "The string $test consists of all letters or digits.\n";
    } else {
        echo "The string $test does not consist of all letters or digits.\n";
    }
	;
?>