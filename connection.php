<?php

    $db_server = "localhosT";
    $db_user = "root";
    $db_password = "";
    $db_name = "employee_database";
    $conn = "";



    $conn = mysqli_connect(
        $db_server, 
        $db_user,  
        $db_password, 
        $db_name
    );

    if($conn){
        echo "Created by Karl Nicko L. Alondra BSIT";
    }
    else{
        echo "Connection failed";
    }
?>