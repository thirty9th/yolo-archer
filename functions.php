<?php
    
    //This function writes a record to the store_order_history table,
    //And updates the sells table to reflect the restocking of the part.
    function restock($emp_username, $address, $part, $quantity){
        //Connect to database
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
        
        $sql = "select id from employee where username =\"" . $emp_username . "\"";
        $query = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($query);
        $emp_id = $row["id"];
        
        $sql = "select id from store where address like\"%" . $address . "%\"";
        $query = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($query);
        $store_id = $row["id"];
        
        $sql = "select id from part where name like\"%" . $part . "%\"";
        $query = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($query);
        $part_id = $row["id"];
        

        //Also need order date
        $sql = "insert into store_order_history (employee_id, store_id, part_id, quantity, order_date, expec_arrival_date) VALUES (" . $emp_id . ", " . $store_id . " , " . $part_id . ", " . $quantity . ", NOW(), Date_add(NOW(),interval 1 WEEK))";
        if(!mysqli_query($con, $sql)){
                    echo 'Error: ' . mysqli_error($con);
                    exit;
        } 
        
        $sql = "update sells set quantity = quantity + ". $quantity . " where store_id = " . $store_id . " and part_id = " . $part_id;
        
        if(!mysqli_query($con, $sql)){
                    echo 'Error: ' . mysqli_error($con);
                    exit;
        } 
        
        mysqli_close($con);
    }
    
    //This function writes a record to the customer_order_history table,
    //And updates the sells table to reflect the purchasing of the part. 
    function purchase_part($cust_id, $store_id, $part_id, $quantity) {
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

        $sql = "insert into customer_order_history (customer_id, store_id, part_id, quantity, order_date, expec_arrival_date) VALUES (" . $cust_id . ", " . $store_id . ", " . $part_id . ", " . $quantity . ", NOW(), Date_add(NOW(),interval 1 WEEK))";
        if(!mysqli_query($con, $sql)){
                    echo 'Error: ' . mysqli_error($con);
                    exit;
        }
        
        $sql = "update sells set quantity = quantity - ". $quantity . " where store_id = " . $store_id . " and part_id = " . $part_id;
        if(!mysqli_query($con, $sql)){
                    echo 'Error: ' . mysqli_error($con);
                    exit;
        }
        
       mysqli_close($con);
        
    }

    function return_part($store_id, $part_id, $cust_id, $reason, $quantity){
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

        $sql = "insert into returns (store_id, part_id, customer_id, reason, quantity) VALUES (" . $store_id .", " . $part_id . ", " . $cust_id . ", \"" . $reason . "\", " . $quantity . ")";
        if(!mysqli_query($con, $sql)){
            echo 'Error: ' . mysqli_error($con);
            exit;
        } 
        
        $sql = "update sells set quantity = quantity + ". $quantity . " where store_id = " . $store_id . " and part_id = " . $part_id;
        if(!mysqli_query($con, $sql)){
            echo 'Error: ' . mysqli_error($con);
            exit;
        }   
            
        echo "Return was a success!";
        mysqli_close($con);
        $words;
    }
    
    function get_store_address() {
                $dbHost = "68.191.214.214";
                $dbUsername = "galefisher";
                $dbPassword = "galefisher";       
                $dbTable = "galefisherautoparts";
                $dbPort = 3306;
                $con = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbTable, $dbPort);
                $query = "select distinct address from store";
                $result = mysqli_query($con, $query);
                $storeIds = array();
                while(!is_null($row = mysqli_fetch_array($result))){
                    array_push($storeIds, $row["address"]);
                };
                mysqli_close($con);
                return $storeIds;
    }
    
    function get_part_names(){
        $dbHost = "68.191.214.214";
                $dbUsername = "galefisher";
                $dbPassword = "galefisher";       
                $dbTable = "galefisherautoparts";
                $dbPort = 3306;
                $con = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbTable, $dbPort);
                $query = "select distinct name from part";
                $result = mysqli_query($con, $query);
                $parts = array();
                while(!is_null($row = mysqli_fetch_array($result))){
                    array_push($parts, $row["name"]);
                };
                mysqli_close($con);
                return $parts;
    }
        
    //Function found online at http://stackoverflow.com/questions/4466159/delete-element-from-multidimensional-array-based-on-value
    function removeElementWithValue($array, $key, $value){
     foreach($array as $subKey => $subArray){
          if($subArray[$key] == $value){
               unset($array[$subKey]);
          }
     }
     return $array;
}

function printCustomerOrderHistory($customerId){
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

            $sql = "select * from customer_order_history where customer_id = " . $customerId . " order by id desc";
            $query = mysqli_query($con, $sql);

            echo "<table border=\"1\"> <thead> <tr> <th>Order ID</th> <th>Customer Name</th> <th>Store</th> <th>Part Name</th> <th>Quantity</th> <th>Cost</th> <th>Order Date</th> <th>Arrival Date</th> </tr>";
            echo "<tbody>";
            while(($row = mysqli_fetch_array($query)) != NULL){
                $sql = "select name, price from part where id = " . $row["part_id"];
                $result = mysqli_query($con, $sql);
                $newrow = mysqli_fetch_array($result);
                $part = $newrow["name"];
                $price = $newrow["price"];
                
                $sql = "select address from store where id = " . $row["store_id"];
                $result = mysqli_query($con, $sql);
                $newrow = mysqli_fetch_array($result);
                $address = $newrow["address"];
                
                $sql = "select name from customer where id = " . $row["customer_id"];
                $result = mysqli_query($con, $sql);
                $newrow = mysqli_fetch_array($result);
                $name = $newrow["name"];
                                
                echo "<tr> <td>" . $row['id'] . "</td> <td>" . $name . "</td> <td>" . $address . "</td> <td>" . $part . "</td> <td>" . $row['quantity'] . "</td> <td>$" . $row["quantity"] * $price . "</td> <td>" . $row["order_date"] . "</td> <td>" . $row['expec_arrival_date']. "</td>  </tr>";
            }
            echo "</tbody> </table>";


            mysqli_close($con);

}
    
    
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
    
    function printStoreOrderHistory($storeId){
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

        $sql = "select * from store_order_history where store_id = " . $storeId . " order by id desc";
        $query = mysqli_query($con, $sql);

        echo "<table border=\"1\"> <thead> <tr> <th>Order ID</th> <th>Employee ID</th> <th>Store ID</th> <th>Part ID</th> <th>Quantity</th> <th>Order Date</th> <th>Arrival Date</th> </tr>";
        echo "<tbody>";
        while(($row = mysqli_fetch_array($query)) != NULL){
            echo "<tr> <td>" . $row['id'] . "</td> <td>" . $row['employee_id'] . "</td> <td>" . $row['store_id'] . "</td> <td>" . $row['part_id'] . "</td> <td>" . $row['quantity'] . "</td> <td>" . $row["order_date"] . "</td> <td>" . $row['expec_arrival_date']. "</td>  </tr>";
        }
        echo "</tbody> </table>";
    }

?>
