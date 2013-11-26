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
        if($_SESSION["type"] == 'employee' || $_SESSION["type"] == 'manager'){
            if(isset($_POST["return"])){
                return_part($_POST["store"],  $_POST["part"],  $_POST["customer_name"],  $_POST["reason"],  $_POST["quantity"]);
                echo "Return processed. <br/>";
            }
            
            echo "<form name = \"returnParts\" action = \"returns.php?return=true\" method = \"POST\">";
            echo "Fill out the following information to process a return.<br/>";
            
            $addresses = get_store_address();
            echo "Store:  <select name=\"store\">";
            foreach($addresses as $option) : 
                echo "<option value=". $option . "\">" . $option . "</option>";
            endforeach;
            echo"</select>  ";
            
            $parts = get_part_names();
            echo "Part:  <select name=\"part\">";
            foreach($parts as $option) : 
                echo "<option value=". $option . "\">" . $option . "</option>";
            endforeach;
            echo"</select>  <br/> ";
            
            echo 'Customer Name: <input type="text" name="customer_name" value="" />';
            
            echo 'Reason: <input type="text" name="reason" value="" />';
            
            
            echo"Quantity: <input type=\"number\" name=\"quantity\" min=\"1\" max=\"5\"><br/>";
            echo "<input type=\"submit\" value=\"Process Return\" action=\"return.php?return=true\" name=\"return\" />";
            echo "</form>";
            
            //echo "restock(" . $_SESSION["username"] .", " . $_POST["store"] . ", " . $_POST["part"] . ", " . $_POST["quantity"] . ")\"";
            
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