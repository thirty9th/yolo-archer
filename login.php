<?php

///////////////////////////////////////////////////////////////////////////////////////////////////
// Functions
///////////////////////////////////////////////////////////////////////////////////////////////////

// Check the user's entered login info against that stored in the datase
// Begins a session if the info was valid and displays an error message otherwise
function checkLoginInfo($inUsername, $inPassword)
{
	// Do some error-checking
	if (strlen($inPassword) < 7)
	{
		echo '<p>Error! Invalid password length.</p>';
		return;
	}
	else if (strlen($inUsername) < 3 || strlen($inUsername) > 45)
	{
		echo '<p>Error! Invalid username length. </p>';
		return;
	}
	
	// Open a database connection
	$dbHost = '8.191.214.214';
    $dbUsername = 'galefisher';
	$dbPassword = 'galefisher';       
	$dbTable = 'galefisherautoparts';
	$dbPort = 3306;
	$con = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbTable, $dbPort);
	if (!$con)
	{
		exit('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
	}
	mysqli_set_charset($con, 'utf-8');
	
	// Check entered values against stored values
	// First check if the username entered exists in the database
	$query = 'select username from customer where username = "' . $inUsername . '"';
	if(mysqli_num_rows(mysqli_query($con, $query)) == 0)	// Entry is not found
	{
		echo '<p>Error! Requested username not found. </p>';
		return;
	}
	$query = 'select password from customer where username = "' . $inUsername . '"';
	
	// Check password against stored password
	if (mysqli_query($con, $query) == $inPassword)
	{
		echo '<p>Thank you for logging in, ' . $inUsername . '.</p>';
	}
	else
	{
		echo '<p>Sorry, the password you entered was incorrect. Please try again.</p>';
	}
}

// Header material
echo '
<html>
<head>
	<title>Gale-Fisher Auto Parts</title>
	<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>

	<div id="header">
		<div id="header-small-logo-wrapper">
			<a href="main.php"><img src="images/button_home_tab.png" alt="Logo" /></a>
		</div>
		<div class="login"><a href="customerRegistration.php">Register</a>&nbsp;&nbsp;&nbsp;<a href="login.php">Login</a></div>
	</div>
	<div id="login-content-wrapper">';

// Page was requested via the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	// Check login info
	echo '<p>DEBUG: pass was ' . $_POST['password'] . '</p>';
	echo '<p>DEBUG: user was ' . $_POST['username'] . '</p>';
	checkLoginInfo($_POST['username'], $_POST['password']);
	
}
else	// Page was (probably) requested via simple HTTP request
{
	// Display initial page requesting login info
	// Body
	echo '
		<div id="content-title">
			<p class="content-title">Please enter your login information below.</p>
			<form class="login-input" method="POST">
				<p class="normal">Username </p><input type="text" name="username" /><br />
				<p class="normal">Password </p><input type="password" name="password" /><br />
				<input type="submit" id="submit" value="Submit" style="color:#2a2a2a; float:right;" />
			</form>
		</div>';
}

// Footer
echo '
	</div>
	<div id="footer-wrapper">
		<div id="footer-content">
			<p class="footer-text">Site and database implementation created by:<br />
			James Gale and Dillon Fisher<br />
			Last updated: November 2013</p>
		</div>
	</div>
</body>
</html>';

?>
