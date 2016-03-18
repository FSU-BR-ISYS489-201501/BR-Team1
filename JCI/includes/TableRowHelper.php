<?php
/*********************************************************************************************
 * Original Author: Mark Bowman
 * Date of origination: 02/17/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: The purpose of this file is to allow for the generation of table rows by
 * accepting a database query and putting the results in table row format.
 * Credit: I used code written by xdazz in the tableRowLinkGenerator function.
 * The code was obtained from http://stackoverflow.com/questions/11772493/how-to-pass-a-value-via-href-php.
 * I used code written by Bart S. This code was obtained from 
 * //http://stackoverflow.com/questions/676677/how-to-add-elements-to-an-empty-array-in-php
 *
 * Function:  countNumberOfFields($dbc, $selectQuery)
 * Purpose: This function does a database query and returns the number of fields being returned.
 * Variable: $dbc - This is the database connection.
 * Variable: $selectQuery - This is a string representation of a database query.
 *
 * Function:  tableRowGenerator($dbc, $selectQuery, $headerCounter)
 * Purpose: This function creates table rows that will contain the information retrieved from 
 * the database query. The number of rows will represent the number of returned records, and
 * the number of columns will represent the number of fields in the table.
 * Variable: $headerCounter - This is the number of fields being returned (columns).
 * 
 * Function:  tableRowGeneratorWithButtons($dbc, $selectQuery, $editButton, $headerCounter)
 * Purpose: This function creates table rows that contain an edit button, an activate button, 
 * and a deactivate button. This will be saved to a string and then returned.
 * Variable: $editButton - This is an array with the edit button, activate button, and
 * deactivate button.
 * 
 * Function:  tableRowLinkGenerator($dbc, $idSelectQuery)
 * Purpose: This function automatically creates the edit button, activate button, and
 * deactivate button that will be used in the tableRowGeneratorWithButtons function.
 *
 * Revision1.1: MM/DD/YYYY Author: Name Here 
 * Description of change. Also add //Name: comments above your change within the code.
 ********************************************************************************************/
 
	function tableRowGenerator($selectQuery, $headerCounter) {
		$tableBody = '';
		// This block will retrieve an array from the database, which will be used to assign values
		// to an HTML table.
		while ($row = mysqli_fetch_array($selectQuery, MYSQLI_NUM)) {
			$tableBody = $tableBody . "<tr>";
			// This block will add individual field values to the table.
			for($a = 0;$a < $headerCounter;$a++) {
				$tableBody = $tableBody . "<td>{$row[$a]}</td>";
			}
			$tableBody = $tableBody . "</tr>";
		}
		return $tableBody;
	}
	
	function tableRowGeneratorWithButtons($selectQuery, $editButton, $headerCounter) {
		$tableBody = '';
		$idCounter = 0;
		// This block will retrieve an array from the database, which will be used to assign values
		// to an HTML table.
		while ($row = mysqli_fetch_array($selectQuery, MYSQLI_NUM)) {
			$tableBody = $tableBody . "<tr>";
			// This block will add individual field values to the table.
			for($a = 0;$a < $headerCounter;$a++) {
				$tableBody = $tableBody . "<td>{$row[$a]}</td>";
			}
			// This block will add an edit button, an activate button, and a deactivate button 
			// to the table.
			if (!empty($editButton[$idCounter])) {
				$tableBody = $tableBody . $editButton[$idCounter];
				$idCounter++;
				$tableBody = $tableBody . $editButton[$idCounter];
				$idCounter++;
				$tableBody = $tableBody . $editButton[$idCounter];
				$idCounter++;
			}
			$tableBody = $tableBody . "</tr>";
		}
		return $tableBody;
	}
	
	function tableRowGeneratorWithRadioButtons($selectQuery, $radioButton, $headerCounter, $ids) {
		$tableBody = '';
		$rowCounter = 0;
		// This block will retrieve an array from the database, which will be used to assign values
		// to an HTML table.
		while ($row = mysqli_fetch_array($selectQuery, MYSQLI_NUM)) {
			$tableBody = $tableBody . "<tr id = '{$ids[$rowCounter][0]}'>";
			$rowCounter++;
			// This block will add individual field values to the table.
			for($a = 0;$a < $headerCounter;$a++) {
				$tableBody = $tableBody . "<td>{$row[$a]}</td>";
			}
			// This block will add an edit button, an activate button, and a deactivate button 
			// to the table.
			$tableBody = $tableBody . $radioButton;
			$tableBody = $tableBody . "</tr>";
		}
		return $tableBody;
	}
	
	function tableRowRadioButtonGenerator($editorQuery) {
		$button = "<td><select>";
			// The idea for this code was inspired by xdazz.
		while ($editors = mysqli_fetch_array($editorQuery, MYSQLI_NUM)){			
			for($a = 0;$a < count($editors);$a++) {
				$button = $button . '<option value=' . $editors[$a] . '>' . $editors[$a] . '</option>';
			}
		}
		$button = $button . '</select></td>';
		return $button;
	}
	
	function tableRowLinkGenerator($idSelectQuery) {
		$editButton = array();
		while ($ids = mysqli_fetch_array($idSelectQuery, MYSQLI_NUM)) {
			for($a = 0;$a < count($ids);$a++) {
				// The idea for this code was inspired by xdazz.
				$button = '<td><a href="EditAnnouncement.php?id='.$ids[$a].'">Edit</a></td>';
				// The idea for this code was inspired by Bart S.
				array_push($editButton, $button);
				// The idea for this code was inspired by xdazz.
				$button = '<td><a href="ManageAnnouncements.php?deleteId='.$ids[$a].'">Deactivate</a></td>';
				// The idea for this code was inspired by Bart S.
				array_push($editButton, $button);
				// The idea for this code was inspired by xdazz.
				$button = '<td><a href="ManageAnnouncements.php?activateId='.$ids[$a].'">Activate</a></td>';
				// The idea for this code was inspired by Bart S.
				array_push($editButton, $button);
				
			}
		}
		return $editButton;
	}
	
	function tableRowLinkGeneratorFileManagement($idSelectQuery) {
		$downloadButton = array();
		while ($ifs = mysqli_fetch_array($idSelectQuery, MYSQLI_NUM)) {
			for($a = 0;$a < count($ifs);$a++) {
				// The idea for this code was inspired by xdazz.
				$button = '<td><a href="DownloadFile.php?id='.$ifs[$a].'">Download</a></td>';
				// The idea for this code was inspired by Bart S.
				array_push($downloadButton, $button);
			}
		}
		return $downloadButton;
	}
		
		function tableRowGeneratorWithButtonsFileManagement($selectQuery, $downloadButton, $headerCounter) {
		$tableBody = '';
		$idCounter = 0;
		// This block will retrieve an array from the database, which will be used to assign values
		// to an HTML table.
		while ($row = mysqli_fetch_array($selectQuery, MYSQLI_NUM)) {
			$tableBody = $tableBody . "<tr>";
			// This block will add individual field values to the table.
			for($a = 0;$a < $headerCounter;$a++) {
				$tableBody = $tableBody . "<td>{$row[$a]}</td>";
			}
			// This block will add an download button
			// to the table.
			if (!empty($downloadButton[$idCounter])) {
				$tableBody = $tableBody . $downloadButton[$idCounter];
				$idCounter++;
				
			}
			$tableBody = $tableBody . "</tr>";
		}
		return $tableBody;
	}
	
?>