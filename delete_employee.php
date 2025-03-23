<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);

    $delete_sql = "DELETE FROM employee WHERE id = $id";
    $delete = $conn->query($delete_sql);

    if ($delete) {
 
        $conn->query("SET @count = 0;");
        $conn->query("UPDATE employee SET id = (@count := @count + 1) ORDER BY id ASC;");

       
        $conn->query("ALTER TABLE employee AUTO_INCREMENT = 1;");

        echo "<script>alert('Employee Deleted!'); location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error Deleting Employee!');</script>";
    }
}
?>
