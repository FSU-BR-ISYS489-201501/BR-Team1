<?php
 /*********************************************************************************************
  * Original Author: Ben Brackett
  * Date of origination: 02/21/2016
  *
  * Page created for use in the JCI Project.
  * Project work is done as part of a Capstone class ISYS489: Ferris State University.
  * Purpose: The purpose of this page is to collect changes for the submission dates.
  * Credit: PHP credit to http://www.plus2net.com/php_tutorial/date-selection.php
  * 		HTML credit to http://html.cita.illinois.edu/nav/form/date/index.php?example=6
  * 
  * Function: strtotime($EndDate, $StartDate)
  * Purpose: A PHP built-in function that parses a date and returns an integer value 
  * Variable: $EndDate - Ending submission date
  * Variable: $StartDate - Begining submission date
  * 
  * Revision1.1: MM/DD/YYYY Author: Name Here 
  * Description of change. Also add //Name: comments above your change within the code.
  ********************************************************************************************/
  
   include ("includes/Header.php");
 $page_title = 'ChangeSubmissionDates';
 
 //Grab the db connector.
 require ('../DbConnector.php');

//Begin Validation... 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
 	//Set up Error msg array.
 	$err = array();

	$MonthStart=$_POST['MonthStart'];
	$MonthEnd=$_POST['MonthEnd'];
	$DayStart=$_POST['DayStart'];
	$DayEnd=$_POST['DayEnd'];
	$YearStart=$_POST['YearStart'];
	$YearEnd=$_POST['YearEnd'];
	$StartDate="$MonthStart/$DayStart/$YearStart";
	$EndDate="$MonthEnd/$DayEnd/$YearEnd";
	echo "Start date is mm/dd/yyyy format :$StartDate<br>";
	echo "End date is mm/dd/yyyy format :$EndDate<br>";
		
	//Check if the array is empty
	If(empty($err)) {
	
		//Creat the query that dumps info into the DB.
		$query = "INSERT INTO announcement (StartDate, EndDate)
				VALUES ('$StartDate', '$EndDate');";
				
		//Run the query...
		$run = @mysqli_query($dbc, $query);
		
		//Check to make sure the dbConnector didnt die!
		IF (!$run)
			{
				echo 'Error! Dates were not saved. Please try again.';
			}	
		} else {
			//List error messages
			Foreach($err as $m)
			{
				echo " $m <br />";
			} echo "Please correct the errors.";
		
		}
	If (strtotime($EndDate) < $StartDate) {
		echo "Oops! Did you mean to put $EndDate as the Start Date and $StartDate as the End Date?";
	}
}
?>
<h2>Submission Dates</h2>
<p>Select the beginning and ending dates for the submission process. This will prevent 
	users from uploading files outside the selected dates.</p>
<form method=post action=''><input type=hidden value=submit>
	<fieldset class="date"> 
		<legend>Start Date </legend> 
		<label for="MonthStart">Month</label> 
		<select id="MonthStart" 
		name="MonthStart" /> 
			<option <?php if(isset($_POST['MonthStart'])=="NULL") echo'selected="selected"'; ?>    value="NULL"></option>       
			<option <?php if(isset($_POST['MonthStart'])=="January") echo'selected="selected"'; ?>    value="January">January</option>
			<option <?php if(isset($_POST['MonthStart'])=="February") echo'selected="selected"'; ?>    value="February">February</option>
			<option <?php if(isset($_POST['MonthStart'])=="March") echo'selected="selected"'; ?>    value="March">March</option>
			<option <?php if(isset($_POST['MonthStart'])=="April") echo'selected="selected"'; ?>    value="April">April</option>
			<option <?php if(isset($_POST['MonthStart'])=="May") echo'selected="selected"'; ?>    value="May">May</option>
			<option <?php if(isset($_POST['MonthStart'])=="June") echo'selected="selected"'; ?>    value="June">June</option>
			<option <?php if(isset($_POST['MonthStart'])=="July") echo'selected="selected"'; ?>    value="July">July</option>
			<option <?php if(isset($_POST['MonthStart'])=="August") echo'selected="selected"'; ?>    value="August">August</option>
			<option <?php if(isset($_POST['MonthStart'])=="September") echo'selected="selected"'; ?>    value="September">September</option>
			<option <?php if(isset($_POST['MonthStart'])=="October") echo'selected="selected"'; ?>    value="October">October</option>
			<option <?php if(isset($_POST['MonthStart'])=="November") echo'selected="selected"'; ?>    value="November">November</option>
			<option <?php if(isset($_POST['MonthStart'])=="December") echo'selected="selected"'; ?>    value="December">December</option>
	</select> -
		<label for="DayStart">Day</label> 
			<select id="DayStart" 
			name="DayStart" /> 
			<option <?php if(isset($_POST['DayStart'])=="NULL") echo'selected="selected"'; ?>    value="NULL"></option>       
			<option <?php if(isset($_POST['DayStart'])=="1") echo'selected="selected"'; ?>    value="1">1</option>
			<option <?php if(isset($_POST['DayStart'])=="2") echo'selected="selected"'; ?>    value="2">2</option>
			<option <?php if(isset($_POST['DayStart'])=="3") echo'selected="selected"'; ?>    value="3">3</option>
			<option <?php if(isset($_POST['DayStart'])=="4") echo'selected="selected"'; ?>    value="4">4</option>
			<option <?php if(isset($_POST['DayStart'])=="5") echo'selected="selected"'; ?>    value="5">5</option>
			<option <?php if(isset($_POST['DayStart'])=="6") echo'selected="selected"'; ?>    value="6">6</option>
			<option <?php if(isset($_POST['DayStart'])=="7") echo'selected="selected"'; ?>    value="7">7</option>
			<option <?php if(isset($_POST['DayStart'])=="8") echo'selected="selected"'; ?>    value="8">8</option>
			<option <?php if(isset($_POST['DayStart'])=="9") echo'selected="selected"'; ?>    value="9">9</option>      
			<option <?php if(isset($_POST['DayStart'])=="10") echo'selected="selected"'; ?>    value="10">10</option>      
			<option <?php if(isset($_POST['DayStart'])=="11") echo'selected="selected"'; ?>    value="11">11</option>                
			<option <?php if(isset($_POST['DayStart'])=="12") echo'selected="selected"'; ?>    value="12">12</option>                
			<option <?php if(isset($_POST['DayStart'])=="13") echo'selected="selected"'; ?>    value="13">13</option>                
			<option <?php if(isset($_POST['DayStart'])=="14") echo'selected="selected"'; ?>    value="14">14</option>                
			<option <?php if(isset($_POST['DayStart'])=="15") echo'selected="selected"'; ?>    value="15">15</option>                
			<option <?php if(isset($_POST['DayStart'])=="16") echo'selected="selected"'; ?>    value="16">16</option>                
			<option <?php if(isset($_POST['DayStart'])=="17") echo'selected="selected"'; ?>    value="17">17</option>                
			<option <?php if(isset($_POST['DayStart'])=="18") echo'selected="selected"'; ?>    value="18">18</option>                
			<option <?php if(isset($_POST['DayStart'])=="19") echo'selected="selected"'; ?>    value="19">19</option>                
			<option <?php if(isset($_POST['DayStart'])=="20") echo'selected="selected"'; ?>    value="20">20</option>                
			<option <?php if(isset($_POST['DayStart'])=="21") echo'selected="selected"'; ?>    value="21">21</option>                
			<option <?php if(isset($_POST['DayStart'])=="22") echo'selected="selected"'; ?>    value="22">22</option>                
			<option <?php if(isset($_POST['DayStart'])=="23") echo'selected="selected"'; ?>    value="23">23</option>                
			<option <?php if(isset($_POST['DayStart'])=="24") echo'selected="selected"'; ?>    value="24">24</option>                
			<option <?php if(isset($_POST['DayStart'])=="25") echo'selected="selected"'; ?>    value="25">25</option>                
			<option <?php if(isset($_POST['DayStart'])=="26") echo'selected="selected"'; ?>    value="26">26</option>                
			<option <?php if(isset($_POST['DayStart'])=="27") echo'selected="selected"'; ?>    value="27">27</option>                
			<option <?php if(isset($_POST['DayStart'])=="28") echo'selected="selected"'; ?>    value="28">28</option>                
			<option <?php if(isset($_POST['DayStart'])=="29") echo'selected="selected"'; ?>    value="29">29</option>                
			<option <?php if(isset($_POST['DayStart'])=="30") echo'selected="selected"'; ?>    value="30">30</option>                
			<option <?php if(isset($_POST['DayStart'])=="31") echo'selected="selected"'; ?>    value="31">31</option>     
			</select> - 
		<label for="YearStart">Year</label> 
			<select id="YearStart" 
			name="YearStart" /> 
			<option <?php if(isset($_POST['YearStart'])=="NULL") echo'selected="selected"'; ?>    value="NULL"></option>       
			<option <?php if(isset($_POST['YearStart'])=="2015") echo'selected="selected"'; ?>    value="2015">2015</option>
			<option <?php if(isset($_POST['YearStart'])=="2016") echo'selected="selected"'; ?>    value="2016">2016</option>
			<option <?php if(isset($_POST['YearStart'])=="2017") echo'selected="selected"'; ?>    value="2017">2017</option>
			<option <?php if(isset($_POST['YearStart'])=="2018") echo'selected="selected"'; ?>    value="2018">2018</option>
			<option <?php if(isset($_POST['YearStart'])=="2019") echo'selected="selected"'; ?>    value="2019">2019</option>
			<option <?php if(isset($_POST['YearStart'])=="2020") echo'selected="selected"'; ?>    value="2020">2020</option>
			<option <?php if(isset($_POST['YearStart'])=="2021") echo'selected="selected"'; ?>    value="2021">2021</option>
			<option <?php if(isset($_POST['YearStart'])=="2022") echo'selected="selected"'; ?>    value="2022">2022</option>
			<option <?php if(isset($_POST['YearStart'])=="2023") echo'selected="selected"'; ?>    value="2023">2023</option>      
			<option <?php if(isset($_POST['YearStart'])=="2024") echo'selected="selected"'; ?>    value="2024">2024</option>      
			<option <?php if(isset($_POST['YearStart'])=="2025") echo'selected="selected"'; ?>    value="2025">2025</option>             
			</select> 
		<span class="inst">(Month-Day-Year)</span> 
	</fieldset> 
	<fieldset class="date"> 
		<legend>End Date </legend> 
		<label for="MonthEnd">Month</label> 
			<select id="MonthEnd" 
			name="MonthEnd" /> 
			<option <?php if(isset($_POST['MonthEnd'])=="NULL") echo'selected="selected"'; ?>    value="NULL"></option>       
			<option <?php if(isset($_POST['MonthEnd'])=="January") echo'selected="selected"'; ?>    value="January">January</option>
			<option <?php if(isset($_POST['MonthEnd'])=="February") echo'selected="selected"'; ?>    value="February">February</option>
			<option <?php if(isset($_POST['MonthEnd'])=="March") echo'selected="selected"'; ?>    value="March">March</option>
			<option <?php if(isset($_POST['MonthEnd'])=="April") echo'selected="selected"'; ?>    value="April">April</option>
			<option <?php if(isset($_POST['MonthEnd'])=="May") echo'selected="selected"'; ?>    value="May">May</option>
			<option <?php if(isset($_POST['MonthEnd'])=="June") echo'selected="selected"'; ?>    value="June">June</option>
			<option <?php if(isset($_POST['MonthEnd'])=="July") echo'selected="selected"'; ?>    value="July">July</option>
			<option <?php if(isset($_POST['MonthEnd'])=="August") echo'selected="selected"'; ?>    value="August">August</option>
			<option <?php if(isset($_POST['MonthEnd'])=="September") echo'selected="selected"'; ?>    value="September">September</option>
			<option <?php if(isset($_POST['MonthEnd'])=="October") echo'selected="selected"'; ?>    value="October">October</option>
			<option <?php if(isset($_POST['MonthEnd'])=="November") echo'selected="selected"'; ?>    value="November">November</option>
			<option <?php if(isset($_POST['MonthEnd'])=="December") echo'selected="selected"'; ?>    value="December">December</option>
			</select> - 
		<label for="DayEnd">Day</label> 
			<select id="DayEnd" 
			name="DayEnd" /> 
			<option <?php if(isset($_POST['DayEnd'])=="NULL") echo'selected="selected"'; ?>    value="NULL"></option>       
			<option <?php if(isset($_POST['DayEnd'])=="1") echo'selected="selected"'; ?>    value="1">1</option>
			<option <?php if(isset($_POST['DayEnd'])=="2") echo'selected="selected"'; ?>    value="2">2</option>
			<option <?php if(isset($_POST['DayEnd'])=="3") echo'selected="selected"'; ?>    value="3">3</option>
			<option <?php if(isset($_POST['DayEnd'])=="4") echo'selected="selected"'; ?>    value="4">4</option>
			<option <?php if(isset($_POST['DayEnd'])=="5") echo'selected="selected"'; ?>    value="5">5</option>
			<option <?php if(isset($_POST['DayEnd'])=="6") echo'selected="selected"'; ?>    value="6">6</option>
			<option <?php if(isset($_POST['DayEnd'])=="7") echo'selected="selected"'; ?>    value="7">7</option>
			<option <?php if(isset($_POST['DayEnd'])=="8") echo'selected="selected"'; ?>    value="8">8</option>
			<option <?php if(isset($_POST['DayEnd'])=="9") echo'selected="selected"'; ?>    value="9">9</option>      
			<option <?php if(isset($_POST['DayEnd'])=="10") echo'selected="selected"'; ?>    value="10">10</option>      
			<option <?php if(isset($_POST['DayEnd'])=="11") echo'selected="selected"'; ?>    value="11">11</option>                
			<option <?php if(isset($_POST['DayEnd'])=="12") echo'selected="selected"'; ?>    value="12">12</option>                
			<option <?php if(isset($_POST['DayEnd'])=="13") echo'selected="selected"'; ?>    value="13">13</option>                
			<option <?php if(isset($_POST['DayEnd'])=="14") echo'selected="selected"'; ?>    value="14">14</option>                
			<option <?php if(isset($_POST['DayEnd'])=="15") echo'selected="selected"'; ?>    value="15">15</option>                
			<option <?php if(isset($_POST['DayEnd'])=="16") echo'selected="selected"'; ?>    value="16">16</option>                
			<option <?php if(isset($_POST['DayEnd'])=="17") echo'selected="selected"'; ?>    value="17">17</option>                
			<option <?php if(isset($_POST['DayEnd'])=="18") echo'selected="selected"'; ?>    value="18">18</option>                
			<option <?php if(isset($_POST['DayEnd'])=="19") echo'selected="selected"'; ?>    value="19">19</option>                
			<option <?php if(isset($_POST['DayEnd'])=="20") echo'selected="selected"'; ?>    value="20">20</option>                
			<option <?php if(isset($_POST['DayEnd'])=="21") echo'selected="selected"'; ?>    value="21">21</option>                
			<option <?php if(isset($_POST['DayEnd'])=="22") echo'selected="selected"'; ?>    value="22">22</option>                
			<option <?php if(isset($_POST['DayEnd'])=="23") echo'selected="selected"'; ?>    value="23">23</option>                
			<option <?php if(isset($_POST['DayEnd'])=="24") echo'selected="selected"'; ?>    value="24">24</option>                
			<option <?php if(isset($_POST['DayEnd'])=="25") echo'selected="selected"'; ?>    value="25">25</option>                
			<option <?php if(isset($_POST['DayEnd'])=="26") echo'selected="selected"'; ?>    value="26">26</option>                
			<option <?php if(isset($_POST['DayEnd'])=="27") echo'selected="selected"'; ?>    value="27">27</option>                
			<option <?php if(isset($_POST['DayEnd'])=="28") echo'selected="selected"'; ?>    value="28">28</option>                
			<option <?php if(isset($_POST['DayEnd'])=="29") echo'selected="selected"'; ?>    value="29">29</option>                
			<option <?php if(isset($_POST['DayEnd'])=="30") echo'selected="selected"'; ?>    value="30">30</option>                
			<option <?php if(isset($_POST['DayEnd'])=="31") echo'selected="selected"'; ?>    value="31">31</option>                

			</select> - 
		<label for="YearEnd">Year</label> 
			<select id="YearEnd" 
			name="YearEnd" />
			<option <?php if(isset($_POST['YearEnd'])=="NULL") echo'selected="selected"'; ?>    value="NULL"></option>       
			<option <?php if(isset($_POST['YearEnd'])=="2015") echo'selected="selected"'; ?>    value="2015">2015</option>
			<option <?php if(isset($_POST['YearEnd'])=="2016") echo'selected="selected"'; ?>    value="2016">2016</option>
			<option <?php if(isset($_POST['YearEnd'])=="2017") echo'selected="selected"'; ?>    value="2017">2017</option>
			<option <?php if(isset($_POST['YearEnd'])=="2018") echo'selected="selected"'; ?>    value="2018">2018</option>
			<option <?php if(isset($_POST['YearEnd'])=="2019") echo'selected="selected"'; ?>    value="2019">2019</option>
			<option <?php if(isset($_POST['YearEnd'])=="2020") echo'selected="selected"'; ?>    value="2020">2020</option>
			<option <?php if(isset($_POST['YearEnd'])=="2021") echo'selected="selected"'; ?>    value="2021">2021</option>
			<option <?php if(isset($_POST['YearEnd'])=="2022") echo'selected="selected"'; ?>    value="2022">2022</option>
			<option <?php if(isset($_POST['YearEnd'])=="2023") echo'selected="selected"'; ?>    value="2023">2023</option>      
			<option <?php if(isset($_POST['YearEnd'])=="2024") echo'selected="selected"'; ?>    value="2024">2024</option>      
			<option <?php if(isset($_POST['YearEnd'])=="2025") echo'selected="selected"'; ?>    value="2025">2025</option>            
			</select> 
			<span class="inst">(Month-Day-Year)</span> 
	</fieldset>
	<input type=submit value=Submit>
</form> 