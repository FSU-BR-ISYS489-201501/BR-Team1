<?php
/*********************************************************************************************
 * Original Author:Faisal Alfadhli
 * Date of origination: 04/16/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: The purpose of this file is to let an editor to beb able to edit a category for a journal that is in development.
 *
 * Credit: I copied the code from EditAnnouncement.php and modyfied it for EditCategory.php.
 * tutor: William Quigley, Email : mnewrath@gmail.com
 ********************************************************************************************/

include ("includes/Header.php");
	include ("includes/ValidationHelper.php");
	require ('../DbConnector.php');
	$page_title = 'Edit Category';
	$catId='';
	// This block is to get id value from edit link and when we hit submit it will post it in the board 
	// This code was inspired by Wiiliam
	If (isset($_GET['id']) ) {
		$incidentId = $_GET['id'];
	} 
	if (isset($_POST['id']) ) {
		$incidentId = $_POST['id'];
	}
	If (isset($_GET['catId']) ) {
		$catId = $_GET['catId'];
	} else{$catId='';}
	if (isset($_POST['catId']) ) {
		$catId = $_POST['catId'];
	} 
		
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		//$err Sets up Error msg array.
		$err = array();
		//it checks if a text box has a value, if it is not display an error message
		if (empty($_POST['id'])) {
			$err[] = 'You forgot to enter a category.';
		} else {
			$categoryId = mysqli_real_escape_string($dbc, trim($_POST['id']));
			}
		if (empty($_POST['catName'])) {
			$err[] = 'You forgot to type the category name.';
		} else {
			$categoryName = mysqli_real_escape_string($dbc, trim($_POST['catName']));
			}
		if (empty($_POST['year'])) {
			$err[] = 'You forgot to enter a year.';
		} else {
			$categoryYear = mysqli_real_escape_string($dbc, trim($_POST['year']));
			}
		
		// If there is no error, run the query and display a message.
		if(empty($err)) {
			$query = "UPDATE categorys SET CategoryName='$categoryName', CategoryYear='$categoryYear' WHERE CategoryId= $catId;";
			$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
			// if the query did not run, tell the user about the error.
			If (!$run)
			{
				echo 'There was an error when editing the category. Please try again!';
			} else {
				
			}
			$query = "UPDATE criticalincidents SET Category='$categoryName' WHERE criticalincidents.CriticalIncidentId=$incidentId;";
			$run = @mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc));
			// if the query did not run, tell the user about the error.
			If (!$run)
			{
				echo 'There was an error when editing the category. Please try again!';
			} else {
				header('Location: http://localhost/BR-Team1/JCI/Category.php');
			}
		} else {
				//List each Error msg that is stored in the array.
				Foreach($err as $m)
				{
					echo " $m <br />";
				} echo "Please correct the errors.";
			
			}	
		}

		// It was written by Mark.	
		$categoryQuery = "SELECT CategoryId, CategoryName, CategoryYear FROM categorys
						  INNER JOIN criticalincidents ON categorys.CategoryName = criticalincidents.Category 
						  WHERE criticalincidents.CriticalIncidentId = $incidentId;";
	
		// It was written by Mark.
		$selectQuery = @mysqli_query($dbc, $categoryQuery);	
		$headerCounter = mysqli_num_fields($selectQuery);
		$row = mysqli_fetch_array($selectQuery, MYSQLI_NUM);
		
		//The following variable is to set the starting column from our query array $row.
		$a = 0;
		//this code was inspired by Wiiliam
		// The previous variable is increased in value to assign the appropriate values from our query array to each variable.
		$catId = "{$row[$a]}";
		$categoryName = "{$row[$a+1]}";
		$categoryYear = "{$row[$a+2]}";
		
?>
			
	<!--Takes information to edit the category in the db.-->
	<h1>Edit Category</h1>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="editcategory" method="post">
			<fieldset>
				<input type="hidden" name="id" value="<?php echo $incidentId; ?>">
				<input type="hidden" name="catId" value="<?php echo $catId; ?>">
				<p>Category Name: <input type="text" name="catName" size="15" maxlength="50" value="<?php echo $categoryName; ?>" </input></p>
				<p>Category Year: <br/><input type="text" name="year" size="15" maxlength="50" value="<?php echo $categoryYear;?>" </input></p>
				<p><input type="submit" value="Submit" /></p>
			</fieldset>
		</form>
<?php
	include ("includes/Footer.php");
?>	
	
	