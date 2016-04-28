<?php
/*********************************************************************************************
 * Original Author: Benjamin Brackett
 * Date of origination: 04/14/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: Include a overview of the page: Such as. This is the index.php and will serve as the home page content of the site.\
 * Credit: Most of the code is from other pages that were created by Faisal and Mark. 
 * 	I did use some code from http://www.plus2net.com/php_tutorial/list-table.php to pull values from the db to populate a drop down list

 ********************************************************************************************/
	$page_title = 'EditCriticalIncident';
 	
 	session_start();
	
	if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor') {
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
		
		//Check title of CI value
		if (empty($_POST['title'])) {
			$err[] = 'There is no title.';
		} else {
			$title = mysqli_real_escape_string($dbc, trim($_POST['id']));
			}
		
		//Check to see if any errors exist in the validation array.
		
			//Create the query that dumps info into the DB.
			$query = "UPDATE criticalincidents SET Category='$category', Title='$title' WHERE CriticalIncidentId = $CriticalIncidentId;";
					
			//Run the query...
			$run = @mysqli_querys($dbc, $query)or die("Errors are ".mysqli_error($dbc));
		}
		
		// This will get id value from edit link and when we hit sibmit it will post it in the board 
		// This code was inspired by Wiliam
		If (isset($_GET['id']) ) {
			$CriticalIncidentId = $_GET['id'];
		} else {
			$CriticalIncidentId = $_POST['id'];
		}
		
		// Select Category and Title from Critical Incident
		$editQuery = "SELECT Category, Title FROM criticalincidents WHERE CriticalIncidentId = $CriticalIncidentId;";
		$selectQuery = @mysqli_query($dbc, $editQuery);	
	
		// This code was inspired by Wiliam
		// The previous variable is increased in value to assign the appropriate values from our query array to each variable.
		if($row = mysqli_fetch_array($selectQuery, MYSQLI_NUM)){
			$title = $row[1];
			$category = $row[0];
		}
		
	$critincQuery = "SELECT CIKeyword FROM keywords WHERE CriticalIncidentId = $CriticalIncidentId;";
	$critincIdQuery = "SELECT KeywordId FROM keywords WHERE CriticalIncidentId = $CriticalIncidentId;";
	// This was written by Shane Workman.
	$selectQuery = @mysqli_query($dbc, $critincQuery);
	$idSelectQuery = @mysqli_query($dbc, $critincIdQuery);
	$headerCounter = mysqli_num_fields($selectQuery);
	// I create a button in every row and link them to update keyword page
	$pageNames = array('UpdateKeywordCI.php');
	$titles = array('Edit');
	$variableNames = array('id');
	//Edit button creates view link in table for each CI Id
	$editButton = tableRowLinkGenerator($idSelectQuery, $pageNames, $variableNames, $titles);
	$tableBody = tableRowGeneratorWithButtons($selectQuery, $editButton, 1, $headerCounter);
	
	//Create add keyword button	
	$button = '<a href=' . 'CreateKeyWordCI.php' . '?' . 'id' . '=' . "$CriticalIncidentId" . '>' . 'Add Keyword' . '</a>';
		
	
	}

	else {
		header('Location: http://br-t1-jci.sfcrjci.org/Index.php');
		exit;
	}
	
?>

	<!--Takes information to create a new announcement in the db.-->
	<h1>Edit Critical Incidents</h1>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="editCriticalIncident" method="post">
			<fieldset> 
				
				<input type="hidden" value="<?php if (isset($CriticalIncidentId)) echo $CriticalIncidentId; ?>" name="id" ></input>
			  	 Title: <input  type="text" name="title" value="<?php if (isset($title)) {echo $title;}?>"></input>
			  	 Category: <input type="text" name="category" value="<?php if (isset($category)) {echo $category;}?>"</input>

			  	<p> List of existing categories:
						<!-- Idea from http://www.plus2net.com/php_tutorial/list-table.php -->
						<?php
						$sql="SELECT CategoryName FROM categorys order by CategoryName"; 
						
						$selectQuery = mysqli_query($dbc, $sql);
						
						/* Option values are added by looping through the array */ 
						while($row=mysqli_fetch_row($selectQuery)){
							echo "</br><list ={$row[0]}>{$row[0]}</list>";
						} //Array or records stored in $row
						
						?>
				
				</p>
				<p>Keywords:</p>			
				<table>
					<?php
				echo $tableBody;
				// echo $keyword; 
				echo $button;
				?>
				</table>

				<input type="submit" value="Submit" />
			</fieldset>
		</form>		
