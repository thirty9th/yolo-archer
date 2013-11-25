<?php
    $usernameIsValid = true;
    $usernameIsDuplicate = true;
    $passwordIsValid = true;
    $passwordsMatch = true;
    $nameIsValid = true;
    $addressIsValid = true;
    $ccNumberIsValid = true;
    $phoneIsValid = true;
    $emailIsValid = true;


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
       if(strlen($_POST['cc_number']) != 16){
           $ccNumberIsValid = false;
       }
       if(strlen($_POST['phone']) != 10){
           $phoneIsValid = false;
       }
       if(strlen($_POST['email']) < 3 || strlen($_POST['email']) > 45){
           $emailIsValid = false;
       }

       //check to see if username is a duplicate
       $query = "select username from customer where username = '" .  $_POST[username] . "'";
       if(mysqli_num_rows(mysqli_query($con, $query)) > 0){
           $usernameIsDuplicate = false;
       }

       if($usernameIsValid && $passwordIsValid && $passwordsMatch && $nameIsValid && $addressIsValid && $ccNumberIsValid && $phoneIsValid && $emailIsValid){

            $sql="INSERT INTO customer (name, address, cc_number, phone_number, email_address, username, password) VALUE"
           . "('$_POST[name]','$_POST[address]','$_POST[cc_number]','$_POST[phone]','$_POST[email]','$_POST[username]','$_POST[password1]')";

           if(!mysqli_query($con, $sql)){
               echo 'Error: ' . mysqli_error($con);
               exit;
           } 

           echo "User account registered!";

       }

       mysqli_close($con);
    }

?>

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
	<div id="login-content-wrapper">';

        ?>
        
        
        
        <form action="customerRegistration.php" method="POST">
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
            Credit Card Number: <input type="text" name="cc_number"/><br/>
            <?php if(!$ccNumberIsValid){echo ("Credit card number must be 16 numbers long.<br/>");} ?>
            Phone Number: <input type="text" name="phone"/><br/>
            <?php if(!$phoneIsValid){echo ("Phone number must be 10 numbers long.<br/>");} ?>
            Email: <input type="email" name="email"/><br/>
            <?php if(!$emailIsValid){echo ("Email must be longer than 3 characters and less than 45.<br/>");} ?>
            <input type="submit" value="Register"/>
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