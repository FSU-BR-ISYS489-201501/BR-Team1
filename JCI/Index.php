<?php

/*********************************************************************************************
 * Original Author: Shane Workman
 * Date of origination: 02/08/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose of Page: This is the index.php and will serve as the home page content of the site.
 ********************************************************************************************/
	$page_title = 'Home';
	include ('includes/Header.php');
	include('includes/TableRowHelper.php');
	require('../DbConnector.php');
	
	$currentDate = date("Y-m-d");
	$query = "SELECT AnnouncementId, Subject, Body FROM announcements WHERE IsActive = 1 AND StartDate < '{$currentDate}' 
		AND EndDate > '{$currentDate}';";
	
	// Stole from Shane Workman's Register code
	$selectQuery = @mysqli_query($dbc, $query);
	
	$headerCounter = mysqli_num_fields($selectQuery);
	$tableBody = tableRowGenerator($selectQuery, $headerCounter);
?>

<H1>Welcome to JCI</H1>
<br>
<div id = 'announcementViewer'>
	<table>
		<tr>
			<th></th>
			<th>Subject</th>
			<th>Announcement</th>
		</tr>
		<?php echo $tableBody; ?>
	</table>
</div>
<br>
<!--Lorem Ipsum coped from http://lorem-ipsum.perbang.dk/ -->
<h2>Enjoy some Lorem Ipsum while we finish development!</h2>
<p>Lorem ipsum dolor sit amet, dolor quam vivamus arcu augue, scelerisque in pharetra nisl, sed convallis odio in blandit nulla ullamcorper, accumsan dapibus urna sodales sed, luctus nunc. Arcu lobortis vitae. Duis est arcu pellentesque, ut ac ut vestibulum vulputate gravida, donec libero et at dictum ut, a dapibus hendrerit in pellentesque tempus cum, diam ut at aliquam ultricies fringilla. Amet mattis mattis mauris, elit sagittis cum curae nam non. Faucibus phasellus quis nulla sed nec, varius in aliquam at pellentesque amet, sit vestibulum nec eget, dui platea diam erat non augue tincidunt, et maecenas cursus suscipit varius. Et eget tincidunt, sit augue ullamcorper integer, wisi sagittis, a maecenas pharetra. Ante id, vivamus diam urna. Amet eros tincidunt eros volutpat nam a. Quisque orci elementum nec sem. Quisque laoreet quisque, mi fringilla et gravida suspendisse a, fusce ipsum leo metus nonummy eget amet, duis aliquam ornare tempus dictum, pulvinar sed massa urna faucibus consequat lobortis.
Semper unde morbi duis, ac magna nonummy leo nulla ut pellentesque, elementum accumsan etiam, a id ullamcorper primis vitae adipisicing dictumst. Tortor at integer ut quis, luctus scelerisque dui cursus in est, sapien erat sed, in pellentesque vitae amet ac nonummy sollicitudin, mi wisi et sit purus. Egestas sed elit ultrices morbi orci vel. Curabitur suscipit. Vestibulum mattis, est ad maecenas vestibulum, placerat in morbi parturient, lobortis duis mi viverra eget nunc dis.
Vestibulum magnis ultricies, vel eleifend ullamcorper fermentum elit, quam nulla aliquam, eu justo mauris velit, pede cursus. Integer eget est cras. A libero pulvinar aliquet nunc, porro ut sed commodo et id tellus, amet amet ante accumsan vitae nostra ullamcorper, posuere justo in vestibulum sed. Quam praesent nec mauris a lacinia, torquent id porta semper, erat leo dictumst pellentesque laoreet. Nam ipsum nulla dolor eget, aliquet in lectus netus wisi etiam eu, bibendum integer et vehicula ipsum magna. Nullam faucibus hendrerit eget amet id, sodales aenean vitae sed euismod ac in, iaculis arcu. Ornare sed, commodo auctor. Sed odio aptent rutrum vitae odio quis. Integer pulvinar tellus nulla et, morbi amet diam. Mi convallis vel, nunc vestibulum, mattis diam ipsum eleifend quia dui arcu, sit justo neque. Amet turpis non faucibus urna.
Mollis et lobortis vestibulum praesent. Vitae sollicitudin numquam nam nec sollicitudin, lectus laoreet leo bibendum ligula, eros esse velit. Odio sit. Arcu blandit, molestie animi volutpat nisl, a libero, pellentesque molestie vitae accusamus dolor, nullam maecenas rerum. Turpis ipsum lacus ullamcorper integer, ut leo facilisis facilisi nulla ut aliquam, per lectus sollicitudin molestiae, turpis egestas venenatis sagittis lorem. Curabitur lorem, lorem nec nunc donec adipiscing metus nostra. Sit ut diam sed turpis risus, sem ornare montes. Eu volutpat et nullam semper mollis, neque congue elit mi nec egestas, maecenas integer metus lorem, consectetuer in. Tincidunt diam etiam aliquam vitae, mattis pellentesque nam ipsum erat. Porttitor risus, odio at feugiat eget, velit velit eget. Eu cras ante, cras bibendum, ad tincidunt duis, felis quam ornare et luctus aliqua. Ut per dictumst at nec, sed neque mollis ligula purus magna quisque, ut vitae.</p>

<?php
	include ('includes/Footer.php');
?>
