<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $result = $conn->query("SELECT * FROM employee WHERE id = $id");
    $employee = $result->fetch_assoc();

    if (!$employee) {
        echo "<script>alert('Error: Employee not found.'); window.location.href='index.php';</script>";
        exit();
    }
}   elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $salary = floatval($_POST['salary']);

    
    $check_sql = "SELECT id FROM employee WHERE first_name = '$first_name' AND last_name = '$last_name' AND department = '$department' AND id != $id";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "<script>alert('Error: Employee with the same details already exists.'); window.location.href='edit_employee.php?id=$id';</script>";
        exit();
    } else {
        
        $update_sql = "UPDATE employee SET 
                        first_name='$first_name', 
                        last_name='$last_name', 
                        department='$department', 
                        salary=$salary 
                        WHERE id=$id";

        if ($conn->query($update_sql)) {
            echo "<script>alert('Employee updated successfully!'); window.location.href='index.php';</script>";
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
} else {
    echo "<script>alert('No employee ID provided.'); window.location.href='index.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>Edit Employee</title>
</head>
<body style="background: url('J4o.gif') center center / cover no-repeat; font-family: Arial, sans-serif; color: whitesmoke; display: flex; flex-direction: column; align-items: center; height: 100vh; justify-content: center;">

    <h2 style="color: white; margin-bottom: 20px;">Edit Employee</h2>

    <form method="POST" style="background: rgba(0, 0, 0, 0.51); padding: 20px; border-radius: 10px; box-shadow: 1px 4px 20px lime; max-width: 300px; width: 100%;">
        
        <input type="hidden" name="id" value="<?php echo isset($employee['id']) ? htmlspecialchars($employee['id']) : ''; ?>">

        <label for="first_name" style="font-weight: bold; display: block; margin-bottom: 5px;">First Name:</label>
        <input type="text" name="first_name" value="<?php echo isset($employee['first_name']) ? htmlspecialchars($employee['first_name']) : ''; ?>" required 
            style="width: 95%; padding: 10px; margin-bottom: 15px; border: 1px solid lime; border-radius: 5px;">

        <label for="last_name" style="font-weight: bold; display: block; margin-bottom: 5px;">Last Name:</label>
        <input type="text" name="last_name" value="<?php echo isset($employee['last_name']) ? htmlspecialchars($employee['last_name']) : ''; ?>" required 
            style="width: 95%; padding: 10px; margin-bottom: 15px; border: 1px solid lime; border-radius: 5px;">

        <label for="department" style="font-weight: bold; display: block; margin-bottom: 5px;">Department:</label>
        <input type="text" name="department" value="<?php echo isset($employee['department']) ? htmlspecialchars($employee['department']) : ''; ?>" required 
            style="width: 95%; padding: 10px; margin-bottom: 15px; border: 1px solid lime; border-radius: 5px;">

        <label for="salary" style="font-weight: bold; display: block; margin-bottom: 5px;">Salary:</label>
        <input type="number" step="0.01" name="salary" value="<?php echo isset($employee['salary']) ? htmlspecialchars($employee['salary']) : ''; ?>" required 
            style="width: 95%; padding: 10px; margin-bottom: 15px; border: 1px solid lime; border-radius: 5px;">

        <input type="submit" name="update" value="Update Employee" 
            style="padding: 10px 20px; background-color:rgb(22, 137, 1); color: whitesmoke; border: 1px solid lime; border-radius: 5px; cursor: pointer;">
    </form>

    <a href="index.php" style="background-color:rgb(0, 76, 255); color: white; text-decoration: none; padding: 5px 10px; border: 1px solid lime; border-radius: 5px; margin-top: 20px; display: inline-block;">Back to List</a>

</body>
</html>
