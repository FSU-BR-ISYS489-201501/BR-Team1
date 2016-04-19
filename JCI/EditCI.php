<?php
/*********************************************************************************************
 * Original Author: Benjamin Brackett
 * Date of origination: 04/14/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: Include a overview of the page: Such as. This is the index.php and will serve as the home page content of the site.\
 * Credit: Give any attributation to code used within, not created by you.
 *
 * Function:  functionName($myVar, $varTwo)
 * Purpose: This is the description of what the function does.
 * Variable: $myVar - Description of variable.
 * Variable: $varTwo - Another description.
 *
 * Function:  functionNameTwo($anotherVar)
 * Purpose: This is the description of what the function does.
 * Variable: $anotherVar - Description of variable. 
 *
 * Revision1.1: MM/DD/YYYY Author: Name Here 
 * Description of change. Also add //Name: comments above your change within the code.
 ********************************************************************************************/
	$page_title = 'EditCriticalIncident';
 	include ("includes/Header.php");
	include ("includes/ValidationHelper.php");
	require ('../DbConnector.php');
	
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
 	{
		//Set up Error msg array.
		$err = array();
		
		//Check for CI Id value.
		if (empty($_POST['CriticalIncidentId'])) {
			$err[] = 'Critical Incident not selected.';
		} else {
			$CriticalIncidentId = mysqli_real_escape_string($dbc, trim($_POST['id']));
			}
		
		//Check Keyword value
		if (empty($_POST['CIKeyword'])) {
			$err[] = 'There are no keywords entered.';
		} else {
			$CIKeyword = mysqli_real_escape_string($dbc, trim($_POST['id']));
			}
		
		//Check category value
		if (empty($_POST['Category'])) {
			$err[] = 'You forgot to select a category.';
		} else {
			$Category = mysqli_real_escape_string($dbc, trim($_POST['id']));
			}
		
		//Check category value
		if (empty($_POST['Title'])) {
			$err[] = 'There is no title.';
		} else {
			$Title = mysqli_real_escape_string($dbc, trim($_POST['id']));
			}
		
		//Check to see if any errors exist in the validation array.
		if(empty($err)) {
			//Create the query that dumps info into the DB.
			$query = "UPDATE criticalincidents SET Category='$Category', Title='$Title' WHERE CriticalIncidentId = $CriticalIncidentId;";
					
			//Run the query...
			$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
			
			if($run){
				//$query = "UPDATE keywords SET CIKeyword='$keyword' WHERE CriticalIncidentId = $CriticalIncidentId;";
			}
		} else {
				//List each Error msg that is stored in the array.
				Foreach($err as $m)
				{
					echo " $m <br />";
				} echo "Please correct the errors.";
			
			}	
		}
		
		// it will get id value from edit link and when we hit sibmit it will post it in the board 
		// this code was inspired by Wiliam
		//Value of a variable	
		If (isset($_GET['id']) ) {
			$CriticalIncidentId = $_GET['id'];
		} Else {
			$CriticalIncidentId = $_POST['id'];
		}
		
		// Credit to Mark
		$editQuery = "SELECT Category, Title FROM criticalincidents WHERE CriticalIncidentId = $CriticalIncidentId;";
		$selectQuery = @mysqli_query($dbc, $editQuery);	
		$row = mysqli_fetch_array($selectQuery, MYSQLI_NUM);
		
		//The following variable set the starting column from our query array $row.
		$a = 1;
		//this code was inspired by Wiiliam
		//The previous variable is increased in value to assign the appropriate values from our query array to each variable.
		while($row=mysqli_fetch_row($selectQuery)){
			$title = "{$row[$a+1]}";
			$category = "{$row[$a]}";
		}
		
		$editKeyword ="SELECT CIKeyword FROM keywords WHERE CriticalIncidentId = $CriticalIncidentId;";
		$selectQuery = @mysqli_query($dbc, $editKeyword);	
		$row = mysqli_fetch_array($selectQuery, MYSQLI_NUM);
		
		$keyword = '';
		while($row=mysqli_fetch_row($selectQuery)){
			$keyword=$keyword."Keywords: <input type='text' name='keyword[0]' size='15' maxlength='50' value='{$row[0]}' ></input>";
		}
		
		//Changing category
		//Get all categories for specific journal drop down
		//Changing keyword text box if the field 
		//Edit all other info about CIs
		//use for loop $i
		//
?>

	<!--Takes information to create a new announcement in the db.-->
	<h1>Edit Critical Incidents</h1>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="editCriticalIncident" method="post">
			<fieldset> 
				Title: <input type="text" name="title" value="<?php if (isset($title)) {echo $title;} ?>">
				<input type="hidden" value="<?php if (isset($CriticalIncidentId)) echo $CriticalIncidentId; ?>" name="id" >
			  	<p>Category:
						<!-- Idea from http://www.plus2net.com/php_tutorial/list-table.php -->
						<?php
						$sql="SELECT CategoryName FROM categorys order by CategoryName"; 
						
						echo "<select name=categorys>"; // list box select command
						$selectQuery = mysqli_query($dbc, $sql);
						
						/* Option values are added by looping through the array */ 
						while($row=mysqli_fetch_row($selectQuery)){
							echo "<option value={$row[0]}>{$row[0]}</option>";
						} //Array or records stored in $row
												
						 
												
						
						
						 echo "</select>";// Closing of list box
						?>
						
						<!--
						<select name="type">
							<option <?php if(isset($category)) {echo $category;} ?> value="<?php $category; ?>"
						</select>
						-->
				</p>
							
				
				<!--<p>Keywords: <input type="text" name="keyword[0]" size="15" maxlength="50" value="<?php echo $keyword[0]; ?>" </input></p>-->
				<?php
				echo $keyword; 
				?>
					
				
				<input type="submit" value="Submit" />
			</fieldset>
		</form>		
		
		<!--$keyword = array();
		while($row=mysqli_fetch_row($selectQuery)){
			array_push($keyword,$row[0]);
		}
		-->