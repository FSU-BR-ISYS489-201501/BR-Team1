<?php
/**********************************************
 * Original Author: Conor Jager.
 * Date of origination: 02/07/2016.
 * Page created for use in the JCI Project.
 * ISYS489: Ferris State University.
 * Searched ctype_alnum function from http://php.net/manual/en/function.ctype-alnum.php
 *********************************************/
function CheckAlphaNoSymbols($test)
{
    if (ctype_alnum($test)) 
    {
        return TRUE;
    
	} else 
   		{
       	return FALSE;
    	}
	
}
?>