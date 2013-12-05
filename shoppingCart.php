<?php
    session_start();

    ini_set('session.use_cookies', '1');
    include 'functions.php';
    
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
		<div id="login-content-wrapper">
			<p class="content-title">Shopping Cart (' . count($_SESSION["cart"]) . ')</p>
			<div id="rule"></div>
			<div id="cart-content-wrapper">';
			
			// Fill cart contents
			if (isset($_SESSION["cart"])) {
				if (is_array($_SESSION["cart"])) {
					if (count($_SESSION["cart"] > 0)) {
						// Cart is not empty; output the contents
						echo '<table>';
						echo '<tr class="first"><td>Part Name</td><td>Quantity</td><td>Store</td></tr>';
						$rowCount = 0;
						foreach($_SESSION["cart"] as $part) {
							echo '<tr';
								if ($rowCount % 2 == 0) {
									echo ' style="background-color:#e3e3e3"';
								}
							echo '>';
							echo '<td>' . $part["name"] . '</td>';
							echo '<td>' . $part["quantity"] . '</td>';
							echo '<td>' . $part["store"] . '</td>';
							echo '</tr>';
							$rowCount += 1;
						}
						echo '</table>';
					} else {
						// No items in cart
						echo '<p>No items in cart</p>';
					}
				} else {
					// Cart is not an array yet
					echo '<p>No items in cart</p>';
				}
			} else {
				// Customer hasn't used the cart yet
				echo '<p>No items in cart</p>';
			}
			
			echo'
			</div>
		</div>';
    // Footer
    include_once('footer.php');
    echo '
    </body>
    </html>';
?>