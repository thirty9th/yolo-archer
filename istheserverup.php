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
        Is the database up? <br/>
        <?php
            $dbHost = "68.191.214.214";
            $dbUsername = "galefisher";
            $dbPassword = "galefisher";       
            $dbTable = "galefisherautoparts";
            $dbPort = 3306;
            $con = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbTable, 3306);
            if (!$con) {
               echo "No";
               exit('Connect Error (' . mysqli_connect_errno() . ') '
                   . mysqli_connect_error());
               }
               else{
                   echo "Yes.";
               }
        ?>
    </body>
</html>
