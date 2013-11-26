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

    echo '<h> Store Order History </h><br/><br/>';
    
     if(isset($_SESSION["username"])){
        if($_SESSION["type"] = "manager"){
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
            
            $sql = "select store_id from employee where username = \"" . $_SESSION["username"] . "\"";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($result);
            $store_id = $row["store_id"];
            
             printStoreOrderHistory($store_id);
        }
     }
   

    // Footer
    echo '
            </div>';
    include_once('footer.php');
    echo '
    </body>
    </html>';



?>