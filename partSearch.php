<?php
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
            <div id="search-content-wrapper">';
?>

<form class="search-input" action="partSearch.php" method="POST">
Search: <input type="text" name="search" value="" />
<select name="criteria">
    <option value="name">Name</option>
    <option value="type">Type</option>
    <option value="description">Description</option>
</select>
<input type="submit" value="Search" />
</form>

<?php 
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
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
        
        $sql = "select name, type, description, price from part";
        $sql .= " where " . $_POST['criteria'] . " like '%" . $_POST['search'] . "%'";
        $query = mysqli_query($con, $sql);
                
        echo "<table border=\"1\" cellpadding=\"10\"> <thead> <tr> <th>Name</th> <th>Type</th> <th>Description</th> <th>Price</th> </tr>";
        echo "<tbody>";
        while(($row = mysqli_fetch_array($query)) != NULL){
            echo "<tr> <td>" . $row['name'] . "</td> <td>" . $row['type'] . "</td> <td>" . $row['description'] . "</td> <td>$" . $row['price'] . "</td> </tr>";
        }
        echo "</tbody> </table>";
      }
?>

<?php
    // Footer
    echo '
            </div>';
    include_once('footer.php');
    echo '
    </body>
    </html>';
?>



