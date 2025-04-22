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
<<<<<<< HEAD
        echo "Created by Karl Nicko L. Alondra";
=======
        echo "Created by Karl Nicko L. Alondra and Dave De Leon Mias BSIT - A";
>>>>>>> b87750865e48a9c43c8aa5cb9d4416a4b4b6d2d0
    }
    else{
        echo "Connection failed";
    }
?>