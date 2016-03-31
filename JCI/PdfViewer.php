<?php
  /*********************************************************************************************
  * Original Author: Shane Workman
  * Date of origination: 03/30/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: The purpose of this page is to allow people to send an email to the editor.
  * Credit: My own code, with inspiration and use of others functions within the project. http://php.net/ as a resource.
  *********************************************************************************************/
  $page_title = 'PDF';
  require ('../DbConnector.php');
  include ("includes/Header.php");
  $selectID = $_SERVER['QUERY_STRING'];
  $query = "SELECT JournalLocation FROM `journalofcriticalincidents` WHERE '$selectID';";
  $run = mysqli_query($dbc, $query);
  $file = '$run';
  $filename = '$run';
  header ('Content-type: application/pdf');
  header ('Content-disposition: inline; filename="' . $filename . '"');
  header ('Content-Transfer-Encoding: binary');
  header ('Accept-Range: bytes');
  @readfile($file);
  include ("includes/Header.php");
?>