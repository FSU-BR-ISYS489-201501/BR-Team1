<?php
/*********************************************************************************************
 * Original Author: Mark Bowman
 * Date of origination: 04/14/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: This file will allow an editor to modify the content on the index, about us, 
 * ethics and editorial policy page.
 * Credit: Blocks of code have been borrowed from EditAnnouncement.php in order to save time.
 * A combination of Faisal Alfadhli and William are responsible for those pieces of code on
 * lines: 37-58 and 120-130
 * 
 * Revision 1.1: 04/15/2016 Author: Mark Bowman
 * Description of Change: I changed the file to use prepared statements.
 ********************************************************************************************/
 
 	session_start();
	
	// This checks to see if the logged in user is an editor.
	if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor') {
		
		// This starts to display page content.
		require('../DbConnector.php');
		$page_title = 'Content Management';
		include('includes/Header.php');
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			// This sets the variables to be used within the POST execution.
			$err = array();
			$title = '';
			$body = '';
			$pageContentId = 0;
			
			// This checks to see if the hidden field has content, or it gets the content from the URL.
			// Borrowed this code from Faisal's Edit Announcement
			if (isset($_POST['id']) ){
				$pageContentId = $_POST['id'];
			}
			else {
				$pageContentId = $_GET['id'];
			}
			
			// This checks to see if the user input a title and displays a message if not.
 			if (empty($_POST['title'])) {
				$err[] = 'You forgot to put a title for the page content.';
			} 
			else {
				$title = trim($_POST['title']);
			}
				
			// This checks to see if the user input a body and displays a message if not.
			if (empty($_POST['body'])) {
				$err[] = 'You forgot to enter your page content.';
			} 
			else {
				$body = $_POST['body'];
			}
			
			// If there were no errors setting variables, this will update the database with the input data.
			if(empty($err)) {

				$query = "UPDATE pagecontent SET Title=?, Body=? WHERE PageContentId = ?;";
				$stmt = mysqli_prepare($dbc, $query);
				mysqli_stmt_bind_param($stmt, 'ssi', $title, $body, $pageContentId);
				
				if (mysqli_stmt_execute($stmt)) {
					mysqli_stmt_close($stmt);
					echo "Your page has been updated.";
				} 
				else {
					echo 'There was an error with the database while updating the page. Please try again, or if the problem persists contact the web admin.';
				}
			} 
			else {
				// This lists each error message that is stored in the array.
				foreach($err as $m) {
					echo " $m <br />";
				} 
				echo "Please correct the errors.";
			}
		}
		
		// This sets all variables that will be used in displaying page content.
		$title = '';
		$body = '';
		$pageContentId = 0;
		
		// This checks to see if the hidden field has content, or it gets the content from the URL.
		// Borrowed this code from Faisal's Edit Announcement
		if (isset($_POST['id']) ){
			$pageContentId = $_POST['id'];
		}
		else {
			$pageContentId = $_GET['id'];
		}
		
		$pageContentQuery = "SELECT Title, Body FROM pagecontent WHERE PageContentId = ?;";
		$stmt = mysqli_prepare($dbc, $pageContentQuery);
		mysqli_stmt_bind_param($stmt, 'i', $pageContentId);
		
		if (mysqli_stmt_execute($stmt)) {
			mysqli_stmt_bind_result($stmt, $title, $body);
			// This sets the title and body to the content from the database.
			if (mysqli_stmt_fetch($stmt)) {
			}
			else {
				echo 'There was a problem with the database. Please contact the web admin.';
			}
			mysqli_stmt_close($stmt);
			mysqli_close($dbc);
		}
	}
	// If the user is not an editor, this will perform a redirect.
	else {
		header('Location: Index.php');
		exit;
	}
?>
<h1>Content Management</h1>
<?php // The idea for this code was inspired by Faisal. ?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="pagecontent" method="POST">
	<fieldset>
		<div style="float:right">
			<p></p>
		</div>
		<div style="float:left">
		<?php // This code was borrowed this code from Faisal. ?>
		<input type="hidden" value="<?php if (isset($pageContentId)) echo $pageContentId; ?>" name="id" />
		<p>Title: <input type="text" name="title" size="15" maxlength="50" value="<?php echo $title; ?>" </input></p>
		<p>Page Content: <br/><textarea name="body" style="width:500px;height:400px;" value=""><?php echo $body;?></textarea><br />
		<p><input type="submit" value="Submit" /></p>
		</div>
	</fieldset>
</form>
<?php
	include('includes/Footer.php');
?>