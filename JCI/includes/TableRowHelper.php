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
 * Function:  tableRowGenerator($dbc, $selectQuery, $headerCounter)
 * Purpose: This function creates table rows that will contain the information retrieved from 
 * the database query. The number of rows will represent the number of returned records, and
 * the number of columns will represent the number of fields in the table.
 * Variable: $headerCounter - This is the number of fields being returned (columns).
 * 
 * Function:  tableRowGeneratorWithButtons($dbc, $selectQuery, $editButton, $headerCounter)
 * Purpose: This function creates table rows that a string containing buttons. This will be saved to a 
 * string and then returned. Variable: $editButton - This is an array with the edit button, activate button, and
 * deactivate button.
 * 
 * Function:  tableRowLinkGenerator($dbc, $idSelectQuery)
 * Purpose: This function automatically creates the edit button, activate button, and
 * deactivate button that will be used in the tableRowGeneratorWithButtons function.
 *
 * these is created by Faisal
 * Function:  tableRowGeneratorWithCheckbox($selectQuery, $editButton, $headerCounter)
 * Purpose: This function creates table rows that contain check box. This will be saved to a string and then returned.
 * 
 * Function:  tableRowCheckboxGenerator($selectQuery, $idSelectQuery)
 * Purpose: This function automatically creates the check box that will be used in the tableRowGeneratorWithCheckbox Function.
 * 
 * 
 * Function:  tableRowGeneratorWithOneButton($selectQuery, $editButton, $headerCounter)
 * Purpose: This function creates table rows that contain a link for assgin reviwers.
 * This will be saved to a string and then returned.
 * 
 * Function DropDownList($selectQuery, $field)
 * Purpose: This function creates dropdown list to select a value.
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
	
	function tableRowGeneratorWithButtons($selectQuery, $editButton, $buttonCounter, $headerCounter) {
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
			for($a = 0;$a < $buttonCounter;$a++) {
				$tableBody = $tableBody . $editButton[$idCounter];
				$idCounter++;
			}
			$tableBody = $tableBody . "</tr>";
		}
		return $tableBody;
	}
	
	function tableRowLinkGenerator($idSelectQuery, $pageName, $variableName, $title) {
		$editButton = array();
		while ($ids = mysqli_fetch_array($idSelectQuery, MYSQLI_NUM)) {
			for($a = 0;$a < count($ids);$a++) {
				for($b = 0;$b < count($variableName);$b++) {
					// The idea for this code was inspired by xdazz.
					$button = '<td><a href=' . $pageName[$b] . '?' . $variableName[$b] . '=' . $ids[$a] . '>' . $title[$b] . '</a></td>';
					// The idea for this code was inspired by Bart S.
					array_push($editButton, $button);
				}
			}
		}
		return $editButton;
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
	
	// the idea from Mark's code 
	function tableRowGeneratorWithCheckbox($selectQuery, $editButton, $headerCounter) {
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
			}
			$tableBody = $tableBody . "</tr>";
		}
		return $tableBody;
	}
		
	// the idea from Mark's code 
	// makes check box in every row 
	// Edited this Function to accept any iput type as a parameter. inpspired by William.
	function tableRowCheckboxGenerator($checkORradio, $selectQuery, $idSelectQuery) {
		$inputType = array();
		while ($ids = mysqli_fetch_array($idSelectQuery, MYSQLI_NUM)) {
			echo "<tr>";
			for($a = 0;$a < count($ids);$a++) {
				// The idea for this code was inspired by xdazz.
				$chkRdioButtonBox = "<td><input type='" . $checkORradio . "' name='checkList[]' value='$ids[$a]'></td>";
				// The idea for this code was inspired by Bart S.
				array_push($inputType, $chkRdioButtonBox);
			}
			echo "</tr>";
		}
		return $inputType;
	}
	
	// the idea from Mark's code 
	// this function makes a link in every row for assgin reviewers page 
	function tableRowEditGenerator($idSelectQuery, $pageName, $title) {
			$assignButton = array();
			while ($ids = mysqli_fetch_array($idSelectQuery, MYSQLI_NUM)) {
				// made dynamic with count page name
				for($a = 0;$a < count($ids);$a++) {
					for($b = 0;$b < count($pageName);$b++) {
						// The idea for this code was inspired by xdazz.
						$button = '<td><a href=' . $pageName[$b] . '?id='.$ids[$a] . '>' . $title[$b] . '</a></td>';
						// The idea for this code was inspired by Bart S.
						array_push($assignButton, $button);
					}						
				}
			}
			return $assignButton;
		}
	// this idea from William
	// function for remove reviewer : adds elements to our php page.
	function spitHTML($incidentId, $tableBody) {	
		echo "<h1>Remove Reviewers</h1>
			<div id = 'divRemoveReviewers'>
				<div class='main'>
					<form name='frmRemoveReviwers' action='RemoveReviewers.php' method='post'>
						<input type='hidden' name='id' value='$incidentId'>
						<label class='heading'>Select users to remove from case:</label><br/><br/>
						<table>
							<tr>
								<th>User Id</th>
								<th>First Name</th>
								<th>Last Name</th>
							</tr>
							$tableBody
						</table>
						<!-----Including PHP Script----->
						<br/><input type='submit' name='submit' Value='Submit'/><br/><br/>
					</form>
				</div>
			</div>";
	}
	// function for remove Editor : adds elements to our php page	
	function spitMoreHTML($incidentId, $tableBody) {	
		echo "<h1>Remove Editors</h1>
			<div id = 'divRemoveEditors'>
				<div class='main'>
					<form name='frmRemoveEditors' action='RemoveCasesFromEditors.php' method='post'>
						<input type='hidden' name='id' value='$incidentId'>
						<label class='heading'>Select an editor to review case:</label><br/><br/>
						<table>
							<tr>
								<th>Editor</th>
							</tr>
							$tableBody
						</table>
						<!-----Including PHP Script----->
						<br/><input type='submit' name='submit' Value='Submit'/><br/><br/>
					</form>
				</div>
			</div>";
	}
		
	// This function is to create dropdown list.
	// It was created by my tutor: William Quigley, Email : mnewrath@gmail.com
	function DropDownList($selectQuery, $field){
		$catddbox = "<select name='slctCategory'>
			  <option value=''>Select...</option>";
		while ($row = mysqli_fetch_array($selectQuery)) {
			$data = $row["$field"];
			$catddbox = $catddbox . "<option value='$data'>$data</option>";
		}
		$catddbox = $catddbox . "</select>";
		return $catddbox;
	}
?>