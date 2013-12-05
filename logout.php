<?php session_start();

ini_set('session.use_cookies', '1');

// Header material
echo '
<html>
<head>
	<title>Gale-Fisher Auto Parts</title>
	<link href="style.css" rel="stylesheet" type="text/css" />
</head>';

// Body
echo '
<body>';

	include_once('navbar.php');
	echo '
	<div id="login-content-wrapper">';

// Page was requested via the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	// User confirmed that they wanted to log out, end session
	session_destroy();
	echo '
		<p class="content-title">Logout Status</p>
		<div id="login-result">
			<p>Thank you for logging out.</p>
			<a href="main.php">Return Home</a>
		</div>';
	
}
else	// Page was (probably) requested via simple HTTP request
{
	// Display initial page confirming user logout
	// Body
	echo '
		<p class="content-title">Are you sure you want to log out?</p>
		<div id="rule"></div>
		<form class="login-input" method="POST">
			<input type="submit" id="submit" value="Yes" style="color:#2a2a2a;" />
		</form>
		<a href="main.php">Cancel</a>';
}
	
// Footer
echo '
	</div>';
include_once('footer.php');
echo '
</body>
</html>';

?>