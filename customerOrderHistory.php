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

    if(isset($_SESSION["username"])){
        if($_SESSION["type"] = "customer"){
            $dbHost = "68.191.214.214";
            $dbUsername = "galefisher";
            $dbPassword = "galefisher";       
            $dbTable = "galefisherautoparts";
            $dbPort = 3306;
            $con = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbTable, $dbPort);
            if (!$con) {
                exit('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
                }

            mysqli_set_charset($con, 'utf-8'); 
            
            $sql = "select id from customer where username = \"" . $_SESSION["username"] . "\"";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($result);
            $cust_id = $row["id"];
            
            printCustomerOrderHistory($cust_id);
        }
        else{
            echo "You are not a customer! You do not have history!";
        }
        
    }
    else {
        echo "You have not logged in to a customer account. How did you get here?";
    }
    
    // Footer
    echo '
            </div>';
    include_once('footer.php');
    echo '
    </body>
    </html>';
    
?>
