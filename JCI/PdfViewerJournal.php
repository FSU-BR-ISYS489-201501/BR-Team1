<?php
  /*********************************************************************************************
  * Original Author: Shane Workman
  * Date of origination: 03/30/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: The purpose of this page is to allow people to send an email to the editor.
  * Credit: My own code, with inspiration and use of others functions within the project. 
  * http://php.net/ was a resource.
  * 
  * Revision 1.1: 04/05/2016 authors: Mark Bowman
  * I made it functional on the live site.
  * 
  * Revision 1.2: 04/06/2016 authors: Mark Bowman
  * I made the PDF file download with the correct name and file extension.
  *********************************************************************************************/
  $page_title = 'PDF';
  require ('../DbConnector.php');
  $file = '';
  $selectId = $_GET['JournalId'];
  $query = "SELECT FileLocation, FileDes FROM files  WHERE JournalId = '$selectId' AND FileType = 'PDF' AND Active = 1;";
  $run = mysqli_query($dbc, $query);
  if ($row = mysqli_fetch_array($run, MYSQLI_NUM)) {
	  $file = $row[0];
	  $fileName = $row[1];
	  header('Content-type: application/pdf');
	  // Mark Bowman: I used a reply on Stackoverflow made by Fred -ii- for the synax of this
	  // line of code. Retrieved from http://stackoverflow.com/questions/18040386/how-to-display-pdf-in-php.
	  header("Content-Disposition: inline; filename=$fileName");
	  header('Content-Transfer-Encoding: binary');
	  header('Accept-Ranges: bytes');
  }
	@readfile($file);
 ?>