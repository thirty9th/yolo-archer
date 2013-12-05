<?php session_start();

ini_set('session.use_cookies', '1');

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
	$dbHost = '68.191.214.214';
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
	
	// Check password against stored password
	$query = 'select password from customer where username = "' . $inUsername . '"';
	$result = mysqli_query($con, $query);
	$row = mysqli_fetch_array($result);
	if ($row['password'] == $inPassword)
	{
		echo '<p>Thank you for logging in, ' . $inUsername . '.</p>
			<a href="main.php">Return Home</a>';
		$_SESSION['username'] = $inUsername;
                $_SESSION['type'] = "customer";
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
<body>';

	include_once('navbar.php');
	echo '
	<div id="login-content-wrapper">';

// Page was requested via the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	// Check login info
	echo '<p class="content-title">Login Status</p>
	<div id="rule"></div>
	<div id="login-result">
		<p>';
	checkLoginInfo($_POST['username'], $_POST['password']);
	echo '
		</p>
	</div>';
	
}
else	// Page was (probably) requested via simple HTTP request
{
	// Display initial page requesting login info
	// Body
	echo '
		<p class="content-title">Please enter your customer login information below.</p>
		<div id="rule"></div>
		<form class="login-input" method="POST">
			<p class="normal">Username </p><input type="text" name="username" /><br />
			<p class="normal">Password </p><input type="password" name="password" /><br />
			<input type="submit" id="submit" value="Submit" style="color:#2a2a2a; float:right;" />
		</form>';
        
    echo 'Employee? Login <a href = "employeeLogin.php">Here</a>';
}

// Footer
echo '
	</div>';
include_once('footer.php');
echo '
</body>
</html>';

?>
