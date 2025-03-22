<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);

    $delete_sql = "DELETE FROM employee WHERE id = $id";
    $delete = $conn->query($delete_sql);

    if ($delete) {
    
        $reset_sql1 = "SET @count = 0;";
        $reset_sql2 = "UPDATE employee SET id = (@count := @count + 1) ORDER BY id ASC;"; 
        $reset_sql3 = "ALTER TABLE employee AUTO_INCREMENT = 1;";

        $conn->query($reset_sql1);
        $conn->query($reset_sql2);
        $conn->query($reset_sql3);

        echo "<script>alert('Employee Deleted!'); location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error Deleting Employee!');</script>";
    }
}
?>
