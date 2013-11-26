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
        if($_SESSION["type"] == "manager"){
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
             
             echo "<table border=\"1\" cellpadding=\"10\"> <thead> <tr> <th>Part Name</th> <th>Store</th> <th>Quantity</th> </tr>";
             echo "<tbody>";
             $sql = "select * from sells order by store_id asc, part_id asc";
             $result = mysqli_query($con, $sql);
             while(($row = mysqli_fetch_array($result)) != NULL){
                 
                 $newrow=(mysqli_fetch_array(mysqli_query($con, "select address from store where id = " . $row["store_id"])));
                 $store = $newrow["address"];
                 $newrow=(mysqli_fetch_array(mysqli_query($con, "select name from part where id = " . $row["part_id"])));
                 $part = $newrow["name"];
                 
                 echo "<tr> <td>" . $part . "</td> <td>" . $store . "</td> <td>" . $row['quantity'] . "</td> </tr>";
                 
              }
              echo "</tbody> </table>";
        
            
         }
         else{
             echo "Unauthorized access detected. This incident has been reported.";
         }
     }
    else{
        echo "You are not logged in. Are you lost?";
    }
    
   

    
    
    
    
    
        
        
    // Footer
    echo '
            </div>';
    include_once('footer.php');
    echo '
    </body>
    </html>';
?>