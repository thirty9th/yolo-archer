<form action="storeOrderHistory.php" method="POST">
     <?php $storeArray = get_store_ids(); ?>
        Store:  <select name="store">
                <?php foreach($storeArray as $option) : ?>
                    <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                <?php endforeach; ?>
                </select>
                    
    <input type="submit" value="Get History" />

</form>


<?php 
    function printStoreOrderHistory($storeId){
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $_GET['store'] = $_POST['store'];
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

            $sql = "select * from store_order_history where store_id = " . $storeId;
            $query = mysqli_query($con, $sql);

            echo "<table border=\"1\"> <thead> <tr> <th>Order ID</th> <th>Employee ID</th> <th>Store ID</th> <th>Part ID</th> <th>Quantity</th> <th>Order Date</th> <th>Arrival Date</th> </tr>";
            echo "<tbody>";
            while(($row = mysqli_fetch_array($query)) != NULL){
                echo "<tr> <td>" . $row['id'] . "</td> <td>" . $row['employee_id'] . "</td> <td>" . $row['store_id'] . "</td> <td>" . $row['part_id'] . "</td> <td>" . $row['quantity'] . "</td> <td>" . substr($row['order_date'],0, strpos($row['order_date'], " ")) . "</td> <td>" . substr($row['expec_arrival_date'],0, strpos($row['expec_arrival_date'], " ")) . "</td>  </tr>";
            }
            echo "</tbody> </table>";


            echo $sql;

        }
    }
    
    printStoreOrderHistory($_POST['store']);

//Check to see if current user is manager


//Dropdown for store ids
//submit button
//If manager, show store order history for his store.

    function get_store_ids() {
                $dbHost = "68.191.214.214";
                $dbUsername = "galefisher";
                $dbPassword = "galefisher";       
                $dbTable = "galefisherautoparts";
                $dbPort = 3306;
                $con = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbTable, $dbPort);
                $query = "select distinct id from store";
                $result = mysqli_query($con, $query);
                $storeIds = array();
                while(($row = mysqli_fetch_array($result)) != NULL){
                    array_push($storeIds, $row["id"]);
                };
                mysqli_close($con);
                return $storeIds;
    }



?>