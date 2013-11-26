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
                if(isset($_SESSION["cart"])){
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
                    
                    $finalized = false;
                    //Finalize purchase, if a purchase is being finalized.
                    if(isset($_GET["finalize"])){
                         $validPurchase = true;
                         foreach($_SESSION["cart"] as $key => &$carPart){
                             $sql = "select id from part where name = \"" . $carPart["name"] . "\"";
                             $result = mysqli_query($con, $sql);
                             $row = mysqli_fetch_array($result);
                             $part_id = $row["id"];
                             
                             $sql = "select id from store where address like \"%" . $carPart["store"] . "%\"";
                             $result = mysqli_query($con, $sql);
                             $row = mysqli_fetch_array($result);
                             $store_id = $row["id"];
                             
                             $sql = "select quantity from sells where part_id =" . $part_id ." and store_id = " . $store_id;
                             $result = mysqli_query($con, $sql);
                             $row = mysqli_fetch_array($result);
                             $quantity = $row["quantity"];
                             
                             if($carPart["quantity"] > $quantity){
                                 echo "Store at " . $carPart["store"] . " does not have enough inventory of " . $carPart["name"] . " to make this sale.<br/>";
                                 echo "It has been removed from you cart.<br/>";
                                 $_SESSION["cart"] = removeElementWithValue($_SESSION["cart"], "name", $carPart["name"]);
                                 $validPurchase = false;
                             }
                         }
                         
                         if($validPurchase){
                             foreach($_SESSION["cart"] as $key => &$carPart){
                                $sql = "select id from part where name = \"" . $carPart["name"] . "\"";
                                $result = mysqli_query($con, $sql);
                                $row = mysqli_fetch_array($result);
                                $part_id = $row["id"];

                                $sql = "select id from store where address like \"%" . $carPart["store"] . "%\"";
                                $result = mysqli_query($con, $sql);
                                $row = mysqli_fetch_array($result);
                                $store_id = $row["id"];
                                
                                $sql = "select id from customer where username = \"" . $_SESSION["username"] . "\"";
                                $result = mysqli_query($con, $sql);
                                $row = mysqli_fetch_array($result);
                                $cust_id = $row["id"];

                                purchase_part($cust_id, $store_id, $part_id, $carPart["quantity"]);
                                $_SESSION["cart"] = removeElementWithValue($_SESSION["cart"], "name", $carPart["name"]);
                             }
                             
                             echo "Purchase finalized! Enjoy your car parts!<br/>";
                             $finalized = true;
                                                                             
                         }
                         
                     }
                                        
                    //Print all car parts
                    if(!$finalized){
                        $total = 0;
                        echo "<table border=\"1\" cellpadding=\"10\"> <thead> <tr> <th>Part</th> <th>Quantity</th> <th>Store</th> <th>Cost for Quantity</th></tr>";
                        echo "<tbody>"; 
                        foreach($_SESSION["cart"] as &$carPart){ //name, quantity, store
                            $sql = "select price from part where name =\"" . $carPart["name"] . "\"";
                            $result = mysqli_query($con, $sql);
                            $row = mysqli_fetch_array($result);
                            $price = $row["price"];

                            $sql = "select address from store";
                            $sql .= " where address like '%" . $carPart['store'] . "%'";
                            $result = mysqli_query($con, $sql);
                            $row = mysqli_fetch_array($result);
                            $store = $row["address"];

                            echo "<tr> <td>" . $carPart["name"] . "</td> <td>" . $carPart["quantity"]  . "</td> <td>" . $store . "</td> <td>$" . $price * $carPart["quantity"] . "</td> </tr>";
                            $total += $price * $carPart["quantity"];

                        }
                         echo "</tbody> </table> <br/>";
                         echo "Your total is: $" . $total . "<br/><br/>";

                         echo "Finalize Purchase? <br/><br/>";
                         echo "<form name = \"checkout\" action = \"checkout.php?finalize=true\" method = \"POST\">";
                         echo "<input type=\"submit\" value=\"Finalize\" />";
                         echo "</form>";
                    }
                     

                   mysqli_close($con);
                }
                else{
                    echo "You don't have any car parts in your cart!";
                }
            }
            else{
                echo "You are not a customer! Are you still trying to buy things??";
            }
        }
        else{
        echo "You are not logged in! You cannot checkout without logging in.";
    }
    
    // Footer
    echo '
            </div>';
    include_once('footer.php');
    echo '
    </body>
    </html>';

    
   
    //Allow user to update totals
    
    

?>
