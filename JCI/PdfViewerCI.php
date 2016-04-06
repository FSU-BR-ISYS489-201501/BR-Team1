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
  *********************************************************************************************/
  $page_title = 'PDF';
  require ('../DbConnector.php');
  $file = '';
  $selectID = $_GET['CriticalIncidentId'];
  $query = "SELECT FileLocation FROM files  WHERE '$selectID' AND files.FileType='CI';";
  $run = mysqli_query($dbc, $query);
  if ($row = mysqli_fetch_array($run, MYSQLI_NUM)) {
	  $file = $row[0];
	  header('Content-type: application/pdf');
	  header('Content-Disposition: inline');
	  header('Content-Transfer-Encoding: binary');
	  header('Accept-Ranges: bytes');
  }
	@readfile($file);
 ?>