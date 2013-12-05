<?php

echo '
<div id="header">
	<div id="header-small-logo-wrapper">
		<a href="main.php"><img src="images/button_home_tab.png" alt="Logo" /></a>
	</div>
	<div class="navbar-wrapper">
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
                        echo '<div id="navbar-item">
                        	<a href="checkout.php"><img src="images/button_navbar_checkout.png" alt="Check Out" /></a>
                            </div>';
                    }
                    if($_SESSION["type"]=="employee" || $_SESSION["type"] == "manager"){
                        echo '<div id="navbar-item">
                        	<a href="restock.php"><img src="images/button_navbar_restock.png" alt="Restock Parts" /></a>
                            </div>';
                    }
                    if($_SESSION["type"]=="manager"){
                        echo '<div id="navbar-item">
                        	<a href="employeeRegistration.php"><img src="images/button_navbar_add_employee.png" alt="Add Employee" /></a>
                            </div>';
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
                if($_SESSION["type"] == "customer"){
                    echo '
			<a href="customerControlPanel.php">[' . $_SESSION['username'] . ']</a>&nbsp;<a href="logout.php">Logout</a>';
                } 
                else{
                     echo '
			<p>User:</p><a href="employeeControlPanel.php">[' . $_SESSION['username'] . ']</a>&nbsp;<a href="logout.php">Logout</a>';
                }
		
	}
	echo '
	</div>';
	if ($_SESSION["type"] == "customer") {
		echo '
		<div class="cart">
			<a href="shoppingCart.php"><img src="images/shopping_cart.png" alt="Shopping Cart" /></a>
		</div>';
	}
echo'
</div>';

?>