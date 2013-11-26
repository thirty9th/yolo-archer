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
        
    echo"<a href = >Account Management</a><br/><br/>";

    echo '<a href="customerOrderHistory.php">Order History</a>';

    // Footer
    echo '
            </div>';
    include_once('footer.php');
    echo '
    </body>
    </html>';
?>
