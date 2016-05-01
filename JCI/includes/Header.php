<?php
/*********************************************************************************************
 * Original Author: Faisal Alfadhli
 * Date of origination: 02/04/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose: The purpose of this page to allow any user a means of navigating the website.
 * 
 * Credit: I used a post written by Anas to understand how to use session_start(), retrieved 
 * from http://stackoverflow.com/questions/10855972/determine-if-session-superglobal-exists-in-php.
 * 
 * Revision1.1: 04/02/2016 Author: Mark Bowman
 * Description of change. I changed the layout of the header and made it so different account
 * types see a customized header.
 * 
 * Revision1.2: 04/17/2016 Author: Mark Bowman
 * Description of change. I added a comment header and citations.
 ********************************************************************************************/
 ?>
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
			// Citation: Anas
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
									<a href='index.php' class='button2'>Home</a>
									<a href='ViewJournalPDF.php' class='button2'>Published Journals</a>
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
									<br>
									<a href='EditProfile.php'><img src='styles/images/icon_userheader_opt.png' title='Edit Profile' ></a>
								</div>
							</div>
							<br>
							<div class='mainmenu'>
								<a href='index.php' class='button2'>Home</a>
								<a href='ViewJournalPDF.php' class='button2'>Published Journals</a>
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
										<br>
										<a href='EditProfile.php'><img src='styles/images/icon_userheader_opt.png' title='Edit Profile' ></a>
									</div>
								</div>
								<br>
								<div class='mainmenu'>
									<a href='index.php' class='button2'>Home</a>
									<a href='ViewJournalPDF.php' class='button2'>Published Journals</a>
									<a href='Search.php' class='button2'>Search</a>
									<a href='AboutUs.php' class='button2'>About Us</a>
									<a href='ContactUs.php' class='button2'>Contact Us</a>
									<a href='SubmitCase.php' class='button2'>Submit a Case</a>
									<br>
									<br>
									<a href='UserManagement.php' class = 'button4'>User Management</a>
									<a href='WebsiteManagement.php' class = 'button4'>Website Management</a>
									<a href='NextVolumeManagement.php' class = 'button4'>Volume Management</a>
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
										<br>
										<a href='EditProfile.php'><img src='styles/images/icon_userheader_opt.png' title='Edit Profile' ></a>
									</div>
								</div>
								<br>
								<div class='mainmenu'>
									<a href='Index.php' class='button2'>Home</a>
									<a href='ViewJournalPDF.php' class='button2'>Published Journals</a>
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
