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
    <div id="login-content-wrapper">';
        
    echo'<a href ="employeeAccountManagement.php" >Account Management</a><br/><br/>';
    
    echo '<a href="storeInventory.php">Store Inventory</a> <br/><br/>';
    
    echo '<a href="returns.php">Return Part</a> <br/><br/>';

    if($_SESSION["type"] == "manager"){
        echo '<a href="storeOrderHistory.php">Store Order History</a> <br/><br/>';
    }
    
    

    // Footer
    echo '
            </div>';
    include_once('footer.php');
    echo '
    </body>
    </html>';
?>
