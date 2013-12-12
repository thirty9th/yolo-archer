<?php session_start();

ini_set('session.use_cookies', '1');

// Functions
function getDeal($connection, $partName) {

	$sql = "select name, description, price, image from part where name=\"" . $partName . "\"";
	$query = mysqli_query($connection, $sql);
	if(($row = mysqli_fetch_array($query)) == NULL) {
		echo "Whoops! looks like you lost your way. Return to the part search page to try again. <br/>";
		echo "<a href = \"partSearch.php\">Part Search</a>";
		
	}
	
	$result = "";
	$result .= '<p class="small-heading">' . $row["name"] . '</p>';
	$result .= '<div id="rule"></div>';
	$result .= '<img src="' . $row["image"] . '" alt="Part" /><br /><br />';
	$result .= '<p>$' . $row["price"] . '</p>';
	$result .= '<a href="part.php?part=' . $row["name"] . '">Buy Now</a>';
	echo $result;
}

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
	
	// Database connection
	$dbHost = "68.191.214.214";
	$dbUsername = "galefisher";
	$dbPassword = "galefisher";       
	$dbTable = "galefisherautoparts";
	$dbPort = 3306;
	$con = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbTable, $dbPort);
	if (!$con) {
		exit('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
	}

	mysqli_set_charset($con, 'utf-8');
	
	$deals = array(
		0 => "Smooth Tires",
		1 => "Rough Tires",
		2 => "New Brakes",
		3 => "Turbo Engine 480");
	
	// Main body
	echo '
	<div id="logo-wrapper">
		<div id="logo-image">
			<img src="images/logo_banner.png" alt="Logo" />
		</div>
	</div>
	<div id="content-wrapper">
		<p class="content-title">Daily Deals</p>
		<div id="four-square-wrapper">
			<div id="top-left">';
				getDeal($con, $deals[0]);
			echo '</div>
			<div id="top-right">';
				getDeal($con, $deals[1]);
			echo '</div>
			<div id="bottom-left">';
				getDeal($con, $deals[2]);
			echo '</div>
			<div id="bottom-right">';
				getDeal($con, $deals[3]);
			echo '</div>
		</div>
	</div>';
	
// Footer
include_once('footer.php');
echo '
</body>
</html>';

?>
