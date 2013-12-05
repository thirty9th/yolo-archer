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
	<div id="logo-wrapper">
		<div id="logo-image">
			<img src="images/logo_banner.png" alt="Logo" />
		</div>
	</div>
	<div id="content-wrapper">
		<p class="content-title">Daily Deals</p>
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
include_once('footer.php');
echo '
</body>
</html>';

?>
