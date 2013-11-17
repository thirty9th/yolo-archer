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
        <form action="customerRegistration.php" method="POST">
            Name: <input type="text" name="name"/><br/>
            <?php if(!($nameIsValid)){echo ("Name must be longer than 3 characters and less than 45.<br/>");} ?>
            Address: <input type="text" name="address"/><br/>
            <?php if(!$addressIsValid){echo ("Adress must be longer than 3 characters and less than 45.<br/>");} ?>
            Credit Card Number: <input type="text" name="cc_number"/><br/>
            <?php if(!$ccNumberIsValid){echo ("Credit card number must be 16 numbers long.<br/>");} ?>
            Phone Number: <input type="text" name="phone"/><br/>
            <?php if(!$phoneIsValid){echo ("Phone number must be 10 numbers long.<br/>");} ?>
            Email: <input type="text" name="email"/><br/>
            <?php if(!$emailIsValid){echo ("Email must be longer than 3 characters and less than 45.<br/>");} ?>
            <input type="submit" value="Register"/>
        </form>
        
        <?php
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $dbHost = "68.191.214.214";
            $dbUsername = "galefisher";
            $dbPassword = "galefisher";       
            $dbTable = "galefisherautoparts";
            $dbPort = 3306;
            $con = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbTable, 3306);
            if (!$con) {
                echo "Not Connected.";
                exit('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
                }
            else{
                echo "Connected!";
            }
            
            mysqli_set_charset($con, 'utf-8');
            
            $nameIsValid = true;
            $addressIsValid = true;
            $ccNumberIsValid = true;
            $phoneNumberIsValid = true;
            $emailIsValid = true;
            
            if(strlen($_POST['name']) < 3 || strlen($_POST['name']) > 45){
                $nameIsValid = false;
            }
            if(strlen($_POST['address']) < 3 || strlen($_POST['address']) > 45){
                $addressIsValid = false;
            }
            if(strlen($_POST['cc_number']) != 16){
                $ccNumberIsValid = false;
            }
            if(strlen($_POST['phone']) != 10){
                $phoneIsValid = false;
            }
            if(strlen($_POST['email']) < 3 || strlen($_POST['email']) > 45){
                $emailIsValid = false;
            }
            
            $sql="INSERT INTO customer (name, address, cc_number, phone_number, email_address)VALUES"
                . "('$_POST[name]','$_POST[address]','$_POST[cc_number]','$_POST[phone]','$_POST[email]')";
            
            if(!$nameIsValid && !$addressIsValid && !$ccNumberIsValid && !$phoneIsValid && !$emailIsValid){
                if(!mysqli_query($con, $sql)){
                    echo 'Error: ' . mysqli_error($con);
                }
            }
            mysqli_close($con);
        }
        
        
        
        
        ?>
        
    </body>
</html>
