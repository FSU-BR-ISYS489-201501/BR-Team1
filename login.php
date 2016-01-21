<html>
<head> 

	<title> LoginForm </title>
	<style type= "text/css">
	h2{letter-spacing: 10px; font-size: .2in; background-color: rgb(0,0,100) ; color: lightblue; text-transform: uppercase; width: 380px;}
	
	fieldset{ width: 350px; font-family: Arial; background-color: lightblue; color: rgb(0,0,100) }
	label{ display: block; position: relative; line-height: 2; margin: 10px 0px;}
	input{ position: absolute; margin-left: 20px; width: 15em; left: 80px; }
	.text{position: absolute; margin-left: 20px; width: 15em;}
	.placeholder{position: relative; left: 0px; width: 70px;}
	span{color: red}
	</style>
</head>

<body>
	<? php
	// This code was written by Larry Ullman and slightly modified
	// Print any error messages, if they exist:
		if (isset($errors) && !empty($errors)) {
			echo '<h1>Error!</h1>
			<p class="error">The following error(s) occurred:<br />';
			foreach ($errors as $msg) {
				echo " - $msg<br />\n";
			}
		}
			echo '</p><p>Please try again.</p>';
	?>
	<h2> TEAM 1 </h2>
		
	<form name= "LoginForm">
	<fieldset>
		<legend> LoginForm </legend>
		<label for="username"> User Name:<span>*</span> <input class= "user" type= "text"/>Username</input></label>
		<label for="password"> Password:<span>*</span><input class="password" type= "password"/>Password</input></label>
		<input class= "placeholder" type="submit" value="Login" >
	</fieldset>
	</form>
</body>
</html>
