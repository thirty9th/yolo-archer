<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $dbHost = "68.191.214.214";
        $dbUsername = "galefisher";
        $dbPassword = "galefisher";       
        $dbTable = "galefisherautoparts";
        $dbPort = 3306;
        $con = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbTable, 3306);
        if (!$con) {
            exit('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
            }

        mysqli_set_charset($con, 'utf-8');
 
        $usernameIsValid = true;
        $usernameIsDuplicate = true;
        $passwordIsValid = true;
        $passwordsMatch = true;
        $nameIsValid = true;
        $addressIsValid = true;
        $phoneIsValid = true;
        $storeIsValid = true;
        $departmentIsValid = true;
            
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if(strlen($_POST['username']) < 3 || strlen($_POST['username']) > 45){
                $usernameIsValid = false;
            }
            if(strlen($_POST['password1']) < 7 || strlen($_POST['password2']) < 7){
                $passwordIsValid = false;
            }
            if($_POST['password1'] != $_POST['password2']){
                $passwordsMatch = false;
            }
            if(strlen($_POST['name']) < 3 || strlen($_POST['name']) > 45){
                $nameIsValid = false;
            }
            if(strlen($_POST['address']) < 3 || strlen($_POST['address']) > 45){
                $addressIsValid = false;
            }
            if(strlen($_POST['phone']) != 10){
                $phoneIsValid = false;
            }
            if(strlen($_POST['store']) < 1){
                $storeIsValid = false;
            }
            if(strlen($_POST['department']) < 1){
                $departmentIsValid = false;
            }
            
            
            
            //check to see if username is a duplicate
            $query = "select username from login where username = '" .  $_POST[username] . "'";
            if(mysqli_num_rows(mysqli_query($con, $query)) > 0){
                $usernameIsDuplicate = false;
            }
                                    
            if($usernameIsValid && $passwordIsValid && $passwordsMatch && $nameIsValid && $addressIsValid && $storeIsValid && $departmentIsValid){
                                
                 $sql="INSERT INTO employee (name, address, store, department) VALUE"
                . "('$_POST[name]','$_POST[address]','$_POST[cc_number]','$_POST[phone]','$_POST[email]')";
                
                if(!mysqli_query($con, $sql)){
                    echo 'Error: ' . mysqli_error($con);
                    exit;
                } 
                
                //Get id of newly inserted employee
                $sql = "select id from customer where name = '" . $_POST[name] . "' and cc_number = '" . $_POST[cc_number] . "'";
                $row = mysqli_fetch_array(mysqli_query($con, $sql));
                $id = $row["id"];
                
                $sql = "INSERT INTO login (id, username, password) VALUE" 
                . "('$id','$_POST[username]','$_POST[password1]')";
                
                if(!mysqli_query($con, $sql)){
                    echo 'Error: ' . mysqli_error($con);
                    exit;
                }
                
                echo "User account registered!";
                
            }
            
            
        }
        
        
            



            //Code to get enum values borrowed from http://stackoverflow.com/questions/2350052/how-can-i-get-enum-possible-values-in-a-mysql-database
            function get_enum_values( $table, $field )
            {
                $type = $this->db->query( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->row( 0 )->Type;
                preg_match('/^enum\((.*)\)$/', $type, $matches);
                foreach( explode(',', $matches[1]) as $value )
                {
                     $enum[] = trim( $value, "'" );
                }
                return $enum;
            }
        ?>
        
        <form action="employeeRegistration.php" method="POST">
            Username: <input type="text" name="username"/><br/>
            <?php if(!($usernameIsValid)){echo ("Username must be longer than 3 characters and less than 45.<br/>");} ?>
            <?php if(!($usernameIsDuplicate)){echo ("Username already in use.<br/>");} ?>
            Password: <input type="password" name="password1"/><br/>
            <?php if(!($passwordIsValid)){echo ("Password must be at least 8 characters long.<br/>");} ?>
            Password Confirmation: <input type="password" name="password2"/><br/>
            <?php if(!($passwordsMatch)){echo ("Passwords do not match.<br/>");} ?>
            Name: <input type="text" name="name"/><br/>
            <?php if(!($nameIsValid)){echo ("Name must be longer than 3 characters and less than 45.<br/>");} ?>
            Address: <input type="text" name="address"/><br/>
            <?php if(!$addressIsValid){echo ("Adress must be longer than 3 characters and less than 45.<br/>");} ?>
            Store:  <select name="store">
                    <?php foreach($array as $option) : ?>
                        <option value="<?php echo $option['Name']; ?>"><?php echo $option['Name']; ?></option>
                    <?php endforeach; ?>
                    </select>
                    <br/>
            Department: <select name="department">
                        <?php foreach($array as $option) : ?>
                            <option value="<?php echo $option['Name']; ?>"><?php echo $option['Name']; ?></option>
                        <?php endforeach; ?>
                        </select>
            
            
            <?php mysqli_close($con); ?>
        </form>
    </body>
</html>
