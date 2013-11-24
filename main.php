<!-- Solution for Program 2 - Dillon Fisher -->

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
<body>

	<div id="header">
		<div id="header-small-logo-wrapper">
			<a href="main.php"><img src="images/button_home_tab.png" alt="Logo" /></a>
		</div>
		<div class="login">';
		if (!isset($_SESSION['username']))	// User is not logged in yet
		{
			echo '
				<a href="customerRegistration.php">Register</a>&nbsp;&nbsp;&nbsp;<a href="login.php">Login</a>';
		}
		else	// User is logged in
		{
			echo '
				<a><' . $_SESSION['username'] . '></a>';
		}
		echo '
		</div>
	</div>
	<div id="logo-wrapper">
		<div id="logo-image">
			<img src="images/logo_large.png" alt="Logo" />
		</div>
		<div id="logo-title">
			<p>Gale-Fisher<br/>
			Auto Parts</p>
		</div>
	</div>
	<div id="navbar-wrapper">
		<div id="navbar-item">
			<a href="main.php"><img src="images/button_navbar_home.png" alt="Home" /></a>
		</div>
		<div id="navbar-item">
			<img src="images/button_navbar_parts.png" alt="Parts" />
		</div>
		<div id="navbar-item">
			<img src="images/button_navbar_about.png" alt="About Us" />
		</div>
	</div>
	<div id="content-wrapper">
		<div id="content-title">
			<p>Daily Deals</p>
		</div>
		<div id="four-square-wrapper">
			<div id="top-left">
			</div>
			<div id="top-right">
			</div>
			<div id="bottom-left">
			</div>
			<div id="bottom-right">
			</div>
		</div>
	</div>';
	
// Footer
echo '
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
