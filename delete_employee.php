<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $id = intval($_POST['id']);

    
    $delete_sql = "DELETE FROM employee WHERE id = $id";
    $delete = $conn->query($delete_sql);

    if ($delete) {
        
        $reset_sql1 = "SET @count = 0;";
        $reset_sql2 = "UPDATE employee SET id = (@count := @count + 1) ORDER BY id;";
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>Delete Employee</title>
</head>
<body style="background: url('J4o.gif') center center / cover no-repeat; font-family: Arial, sans-serif; color: whitesmoke; display: flex; flex-direction: column; align-items: center; height: 100vh; justify-content: center;">

    <h2 style="color: white; margin-bottom: 20px;">Delete Employee</h2>

    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this employee?');"
        style="background: rgba(0, 0, 0, 0.51); padding: 20px; border-radius: 10px; box-shadow: 1px 4px 20px lime; max-width: 300px; width: 100%; display: flex; flex-direction: column; align-items: center;">

        <label for="id" style="font-weight: bold; display: block; margin-bottom: 5px;">Enter Employee ID:</label>
        <input type="number" name="id" required
            style="width: 95%; padding: 10px; margin-bottom: 15px; border: 1px solid lime; border-radius: 5px; text-align: center;">

        <button type="submit" name="delete" 
            style="padding: 10px 20px; background-color: red; color: whitesmoke; border: 1px solid lime; border-radius: 5px; cursor: pointer;">Delete Employee</button>
    </form>

    <a href="index.php" 
        style="background-color: rgb(0, 76, 255); color: white; text-decoration: none; padding: 5px 10px; border: 1px solid lime; border-radius: 5px; margin-top: 20px; display: inline-block;">Back to List</a>

</body>
</html>
