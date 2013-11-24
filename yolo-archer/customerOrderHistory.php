<form action="customerOrderHistory.php" method="POST">
     <?php $customerArray = get_customer_ids(); ?>
        Store:  <select name="customer">
                <?php foreach($customerArray as $option) : ?>
                    <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                <?php endforeach; ?>
                </select>
                    
    <input type="submit" value="Get History" />

</form>




<?php
    function printCustomerOrderHistory($customerId){
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

            $sql = "select * from customer_order_history where customer_id = " . $customerId;
            $query = mysqli_query($con, $sql);

            echo "<table border=\"1\"> <thead> <tr> <th>Order ID</th> <th>Customer ID</th> <th>Store ID</th> <th>Part ID</th> <th>Quantity</th> <th>Order Date</th> <th>Arrival Date</th> </tr>";
            echo "<tbody>";
            while(($row = mysqli_fetch_array($query)) != NULL){
                echo "<tr> <td>" . $row['id'] . "</td> <td>" . $row['customer_id'] . "</td> <td>" . $row['store_id'] . "</td> <td>" . $row['part_id'] . "</td> <td>" . $row['quantity'] . "</td> <td>" . substr($row['order_date'],0, strpos($row['order_date'], " ")) . "</td> <td>" . substr($row['expec_arrival_date'],0, strpos($row['expec_arrival_date'], " ")) . "</td>  </tr>";
            }
            echo "</tbody> </table>";


            echo $sql;

        }
    }
    
    printCustomerOrderHistory($_POST['customer']);
    
    function get_customer_ids() {
        $dbHost = "68.191.214.214";
        $dbUsername = "galefisher";
        $dbPassword = "galefisher";       
        $dbTable = "galefisherautoparts";
        $dbPort = 3306;
        $con = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbTable, $dbPort);
        $query = "select id from customer";
        $result = mysqli_query($con, $query);
        $customerIds = array();
        while(($row = mysqli_fetch_array($result)) != NULL){
            array_push($customerIds, $row["id"]);
        };
        mysqli_close($con);
        return $customerIds;
    }
    
?>
