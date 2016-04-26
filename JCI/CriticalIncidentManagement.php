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
	include('includes/TableRowHelper.php');
	require ('../DbConnector.php');
	
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
 	{
		//Set up Error msg array.
		$err = array();
		$title = '';
		$category = '';
		$CriticalIncidentId = '';
		$fieldcount = 1;
		
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
		if (empty($_POST['category'])) {
			$err[] = 'You forgot to select a category.';
		} else {
			$category = mysqli_real_escape_string($dbc, trim($_POST['id']));
			}
		
		//Check category value
		if (empty($_POST['title'])) {
			$err[] = 'There is no title.';
		} else {
			$title = mysqli_real_escape_string($dbc, trim($_POST['id']));
			}
		
		//Check to see if any errors exist in the validation array.
		
			//Create the query that dumps info into the DB.
			$query = "UPDATE criticalincidents SET Category='$category', Title='$title' WHERE CriticalIncidentId = '$CriticalIncidentId';";
					
			//Run the query...
			$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
			}
			// if($run){
				// //$query = "UPDATE keywords SET CIKeyword='$keyword' WHERE CriticalIncidentId = $CriticalIncidentId;";
			// }
		// } else {
				// //List each Error msg that is stored in the array.
				// Foreach($err as $m)
				// {
					// echo " $m <br />";
				// } echo "Please correct the errors.";
// 			
			// }	
		
		
		// it will get id value from edit link and when we hit sibmit it will post it in the board 
		// this code was inspired by Wiliam
		//Value of a variable	
		If (isset($_GET['id']) ) {
			$CriticalIncidentId = $_GET['id'];
		} else {
			$CriticalIncidentId = $_POST['id'];
		}
		
		// Select Category and Title of Critical Incident
		$editQuery = "SELECT Category, Title FROM criticalincidents WHERE CriticalIncidentId = $CriticalIncidentId;";
		$selectQuery = @mysqli_query($dbc, $editQuery);	
		
		
		
		// $title=$title."Title: <input type='text' name='title' size='15' maxlength='50' value='{$title}' ></input>";
			// // The idea for this code was inspired by xdazz.
			// // $button = '<a href=' . $pageName[$b] . '?' . $variableName[$b] . '=' . $ids[$a] . '>' . $title[$b] . '</a></td>';
		
		
		//The following variable set the starting column from our query array $row.
	
		//this code was inspired by Wiiliam
		//The previous variable is increased in value to assign the appropriate values from our query array to each variable.
		if($row = mysqli_fetch_array($selectQuery, MYSQLI_NUM)){
			$title = $row[1];
			$category = $row[0];
		}
		
		// $editKeyword ="SELECT CIKeyword FROM keywords WHERE CriticalIncidentId = $CriticalIncidentId;";
		// $selectQuery = @mysqli_query($dbc, $editKeyword);	
		// $row = mysqli_fetch_array($selectQuery, MYSQLI_NUM);
// 		
		// $keyword = '';
		// while($row=mysqli_fetch_row($selectQuery)){
			// $keyword=$keyword."Keywords: <input type='text' name='keyword[0]' size='15' maxlength='50' value='{$row[0]}' ></input>";
			// // The idea for this code was inspired by xdazz.
			// // $button = '<a href=' . $pageName[$b] . '?' . $variableName[$b] . '=' . $ids[$a] . '>' . $title[$b] . '</a></td>';
		// }
		
	$critincQuery = "SELECT CIKeyword FROM keywords WHERE CriticalIncidentId = $CriticalIncidentId;";
	$critincIdQuery = "SELECT KeywordId FROM keywords WHERE CriticalIncidentId = $CriticalIncidentId;";
	// It was written by Shane Workman.
	$selectQuery = @mysqli_query($dbc, $critincQuery);
	$idSelectQuery = @mysqli_query($dbc, $critincIdQuery);
	$headerCounter = mysqli_num_fields($selectQuery);
	// I create a button in every row and link them to create keyword
	$pageNames = array('CreateKeywordCI.php');
	$titles = array('Edit');
	$variableNames = array('CriticalIncidentId');
	//Edit button creates view link in table for each CI Id
	$headerCounter = mysqli_num_fields($selectQuery);
	$editButton = tableRowLinkGenerator($idSelectQuery, $pageNames, $variableNames, $titles);
	$tableBody = tableRowGeneratorWithButtons($selectQuery, $editButton, 1, $headerCounter);
		
		//Changing category
		//Get all categories for specific journal drop down
		//Changing keyword text box if the field 
		//Edit all other info about CIs
		//use for loop $i
		//update only needs keywordid
		//insert needs keyword's ci id
		//create keyword file to add keywords
		
		
		
?>

	<!--Takes information to create a new announcement in the db.-->
	<h1>Edit Critical Incidents</h1>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="editCriticalIncident" method="post">
			<fieldset> 
				
				<input type="hidden" value="<?php if (isset($CriticalIncidentId)) echo $CriticalIncidentId; ?>" name="id" ></input>
			  	 Title: <input  type="text" name="title" value="<?php if (isset($title)) {echo $title;}?>"></input>
			  	 <?php
			  	// echo $title;
			  	?>
			  	
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
				
				</p>
				<p>Keywords:</p>			
				<table>
					<?php
				echo $tableBody;
				// echo $keyword; 
				?>
				</table>
				<!--<p>Keywords: <input type="text" name="keyword[0]" size="15" maxlength="50" value="<?php echo $keyword[0]; ?>" </input></p>-->
				
					
				
				<input type="submit" value="Submit" />
			</fieldset>
		</form>		
		
		<!--$keyword = array();
		while($row=mysqli_fetch_row($selectQuery)){
			array_push($keyword,$row[0]);
		}
		-->