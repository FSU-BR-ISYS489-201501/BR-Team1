<?php
/*********************************************************************************************
 * Original Author: Mark Bowman
 * Date of origination: 04/17/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: The purpose of this file is to allow an editor to change the pictures on the
 * website.
 * 
 * Credit: I got the idea to use a loop to test for changes from Serge Seredenko after 
 * reading his post on http://stackoverflow.com/questions/19472479/php-mysql-only-update-input-fields-that-have-been-changed.
 ********************************************************************************************/

	session_start();
	if($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor') {
		
		$page_title = 'Picture Management';
		include ("includes/Header.php");
		require ('../DbConnector.php');
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$query = "SELECT FileLocation, FileId, FileType FROM files WHERE FileType = 'Slide' OR FileType = 'About' OR FileType = 'null';";
			if ($selectQuery = mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc))) {
				$counter = 0;
				// Citation: Serge Seredenko
				while ($row = mysqli_fetch_array($selectQuery, MYSQLI_NUM)) {
					if ($_POST[$counter] != $row[2]) {
						$updateQuery = "UPDATE files SET FileType = '$_POST[$counter]' WHERE FileId = $row[1]";
						if ($executeUpdateQuery = mysqli_query($dbc, $updateQuery)or die("Errors are ".mysqli_error($dbc))) {
						}
					}
					$counter++;
				}
			}
		}
		
		$tableStart = "<table><tr><th>Picture</th><th>Activate</th><th>Deactivate</th></tr>";
		$tableBody = '';
		$tableEnd = '</table></br><input type="submit" class = "button3" value="Update Pictures">';
		
		$query = "SELECT FileLocation, FileId, FileType FROM files WHERE FileType = 'Slide' OR FileType = 'About' OR FileType = 'null';";
		if ($selectQuery = mysqli_query($dbc, $query)or die("Errors are ".mysqli_error($dbc))) {
			$counter = 0;
			while ($row = mysqli_fetch_array($selectQuery, MYSQLI_NUM)) {
				$tableBody = $tableBody . "
					<tr>
						<td>
							<img src=$row[0] alt='' style='width:10%;height:5%;'>
						</td>
						<td>
							<select name = $counter>";
				if ($row[2] == 'Slide') {
					$tableBody = $tableBody . "
								<option value = 'null'>Location on the Website</option>
								<option value = 'Slide' selected>Slideshow Image</option>
								<option value = 'About'>About Us Image</option>
							</select>
							</td>
						</tr>";
				}
				else if ($row[2] == 'About') {
					$tableBody = $tableBody . "
								<option value = 'null'>Location on the Website</option>
								<option value = 'Slide'>Slideshow Image</option>
								<option value = 'About' selected>About Us Image</option>
							</select>
							</td>
						</tr>";
				}
				else {
					$tableBody = $tableBody . "
								<option value = 'null' selected>Location on the Website</option>
								<option value = 'Slide'>Slideshow Image</option>
								<option value = 'About'>About Us Image</option>
							</select>
							</td>
						</tr>";
				}
				$counter++;
			}
		}
	}
	else {
		header('Location: http://br-t1-jci.sfcrjci.org/Index.php');
		exit;
	}
	
?>
<h1>Picture Management</h1>
</br>
<a href='UploadPicture.php' class = 'button4'>Upload a New Picture</a>
</br>
</br>
<form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>'method = 'POST'>
<?php
	if (!empty($tableBody)) {
		echo $tableStart;
		echo $tableBody;
		echo $tableEnd;
	}
	else {
		echo 'There was a problem with the database';
	}
?>
<form>
</br>


<?php
	include('includes/Footer.php');
?>