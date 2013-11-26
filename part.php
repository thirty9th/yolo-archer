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


    if(isset($_GET["part"]) || isset($_POST["part"])) {
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
        
         $sql = "select name, description, price, image from part where name=\"" . $_GET["part"] . "\"";
         $query = mysqli_query($con, $sql);
         if(($row = mysqli_fetch_array($query)) == NULL){
            echo "Whoops! looks like you lost your way. Return to the part search page to try again. <br/>";
            echo "<a href = \"partSearch.php\">Part Search</a>";
         }
         
         echo "<form action = \"part.php?part=" . $_GET["part"] . "\" method = \"POST\">";
    
        echo "
         <div id=\"product-title\">
            <p style=\"font-size: 30px;\">" . $row["name"] . "</p><br/>
         </div> <br/>";
         
         echo"<img src=\"" . $row["image"] . "\" width=\"300\" height=\"300\"/> <br/>";
         
         echo $row["description"] . "<br/>";
         
         echo "$" . $row["price"] . "      <input type=\"number\" name=\"quantity\" min=\"1\" max=\"5\"><br/>";
         
         $addresses = get_store_address();
         echo "Store:  <select name=\"store\">";
         foreach($addresses as $option) : 
            echo "<option value=". $option . "\">" . $option . "</option>";
         endforeach;
         echo"</select> <br/>";
         
         echo "<input type = \"submit\" value = \"Add To Cart\" name = \"addToCart\" /> <br/>";
         
         
         
         echo"</form>";
         
         if(isset($_POST["quantity"])){
             if(isset($_SESSION["username"])){
                 if(!isset($_SESSION["cart"])){
                    $_SESSION["cart"] = array();
                 }
             
                 
                 //See if already in cart
                $found = false;
                if(isset($_SESSION["cart"])){
                    foreach($_SESSION["cart"] as &$carPart){
                        if($carPart["name"] == $row["name"] && $carPart["store"] == $_POST["store"]){
                            $carPart["quantity"] += $_POST["quantity"];
                            $found = true;
                        }
                    }
                }

                if(!$found){
                    array_push($_SESSION["cart"], array("name" => $row["name"],"quantity" => $_POST["quantity"], "store" => $_POST["store"]));
                }
                

                echo "Parts have been added to cart! <br/>";

                print_r($_SESSION["cart"]);
             }
             
             else{
                 echo "You are not logged in! Please login to make a purchase.";
             }
             
             
             
             
         }
    }
    
    else{
        echo "Whoops! looks like you lost your way. Return to the part search page to try again. <br/>";
        echo "<a href = \"partSearch.php\">Part Search</a>";
    }

// Footer
echo '
	</div>';
include_once('footer.php');
echo '
</body>
</html>';

?>