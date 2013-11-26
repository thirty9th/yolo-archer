<?php
    
    //This function writes a record to the store_order_history table,
    //And updates the sells table to reflect the restocking of the part.
    function restock($emp_id, $store_id, $part_id, $quantity){
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
        
        echo "Restock was a success!";
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
        
        echo "Purchase was a success!";
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
        
    function checkout($cart){
        //first value is store_id, second is part_id, third is quantity
        
        //check if first store_id has enough part_id for given quantity in the sells table
        
        //return true if ok
        
        //false otherwise
        return true;
    }

?>
