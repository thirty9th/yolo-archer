<?php

echo '
<div id="header">
	<div id="header-small-logo-wrapper">
		<a href="main.php"><img src="images/button_home_tab.png" alt="Logo" /></a>
	</div>
	<div id="navbar-wrapper">
		<div id="navbar-item">
			<img src="images/button_navbar_home.png" alt="Home Page" />
		</div>
		<div id="navbar-item">
			<img src="images/button_navbar_parts.png" alt="Parts Catalog" />
		</div>
		<div id="navbar-item">
			<img src="images/button_navbar_about.png" alt="About Us" />
		</div>
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
			<p>User:</p><a>[' . $_SESSION['username'] . ']</a>&nbsp;<a href="logout.php">Logout</a>';
	}
	echo '
	</div>
</div>';

?>