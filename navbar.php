<?php

echo '
<div id="header">
	<div id="header-small-logo-wrapper">
		<a href="main.php"><img src="images/button_home_tab.png" alt="Logo" /></a>
	</div>
	<div id="navbar-wrapper">
		<div id="navbar-item">
			<a href="main.php"><img src="images/button_navbar_home.png" alt="Home Page" /></a>
		</div>
		<div id="navbar-item">
			<a href="partSearch.php"><img src="images/button_navbar_parts.png" alt="Parts Catalog" /></a>
		</div>
		<div id="navbar-item">
			<img src="images/button_navbar_about.png" alt="About Us" />
		</div>';
                if(isset($_SESSION["username"])){
                    if($_SESSION["type"]=="customer"){
                        echo"<div id=\"navbar-item\">
                        	<a href=\"checkout.php\">Checkout</a>
                            </div>'";
                    }
                    if($_SESSION["type"]=="employee" || $_SESSION["type"] == "manager"){
                        echo"<div id=\"navbar-item\">
                        	<a href=\"restock.php\">Restock Parts</a>
                            </div>'";
                    }
                    if($_SESSION["type"]=="manager"){
                        echo"<div id=\"navbar-item\">
                        	<a href=\"employeeRegistration.php\">Register New Employee</a>
                            </div>'";
                    }
                }

	echo '</div>
	<div class="login">';
	if (!isset($_SESSION['username']))	// User is not logged in yet
	{
		echo '
			<a href="customerRegistration.php">Register</a>&nbsp;&nbsp;&nbsp;<a href="login.php">Login</a>';
	}
	else	// User is logged in
	{
		echo '
			<p>User:</p><a href="customerControlPanel.php">[' . $_SESSION['username'] . ']</a>&nbsp;<a href="logout.php">Logout</a>';
	}
	echo '
	</div>
</div>';

?>