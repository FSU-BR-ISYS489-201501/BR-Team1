<!-- By Faisal Alfadhli-->
<!--Email: alfadhf@ferris.edu-->
<!--This is my own cod I wrote it 2 years ago for ISYS 288  -->
<!--02/04/2016 -->
<!-- header -->
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $page_title; ?></title>	
	<meta charset='utf-8' />
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<title>GRDE328: JCI</title>
<!--[if lt IE 9]>
<script src='http://html5shim.googlecode.com/svn/trunk/html5.js'></script>
<![endif]-->
		
<link rel='stylesheet' href='styles/jci.css'>
<link href='https://fonts.googleapis.com/css?family=Noto+Sans' rel='stylesheet' type='text/css'>
</head>
	<body>
		<div class='header'>
					<div class='container'>
						<div class='logo'>
							<img src='styles/images/icon_logo_opt.png' alt='Logo' class='icon'>
							
							
		<?php
			session_start();
			if(!isset($_SESSION['FName'])) {
				echo "
									<div class='login'>
										<a href='Login.php' class='login'>LOGIN</a>
										<a href='Register.php' class='login'>REGISTER</a>
									</div>
								</div>
								<br>
								<div class='mainmenu'>
									<a href='Index.php' class='button2'>Home</a>
									<a href='Search.php' class='button2'>Search</a>
									<a href='AboutUs.php' class='button2'>About Us</a>
									<a href='ContactUs.php' class='button2'>Contact Us</a>
								</div>
							</div>
						</div>
					";
			}
			else if(!isset($_SESSION['Type'])) {
				echo "
								<div class='login'>
									Hello, {$_SESSION['FName']}!
									<a href='Logout.php' class='button4'>LOGOUT</a>
								</div>
							</div>
							<br>
							<div class='mainmenu'>
								<a href='Index.php' class='button2'>Home</a>
								<a href='Search.php' class='button2'>Search</a>
								<a href='AboutUs.php' class='button2'>About Us</a>
								<a href='ContactUs.php' class='button2'>Contact Us</a>
							</div>
						</div>
					</div>
				";
			}
					
			else {
				if ($_SESSION['Type'] == 'Editor' || $_SESSION['Type'] == 'editor') {
					echo "
									<div class='login'>
										Hello, {$_SESSION['FName']}!
										<a href='Logout.php' class='button4'>LOGOUT</a>
									</div>
								</div>
								<br>
								<div class='mainmenu'>
									<a href='Index.php' class='button2'>Home</a>
									<a href='Search.php' class='button2'>Search</a>
									<a href='AboutUs.php' class='button2'>About Us</a>
									<a href='ContactUs.php' class='button2'>Contact Us</a>
									<a href='SubmitCase.php' class='button2'>Submit a Case</a>
									<br>
									<br>
									<a href='BrowseCriticalIncidents.php' class = 'button4'>Browse</a>
									<a href='ManageAnnouncements.php' class = 'button4'>Manage Announcements</a>
									<a href='CriticalIncidents.php' class = 'button4'>Manage Reviewers</a>
								</div>
							</div>
						</div>
					";
				}
				else if ($_SESSION['Type'] == 'Author' || $_SESSION['Type'] == 'author') {
					echo "
									<div class='login'>
										Hello, {$_SESSION['FName']}!
										<a href='Logout.php' class='button4'>LOGOUT</a>
									</div>
								</div>
								<br>
								<div class='mainmenu'>
									<a href='Index.php' class='button2'>Home</a>
									<a href='Search.php' class='button2'>Search</a>
									<a href='AboutUs.php' class='button2'>About Us</a>
									<a href='ContactUs.php' class='button2'>Contact Us</a>
									<a href='SubmitCase.php' class='button2'>Submit a Case</a>
								</div>
							</div>
						</div>
					";
				}
			}
			session_write_close();
		?>
		<div id='content'><!-- Start of the page-specific content. -->
			<div class = 'container'>
