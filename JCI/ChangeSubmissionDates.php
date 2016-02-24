<?php
 /*********************************************************************************************
  * Original Author: Ben Brackett
  * Date of origination: 02/21/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: The purpose of this page is to collect changes for the submission dates.
  * Credit: http://www.plus2net.com/php_tutorial/date-selection.php
  * 
  * Revision1.1: MM/DD/YYYY Author: Name Here 
  * Description of change. Also add //Name: comments above your change within the code.
  ********************************************************************************************/
 include ("includes/Header.php");
 $page_title = 'ChangeSubmissionDates';
 
 //Grab the db connector.
 require ('mysqli_connect.php');

//Begin Validation... 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 

 	//Set up Error msg array.
 	$err = array();
	
$todoFirst=$_POST['todoFirst'];
if(isset($todoFirst) and $todoFirst=="submit"){
	$month=$_POST['month'];
	$day=$_POST['day'];
	$year=$_POST['year'];
	$StartDate="$month/$dt/$year";
	echo "Start date is mm/dd/yyyy format :$StartDate<br>";
}
//Creat the query that dumps info into the DB.
		$query = "INSERT INTO AccouncementId (StartDate)
				VALUES ('$StartDate');";
				
		//Run the query...
		$run = @mysqli_query($dbc, $query);
?>
<h1>Submission Window</h1>
<h2>Start Date</h2>
<form method=post name=todoFirst action=''><input type=hidden name=todoFirst value=submit>
<table border="0" cellspacing="0" >
<tr><td align=left >
<select name=month value=''>Select Month</option>
	<option value='01'>January</option>
	<option value='02'>February</option>
	<option value='03'>March</option>
	<option value='04'>April</option>
	<option value='05'>May</option>
	<option value='06'>June</option>
	<option value='07'>July</option>
	<option value='08'>August</option>
	<option value='09'>September</option>
	<option value='10'>October</option>
	<option value='11'>November</option>
	<option value='12'>December</option>
</select>

</td><td align=left >
Date<select name=dt >
	<option value='01'>01</option>
	<option value='02'>02</option>
	<option value='03'>03</option>
	<option value='04'>04</option>
	<option value='05'>05</option>
	<option value='06'>06</option>
	<option value='07'>07</option>
	<option value='08'>08</option>
	<option value='09'>09</option>
	<option value='10'>10</option>
	<option value='11'>11</option>
	<option value='12'>12</option>
	<option value='13'>13</option>
	<option value='14'>14</option>
	<option value='15'>15</option>
	<option value='16'>16</option>
	<option value='17'>17</option>
	<option value='18'>18</option>
	<option value='19'>19</option>
	<option value='20'>20</option>
	<option value='21'>21</option>
	<option value='22'>22</option>
	<option value='23'>23</option>
	<option value='24'>24</option>
	<option value='25'>25</option>
	<option value='26'>26</option>
	<option value='27'>27</option>
	<option value='28'>28</option>
	<option value='29'>29</option>
	<option value='30'>30</option>
	<option value='31'>31</option>
</select>

</td><td align=left >
<select name=year value=''>Select Year
<option value='2015'>2015</option>	
<option value='2016'>2016</option>
<option value='2017'>2017</option>
<option value='2018'>2018</option>
<option value='2019'>2019</option>
<option value='2020'>2020</option>
<option value='2021'>2021</option>
<option value='2022'>2022</option>
<option value='2023'>2023</option>
<option value='2024'>2024</option>
<option value='2025'>2025</option>
<option value='2026'>2026</option>
<option value='2027'>2027</option>
<option value='2028'>2028</option>
<option value='2029'>2029</option>
<option value='2030'>2030</option>
<option value='2031'>2031</option>
</select>
	<input type=submit value=Submit>
</table>

</form>
<?php
$todo=$_POST['todo'];
if(isset($todo) and $todo=="Submit"){
	$month=$_POST['month'];
	$dt=$_POST['dt'];
	$year=$_POST['year'];
	$StopDate="$month/$dt/$year";
	echo "End date is mm/dd/yyyy format :$StopDate<br>";
}
//Creat the query that dumps info into the DB.
		$query = "INSERT INTO AccouncementId (StopDate)
				VALUES ('$StopDate');";
				
		//Run the query...
		$run = @mysqli_query($dbc, $query);
?>
<h2>End Date</h2>
<form method=post name=todo action=''><input type=hidden name=todo value=Submit>
	<table border="0" cellspacing="0" >
	<tr><td align=left >
	<select name=month value=''>Select Month</option>
		<option value='01'>January</option>
		<option value='02'>February</option>
		<option value='03'>March</option>
		<option value='04'>April</option>
		<option value='05'>May</option>
		<option value='06'>June</option>
		<option value='07'>July</option>
		<option value='08'>August</option>
		<option value='09'>September</option>
		<option value='10'>October</option>
		<option value='11'>November</option>
		<option value='12'>December</option>
	</select>
	
	</td><td align=left >
	Date<select name=dt >
		<option value='01'>01</option>
		<option value='02'>02</option>
		<option value='03'>03</option>
		<option value='04'>04</option>
		<option value='05'>05</option>
		<option value='06'>06</option>
		<option value='07'>07</option>
		<option value='08'>08</option>
		<option value='09'>09</option>
		<option value='10'>10</option>
		<option value='11'>11</option>
		<option value='12'>12</option>
		<option value='13'>13</option>
		<option value='14'>14</option>
		<option value='15'>15</option>
		<option value='16'>16</option>
		<option value='17'>17</option>
		<option value='18'>18</option>
		<option value='19'>19</option>
		<option value='20'>20</option>
		<option value='21'>21</option>
		<option value='22'>22</option>
		<option value='23'>23</option>
		<option value='24'>24</option>
		<option value='25'>25</option>
		<option value='26'>26</option>
		<option value='27'>27</option>
		<option value='28'>28</option>
		<option value='29'>29</option>
		<option value='30'>30</option>
		<option value='31'>31</option>
	</select>
	
	</td><td align=left >
	<select name=year value=''>Select Year
	<option value='2015'>2015</option>	
	<option value='2016'>2016</option>
	<option value='2017'>2017</option>
	<option value='2018'>2018</option>
	<option value='2019'>2019</option>
	<option value='2020'>2020</option>
	<option value='2021'>2021</option>
	<option value='2022'>2022</option>
	<option value='2023'>2023</option>
	<option value='2024'>2024</option>
	<option value='2025'>2025</option>
	<option value='2026'>2026</option>
	<option value='2027'>2027</option>
	<option value='2028'>2028</option>
	<option value='2029'>2029</option>
	<option value='2030'>2030</option>
	<option value='2031'>2031</option>
		<input type=submit value=Submit>
	</table>

</form> 