<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
        session_start();

        ini_set('session.use_cookies', '1');
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

?>
        <?php
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
 
        $usernameIsValid = true;
        $usernameIsDuplicate = true;
        $passwordIsValid = true;
        $passwordsMatch = true;
        $nameIsValid = true;
        $addressIsValid = true;
        $phoneIsValid = true;
                    
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
            
            
            
            
            //check to see if username is a duplicate
            $query = "select username from employee where username = '" .  $_POST[username] . "'";
            if(mysqli_num_rows(mysqli_query($con, $query)) > 0){
                $usernameIsDuplicate = false;
            }
                                    
            if($usernameIsValid && $passwordIsValid && $passwordsMatch && $nameIsValid && $addressIsValid && $phoneIsValid){
                                
                 $sql="INSERT INTO employee (name, address, phone_number, store_id, department, username, password) VALUE"
                . "('$_POST[name]','$_POST[address]','$_POST[phone]','$_POST[store]','$_POST[department]','$_POST[username]','$_POST[password1]')";
                
                if(!mysqli_query($con, $sql)){
                    echo 'Error: ' . mysqli_error($con);
                    exit;
                } 
                
                echo "User account registered!";
                
            }
            
            
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


            //Code to get enum values borrowed from http://stackoverflow.com/questions/2350052/how-can-i-get-enum-possible-values-in-a-mysql-database
            function get_enum_values( $table, $field ) {
                $dbHost = "68.191.214.214";
                $dbUsername = "galefisher";
                $dbPassword = "galefisher";       
                $dbTable = "galefisherautoparts";
                $dbPort = 3306;
                $con = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbTable, $dbPort);
                $query = "SELECT column_type FROM information_schema.`COLUMNS` WHERE table_schema = 'galefisherautoparts' AND table_name = '". $table ."' AND column_name = '". $field . "'";
                $result = mysqli_query($con, $query); 
                $row = mysqli_fetch_array($result);
                //print_r($row);
                $words = implode($row);
                $words = substr($words, 0, strlen($words)/2);
                preg_match('/^enum\((.*)\)$/', $words, $matches);
                    foreach( explode(',', $matches[1]) as $value )
                    {
                        $enum[] = trim( $value, "'" );
                    }
                mysqli_close($con);
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
            Phone Number: <input type="text" name="phone"/><br/>
            <?php if(!$phoneIsValid){echo ("Phone number must be 10 numbers long.<br/>");} ?>
            <?php $storeArray = get_store_ids(); ?>
            Store:  <select name="store">
                    <?php foreach($storeArray as $option) : ?>
                        <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                    <?php endforeach; ?>
                    </select>
                    <br/>
             <?php $departmentArray = get_enum_values( "employee", "department");?>
            Department: <select name="department">
                        <?php foreach($departmentArray as $option) : ?>
                            <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                        <?php endforeach; ?>
                        </select> <br/>
            <input type="submit" value="Register"/>
            <?php mysqli_close($con); ?>
        </form>
<?php
    // Footer
    echo '
            </div>';
            include_once('footer.php');
        echo '
        </body>
    </html>';
?>
