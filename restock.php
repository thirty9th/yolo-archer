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
            if(isset($_POST["restock"])){
                restock($_SESSION["username"], $_POST["store"], $_POST["part"], $_POST["quantity"]);
                echo "Restock was a success!";
            }
            
            echo "<form name = \"restockParts\" action = \"restock.php?restock=true\" method = \"POST\">";
            echo "Use the fields below to restock the store!<br/>";
            
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
            echo"</select>   ";
            
            echo"<input type=\"number\" name=\"quantity\" min=\"1\" max=\"5\"><br/>";
            echo "<input type=\"submit\" value=\"restock\" action=\"restock.php?restock=true\" name=\"restock\" />";
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