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
  * Function: strtotime($endDate, $startDate)
  * Purpose: A PHP built-in function that parses a date and returns an integer value 
  * Variable: $endDate - Ending submission date
  * Variable: $startDate - Begining submission date
  * 
  * Revision1.1: 04/17/2016 Author: Mark Bowman
  * Description of change. Ichanged the insert query to go to the
  * journalofcriticalincidents table instead of the deprecated submissions table, and I
  * changed variable names.
  ********************************************************************************************/
  	// Check to make sure user is editor
	session_start();
  	if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor') {
		$page_title = 'ChangeSubmissionDates'; 
		include ("includes/Header.php");
		require ('../DbConnector.php');
		
		// If submit button is pressed...
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		 	//Set up Error msg array.
		 	$err = array();
		
			$monthStart=$_POST['monthStart'];
			$monthEnd=$_POST['monthEnd'];
			$dayStart=$_POST['dayStart'];
			$dayEnd=$_POST['dayEnd'];
			$yearStart=$_POST['yearStart'];
			$yearEnd=$_POST['yearEnd'];
			$startDate="$yearStart-$monthStart-$dayStart";
			$endDate="$yearEnd-$monthEnd-$dayEnd";
			$journalId = 0;
				
			//Check if the array is empty
			if (empty($err)) {
				
				$query = "SELECT JournalId from journalofcriticalincidents WHERE InDevelopement = 1";
				
				$run = mysqli_query($dbc, $query);
				
				if ($run) {
					if (mysqli_num_rows($run) == 1) {
						if ($row = mysqli_fetch_array($run, MYSQLI_ASSOC)) {
							$journalId = $row['JournalId'];
							//Create the query that dumps info into the DB.
							//use where and change table to Critical incidents table or w/e
							$query = "UPDATE journalofcriticalincidents SET OpenDate = ?, CloseDate = ? WHERE JournalId = ?;";
									
							//Run the query...
							$stmt = mysqli_prepare($dbc, $query);
							mysqli_stmt_bind_param($stmt, 'ssi', $startDate, $endDate, $journalId);
							
							//Check to make sure the dbConnector didnt die!
							if (mysqli_stmt_execute($stmt) or die("Errors are ".mysqli_error($dbc))) {
								mysqli_stmt_close($stmt);
								if (mysqli_affected_rows($dbc)) {
									echo "The new volume will be accessible between $startDate and $endDate";
								}
								else {
									echo 'There was an error with the database, and the dates were not saved. Please try again.';
								}
							}
						}
					}
					else if (mysqli_num_rows($run) == 0) {
						echo 'There is no volume in development. Contact your system administrator.';
					}
					else {
						echo 'There is more than one volume in development. Contact your system administrator.';
					}
				}
				else {
					echo 'There was a problem with the database.';
				}	
			}
			else {
				//List error messages
				foreach($err as $m) {
					echo " $m <br />";
				}
				
				if (strtotime($endDate) < $startDate) {
					echo "Oops! Did you mean to put $endDate as the Start Date and $startDate as the End Date?";
				}
				echo "Please correct the errors.";
			}
		}
	}
	else {
		header('Location: Index.php');
		exit;
	}
?>
<h2>Submission Dates</h2>
<p>Select the beginning and ending dates for the submission process. This will prevent 
	users from uploading files outside the selected dates.</p>
<form method=post action=''><input type=hidden value=submit>
	<fieldset class="date"> 
		<legend>Start Date </legend> 
		<label for="monthStart">Month</label> 
		<select id="monthStart" 
		name="monthStart" /> 
			<option <?php if(isset($_POST['monthStart'])=="NULL") echo'selected="selected"'; ?>    value="NULL"></option>       
			<option <?php if(isset($_POST['monthStart'])=="01") echo'selected="selected"'; ?>    value="01">January</option>
			<option <?php if(isset($_POST['monthStart'])=="02") echo'selected="selected"'; ?>    value="02">February</option>
			<option <?php if(isset($_POST['monthStart'])=="03") echo'selected="selected"'; ?>    value="03">March</option>
			<option <?php if(isset($_POST['monthStart'])=="04") echo'selected="selected"'; ?>    value="04">April</option>
			<option <?php if(isset($_POST['monthStart'])=="05") echo'selected="selected"'; ?>    value="05">May</option>
			<option <?php if(isset($_POST['monthStart'])=="06") echo'selected="selected"'; ?>    value="06">June</option>
			<option <?php if(isset($_POST['monthStart'])=="07") echo'selected="selected"'; ?>    value="07">July</option>
			<option <?php if(isset($_POST['monthStart'])=="08") echo'selected="selected"'; ?>    value="08">August</option>
			<option <?php if(isset($_POST['monthStart'])=="09") echo'selected="selected"'; ?>    value="09">September</option>
			<option <?php if(isset($_POST['monthStart'])=="10") echo'selected="selected"'; ?>    value="10">October</option>
			<option <?php if(isset($_POST['monthStart'])=="11") echo'selected="selected"'; ?>    value="11">November</option>
			<option <?php if(isset($_POST['monthStart'])=="12") echo'selected="selected"'; ?>    value="12">December</option>
	</select> -
		<label for="dayStart">Day</label> 
			<select id="dayStart" 
			name="dayStart" /> 
			<option <?php if(isset($_POST['dayStart'])=="NULL") echo'selected="selected"'; ?>    value="NULL"></option>       
			<option <?php if(isset($_POST['dayStart'])=="01") echo'selected="selected"'; ?>    value="1">01</option>
			<option <?php if(isset($_POST['dayStart'])=="02") echo'selected="selected"'; ?>    value="2">02</option>
			<option <?php if(isset($_POST['dayStart'])=="03") echo'selected="selected"'; ?>    value="3">03</option>
			<option <?php if(isset($_POST['dayStart'])=="04") echo'selected="selected"'; ?>    value="4">04</option>
			<option <?php if(isset($_POST['dayStart'])=="05") echo'selected="selected"'; ?>    value="5">05</option>
			<option <?php if(isset($_POST['dayStart'])=="06") echo'selected="selected"'; ?>    value="6">06</option>
			<option <?php if(isset($_POST['dayStart'])=="07") echo'selected="selected"'; ?>    value="7">07</option>
			<option <?php if(isset($_POST['dayStart'])=="08") echo'selected="selected"'; ?>    value="8">08</option>
			<option <?php if(isset($_POST['dayStart'])=="09") echo'selected="selected"'; ?>    value="9">09</option>      
			<option <?php if(isset($_POST['dayStart'])=="10") echo'selected="selected"'; ?>    value="10">10</option>      
			<option <?php if(isset($_POST['dayStart'])=="11") echo'selected="selected"'; ?>    value="11">11</option>                
			<option <?php if(isset($_POST['dayStart'])=="12") echo'selected="selected"'; ?>    value="12">12</option>                
			<option <?php if(isset($_POST['dayStart'])=="13") echo'selected="selected"'; ?>    value="13">13</option>                
			<option <?php if(isset($_POST['dayStart'])=="14") echo'selected="selected"'; ?>    value="14">14</option>                
			<option <?php if(isset($_POST['dayStart'])=="15") echo'selected="selected"'; ?>    value="15">15</option>                
			<option <?php if(isset($_POST['dayStart'])=="16") echo'selected="selected"'; ?>    value="16">16</option>                
			<option <?php if(isset($_POST['dayStart'])=="17") echo'selected="selected"'; ?>    value="17">17</option>                
			<option <?php if(isset($_POST['dayStart'])=="18") echo'selected="selected"'; ?>    value="18">18</option>                
			<option <?php if(isset($_POST['dayStart'])=="19") echo'selected="selected"'; ?>    value="19">19</option>                
			<option <?php if(isset($_POST['dayStart'])=="20") echo'selected="selected"'; ?>    value="20">20</option>                
			<option <?php if(isset($_POST['dayStart'])=="21") echo'selected="selected"'; ?>    value="21">21</option>                
			<option <?php if(isset($_POST['dayStart'])=="22") echo'selected="selected"'; ?>    value="22">22</option>                
			<option <?php if(isset($_POST['dayStart'])=="23") echo'selected="selected"'; ?>    value="23">23</option>                
			<option <?php if(isset($_POST['dayStart'])=="24") echo'selected="selected"'; ?>    value="24">24</option>                
			<option <?php if(isset($_POST['dayStart'])=="25") echo'selected="selected"'; ?>    value="25">25</option>                
			<option <?php if(isset($_POST['dayStart'])=="26") echo'selected="selected"'; ?>    value="26">26</option>                
			<option <?php if(isset($_POST['dayStart'])=="27") echo'selected="selected"'; ?>    value="27">27</option>                
			<option <?php if(isset($_POST['dayStart'])=="28") echo'selected="selected"'; ?>    value="28">28</option>                
			<option <?php if(isset($_POST['dayStart'])=="29") echo'selected="selected"'; ?>    value="29">29</option>                
			<option <?php if(isset($_POST['dayStart'])=="30") echo'selected="selected"'; ?>    value="30">30</option>                
			<option <?php if(isset($_POST['dayStart'])=="31") echo'selected="selected"'; ?>    value="31">31</option>     
			</select> - 
		<label for="yearStart">Year</label> 
			<select id="yearStart" 
			name="yearStart" /> 
			<option <?php if(isset($_POST['yearStart'])=="NULL") echo'selected="selected"'; ?>    value="NULL"></option>       
			<option <?php if(isset($_POST['yearStart'])=="2015") echo'selected="selected"'; ?>    value="2015">2015</option>
			<option <?php if(isset($_POST['yearStart'])=="2016") echo'selected="selected"'; ?>    value="2016">2016</option>
			<option <?php if(isset($_POST['yearStart'])=="2017") echo'selected="selected"'; ?>    value="2017">2017</option>
			<option <?php if(isset($_POST['yearStart'])=="2018") echo'selected="selected"'; ?>    value="2018">2018</option>
			<option <?php if(isset($_POST['yearStart'])=="2019") echo'selected="selected"'; ?>    value="2019">2019</option>
			<option <?php if(isset($_POST['yearStart'])=="2020") echo'selected="selected"'; ?>    value="2020">2020</option>
			<option <?php if(isset($_POST['yearStart'])=="2021") echo'selected="selected"'; ?>    value="2021">2021</option>
			<option <?php if(isset($_POST['yearStart'])=="2022") echo'selected="selected"'; ?>    value="2022">2022</option>
			<option <?php if(isset($_POST['yearStart'])=="2023") echo'selected="selected"'; ?>    value="2023">2023</option>      
			<option <?php if(isset($_POST['yearStart'])=="2024") echo'selected="selected"'; ?>    value="2024">2024</option>      
			<option <?php if(isset($_POST['yearStart'])=="2025") echo'selected="selected"'; ?>    value="2025">2025</option>             
			</select> 
		<span class="inst">(Month-Day-Year)</span> 
	</fieldset> 
	<fieldset class="date"> 
		<legend>End Date </legend> 
		<label for="monthEnd">Month</label> 
			<select id="monthEnd" 
			name="monthEnd" /> 
			<option <?php if(isset($_POST['monthEnd'])=="NULL") echo'selected="selected"'; ?>    value="NULL"></option>       
			<option <?php if(isset($_POST['monthEnd'])=="01") echo'selected="selected"'; ?>    value="01">January</option>
			<option <?php if(isset($_POST['monthEnd'])=="02") echo'selected="selected"'; ?>    value="02">February</option>
			<option <?php if(isset($_POST['monthEnd'])=="03") echo'selected="selected"'; ?>    value="03">March</option>
			<option <?php if(isset($_POST['monthEnd'])=="04") echo'selected="selected"'; ?>    value="04">April</option>
			<option <?php if(isset($_POST['monthEnd'])=="05") echo'selected="selected"'; ?>    value="05">May</option>
			<option <?php if(isset($_POST['monthEnd'])=="06") echo'selected="selected"'; ?>    value="06">June</option>
			<option <?php if(isset($_POST['monthEnd'])=="07") echo'selected="selected"'; ?>    value="07">July</option>
			<option <?php if(isset($_POST['monthEnd'])=="08") echo'selected="selected"'; ?>    value="08">August</option>
			<option <?php if(isset($_POST['monthEnd'])=="09") echo'selected="selected"'; ?>    value="09">September</option>
			<option <?php if(isset($_POST['monthEnd'])=="10") echo'selected="selected"'; ?>    value="10">October</option>
			<option <?php if(isset($_POST['monthEnd'])=="11") echo'selected="selected"'; ?>    value="11">November</option>
			<option <?php if(isset($_POST['monthEnd'])=="12") echo'selected="selected"'; ?>    value="12">December</option>
			</select> - 
		<label for="dayEnd">Day</label> 
			<select id="dayEnd" 
			name="dayEnd" /> 
			<option <?php if(isset($_POST['dayEnd'])=="NULL") echo'selected="selected"'; ?>    value="NULL"></option>       
			<option <?php if(isset($_POST['dayEnd'])=="01") echo'selected="selected"'; ?>    value="1">01</option>
			<option <?php if(isset($_POST['dayEnd'])=="02") echo'selected="selected"'; ?>    value="2">02</option>
			<option <?php if(isset($_POST['dayEnd'])=="03") echo'selected="selected"'; ?>    value="3">03</option>
			<option <?php if(isset($_POST['dayEnd'])=="04") echo'selected="selected"'; ?>    value="4">04</option>
			<option <?php if(isset($_POST['dayEnd'])=="05") echo'selected="selected"'; ?>    value="5">05</option>
			<option <?php if(isset($_POST['dayEnd'])=="06") echo'selected="selected"'; ?>    value="6">06</option>
			<option <?php if(isset($_POST['dayEnd'])=="07") echo'selected="selected"'; ?>    value="7">07</option>
			<option <?php if(isset($_POST['dayEnd'])=="08") echo'selected="selected"'; ?>    value="8">08</option>
			<option <?php if(isset($_POST['dayEnd'])=="09") echo'selected="selected"'; ?>    value="9">09</option>      
			<option <?php if(isset($_POST['dayEnd'])=="10") echo'selected="selected"'; ?>    value="10">10</option>      
			<option <?php if(isset($_POST['dayEnd'])=="11") echo'selected="selected"'; ?>    value="11">11</option>                
			<option <?php if(isset($_POST['dayEnd'])=="12") echo'selected="selected"'; ?>    value="12">12</option>                
			<option <?php if(isset($_POST['dayEnd'])=="13") echo'selected="selected"'; ?>    value="13">13</option>                
			<option <?php if(isset($_POST['dayEnd'])=="14") echo'selected="selected"'; ?>    value="14">14</option>                
			<option <?php if(isset($_POST['dayEnd'])=="15") echo'selected="selected"'; ?>    value="15">15</option>                
			<option <?php if(isset($_POST['dayEnd'])=="16") echo'selected="selected"'; ?>    value="16">16</option>                
			<option <?php if(isset($_POST['dayEnd'])=="17") echo'selected="selected"'; ?>    value="17">17</option>                
			<option <?php if(isset($_POST['dayEnd'])=="18") echo'selected="selected"'; ?>    value="18">18</option>                
			<option <?php if(isset($_POST['dayEnd'])=="19") echo'selected="selected"'; ?>    value="19">19</option>                
			<option <?php if(isset($_POST['dayEnd'])=="20") echo'selected="selected"'; ?>    value="20">20</option>                
			<option <?php if(isset($_POST['dayEnd'])=="21") echo'selected="selected"'; ?>    value="21">21</option>                
			<option <?php if(isset($_POST['dayEnd'])=="22") echo'selected="selected"'; ?>    value="22">22</option>                
			<option <?php if(isset($_POST['dayEnd'])=="23") echo'selected="selected"'; ?>    value="23">23</option>                
			<option <?php if(isset($_POST['dayEnd'])=="24") echo'selected="selected"'; ?>    value="24">24</option>                
			<option <?php if(isset($_POST['dayEnd'])=="25") echo'selected="selected"'; ?>    value="25">25</option>                
			<option <?php if(isset($_POST['dayEnd'])=="26") echo'selected="selected"'; ?>    value="26">26</option>                
			<option <?php if(isset($_POST['dayEnd'])=="27") echo'selected="selected"'; ?>    value="27">27</option>                
			<option <?php if(isset($_POST['dayEnd'])=="28") echo'selected="selected"'; ?>    value="28">28</option>                
			<option <?php if(isset($_POST['dayEnd'])=="29") echo'selected="selected"'; ?>    value="29">29</option>                
			<option <?php if(isset($_POST['dayEnd'])=="30") echo'selected="selected"'; ?>    value="30">30</option>                
			<option <?php if(isset($_POST['dayEnd'])=="31") echo'selected="selected"'; ?>    value="31">31</option>                

			</select> - 
		<label for="yearEnd">Year</label> 
			<select id="yearEnd" 
			name="yearEnd" />
			<option <?php if(isset($_POST['yearEnd'])=="NULL") echo'selected="selected"'; ?>    value="NULL"></option>       
			<option <?php if(isset($_POST['yearEnd'])=="2015") echo'selected="selected"'; ?>    value="2015">2015</option>
			<option <?php if(isset($_POST['yearEnd'])=="2016") echo'selected="selected"'; ?>    value="2016">2016</option>
			<option <?php if(isset($_POST['yearEnd'])=="2017") echo'selected="selected"'; ?>    value="2017">2017</option>
			<option <?php if(isset($_POST['yearEnd'])=="2018") echo'selected="selected"'; ?>    value="2018">2018</option>
			<option <?php if(isset($_POST['yearEnd'])=="2019") echo'selected="selected"'; ?>    value="2019">2019</option>
			<option <?php if(isset($_POST['yearEnd'])=="2020") echo'selected="selected"'; ?>    value="2020">2020</option>
			<option <?php if(isset($_POST['yearEnd'])=="2021") echo'selected="selected"'; ?>    value="2021">2021</option>
			<option <?php if(isset($_POST['yearEnd'])=="2022") echo'selected="selected"'; ?>    value="2022">2022</option>
			<option <?php if(isset($_POST['yearEnd'])=="2023") echo'selected="selected"'; ?>    value="2023">2023</option>      
			<option <?php if(isset($_POST['yearEnd'])=="2024") echo'selected="selected"'; ?>    value="2024">2024</option>      
			<option <?php if(isset($_POST['yearEnd'])=="2025") echo'selected="selected"'; ?>    value="2025">2025</option>            
			</select> 
			<span class="inst">(Month-Day-Year)</span> 
	</fieldset>
	<input type=submit value=Submit>
</form> 