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
         if($_SESSION["type"] == "employee" || $_SESSION["type"] == "manager"){
            $usernameIsValid = true;
            $usernameIsDuplicate = true;
            $passwordIsValid = true;
            $passwordsMatch = true;
            $nameIsValid = true;
            $addressIsValid = true;
            $phoneIsValid = true;
            
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
            
            $sql = 'select * from employee where username = "' . $_SESSION["username"] . '"';
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($result);
            
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
                
                if($usernameIsValid && $passwordIsValid && $passwordsMatch && $nameIsValid && $addressIsValid && $phoneIsValid){
                    
                   $sql = 'update employee set username="' . $_POST['username'] . '", password="' . $_POST['password1'] . '", name = "' . $_POST['name'] . '", address="' . $_POST["address"] .'", store_id = ' . $_POST['store'] . ', phone_number=' . $_POST['phone'] .',  department="' . $_POST['department'] . '" where id = ' . $row['id'];

                   if(!mysqli_query($con, $sql)){
                       echo 'Error: ' . mysqli_error($con);
                       exit;
                   } 

                   echo "User account registered!";
                
                }
                
                $sql = 'select * from employee where username = "' . $_SESSION["username"] . '"';
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($result);
                mysqli_close($con);
            }
            
            echo '<form action="employeeAccountManagement.php" method="POST">';
            echo 'Username: <input type="text" name="username" value="' . $row["username"] . '"/><br/>';
            if(!($usernameIsValid)){echo ("Username must be longer than 3 characters and less than 45.<br/>");}
            if(!($usernameIsDuplicate)){echo ("Username already in use.<br/>");}
            echo 'Password: <input type="password" name="password1" value="' . $row["password"] . '"/><br/>';
            if(!($passwordIsValid)){echo ("Password must be at least 8 characters long.<br/>");}
            echo 'Password Confirmation: <input type="password" name="password2" value="' . $row["password"] . '"/><br/>';
            if(!($passwordsMatch)){echo ("Passwords do not match.<br/>");}
            echo 'Name: <input type="text" name="name" value="' . $row["name"] . '"/><br/>';
            if(!($nameIsValid)){echo ("Name must be longer than 3 characters and less than 45.<br/>");}
            echo 'Address: <input type="text" name="address" value="' . $row["address"] . '"/><br/>';
            if(!$addressIsValid){echo ("Adress must be longer than 3 characters and less than 45.<br/>");}
            echo 'Phone Number: <input type="text" name="phone" value="' . $row["phone_number"] . '"/><br/>';
            if(!$phoneIsValid){echo ("Phone number must be 10 numbers long.<br/>");}
            $storeArray = get_store_ids();
            echo 'Store:  <select name="store">';
                    foreach($storeArray as $option):
                        if($row["store"] == $option){
                            echo '<option selected="selected" value="' . $option . '">' . $option . '</option>';
                        } else{
                            echo '<option value="' . $option . '">' . $option . '</option>';
                        }
                        
                    endforeach;
                    echo '</select> <br/>';
            $departmentArray = get_enum_values( "employee", "department");
            echo 'Department: <select name="department">';
                        foreach($departmentArray as $option):
                            if($row["department"] == $option){
                                echo '<option selected="selected" value="' . $option . '">' . $option . '</option>';
                            } 
                            else {
                                echo '<option value="' . $option . '">' . $option . '</option>';
                            }
                            
                        endforeach;
                        echo '</select> <br/>';
            echo '<input type="submit" value="Update Account"/>';
            echo '</form>';

        }
         else{
             echo "You are not an employee! You cannot manage your account here.";
         }
        
    } else{
        echo "You are not logged in. Please login before managing your account.";
    }

    
    
    
    
    
        
        
    // Footer
    echo '
            </div>';
    include_once('footer.php');
    echo '
    </body>
    </html>';
?>