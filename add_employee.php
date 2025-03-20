<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $first_name = mysqli_real_escape_string($conn, trim($_POST['first_name']));
    $last_name = mysqli_real_escape_string($conn, trim($_POST['last_name']));
    $department = mysqli_real_escape_string($conn, trim($_POST['department']));
    $salary = floatval($_POST['salary']);

    if (empty($first_name) || empty($last_name) || empty($department) || empty($salary)) {
        echo "<script>alert('Error: All fields are required!'); window.history.back();</script>";
        exit();
    }

    $check_sql = "SELECT id FROM employee WHERE first_name = '$first_name' AND last_name = '$last_name' AND department = '$department'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        echo "<script>alert('Error: Employee with the same details already exists.'); window.location.href='add_employee.php';</script>";
        exit();
    } else {
        $insert_sql = "INSERT INTO employee (first_name, last_name, department, salary) VALUES ('$first_name', '$last_name', '$department', '$salary')";

        if ($conn->query($insert_sql)) {
            echo "<script>alert('Employee added successfully!'); window.location.href='index.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error: Unable to add employee.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>Add Employee</title>
</head>
<body style="background: url('J4o.gif') center center / cover no-repeat; font-family: Arial, sans-serif; color: whitesmoke; display: flex; flex-direction: column; align-items: center; height: 100vh; justify-content: center;">

    <h2 style="color: white;">Add New Employee</h2>
    
    <form method="POST" onsubmit="return confirm('Are you sure you want to add this employee?');" style="background:rgba(0, 0, 0, 0.51); padding: 20px; border-radius: 10px; box-shadow: 1px 4px 20px lime; max-width: 300px; width: 100%;">
        <label for="first_name" style="font-weight: bold;">First Name:</label>
        <input type="text" name="first_name" required style="width: 95%; padding: 10px; margin: 5px 0 15px; border: 1px solid lime; border-radius: 5px;">
        
        <label for="last_name" style="font-weight: bold;">Last Name:</label>
        <input type="text" name="last_name" required style="width: 95%; padding: 10px; margin: 5px 0 15px; border: 1px solid lime; border-radius: 5px;">
        
        <label for="department" style="font-weight: bold;">Department:</label>
        <input type="text" name="department" required style="width: 95%; padding: 10px; margin: 5px 0 15px; border: 1px solid lime; border-radius: 5px;">
        
        <label for="salary" style="font-weight: bold;">Salary:</label>
        <input type="number" step="0.01" name="salary" required style="width: 95%; padding: 10px; margin: 5px 0 15px; border: 1px solid lime; border-radius: 5px;">
        
        <input type="submit" value="Add Employee" style="padding: 10px 20px; background-color:rgba(41, 255, 3, 0.81); color: whitesmoke; border: 1px solid lime; border-radius: 5px; cursor: pointer;">
    </form>
    
    <a href="index.php" style="background-color:rgb(0, 76, 255); color: white; text-decoration: none; padding: 5px 10px; border: 1px solid lime; border-radius: 5px; margin-top: 20px; display: inline-block;">Back to List</a>

</body>
</html>
