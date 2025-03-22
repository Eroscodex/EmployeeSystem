<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['id']) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM employee WHERE id = $id");
    $employee = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $department = $_POST['department'];
    $salary = $_POST['salary'];

    if ($first_name == "") {
        echo "<script>alert('First name is required'); window.location='edit_employee.php?id=$id';</script>";
        exit();
    }
    if ($last_name == "") {
        echo "<script>alert('Last name is required'); window.location='edit_employee.php?id=$id';</script>";
        exit();
    }
    if ($department == "BS") {
        echo "<script>alert('Department is required BS'); window.location='edit_employee.php?id=$id';</script>";
        exit();
    }
    if ($salary <= 0 || $salary > 1000000) {
        echo "<script>alert('Salary must be between 1 and 1,000,000'); window.location='edit_employee.php?id=$id';</script>";
        exit();
    }

    $current = $conn->query("SELECT * FROM employee WHERE id = $id")->fetch_assoc();
    
    if ($current['first_name'] == $first_name && 
        $current['last_name'] == $last_name &&
        $current['department'] == $department && 
        $current['salary'] == $salary) {
        echo "<script>alert('No changes were made'); window.location='edit_employee.php?id=$id';</script>";
        exit();
    }

    $check_duplicate = $conn->query("SELECT id FROM employee WHERE first_name = '$first_name' AND last_name = '$last_name' AND department = '$department' AND salary = $salary AND id != $id");
    if ($check_duplicate->num_rows > 0) {
        echo "<script>alert('An employee with these exact details already exists'); window.location='edit_employee.php?id=$id';</script>";
        exit();
    }

    $update = $conn->query("UPDATE employee SET first_name='$first_name', last_name='$last_name', department='$department', salary=$salary WHERE id=$id");
    
    if ($update) {
        echo "<script>alert('Employee updated successfully!'); window.location='index.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error updating employee'); window.location='edit_employee.php?id=$id';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="https://img.icons8.com/nolan/64/employee-card.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <title>Edit Employee</title>
</head>
<body style="margin: 0; padding: 20px; min-height: 100vh; font-family: 'Poppins', sans-serif; color: #ffffff; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #0f0f0f;">
    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; overflow: hidden;">
        <img src="matrix.gif" alt="Matrix Animation" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.15; filter: blur(2px);">
    </div>

    <div style="position: relative; z-index: 1; width: 100%; max-width: 500px; text-align: center;">
        <h1 style="color: #00ff88; margin-bottom: 10px; font-size: 2.5em; font-weight: 700; letter-spacing: 2px;">EDIT EMPLOYEE</h1>

        <form id="editForm" method="POST" style="background: rgba(255, 255, 255, 0.03); padding: 40px; border-radius: 20px; box-shadow: 0 8px 32px rgba(0, 255, 136, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(0,255,136,0.1);">
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">

            <div style="margin-bottom: 25px; text-align: left;">
                <label for="first_name" style="font-weight: 500; display: block; margin-bottom: 10px; color: #00ff88; font-size: 0.9em; text-transform: uppercase; letter-spacing: 1px;">First Name</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo $employee['first_name']; ?>" required maxlength="50"
                    style="width: 100%; padding: 15px; border: 1px solid rgba(0, 255, 136, 0.2); border-radius: 12px; background: rgba(0, 255, 136, 0.05); color: white; outline: none; transition: all 0.3s ease; font-size: 1em; box-sizing: border-box;"
                    onmouseover="this.style.borderColor='rgba(0, 255, 136, 0.5)'"
                    onmouseout="this.style.borderColor='rgba(0, 255, 136, 0.2)'">
            </div>

            <div style="margin-bottom: 25px; text-align: left;">
                <label for="last_name" style="font-weight: 500; display: block; margin-bottom: 10px; color: #00ff88; font-size: 0.9em; text-transform: uppercase; letter-spacing: 1px;">Last Name</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo $employee['last_name']; ?>" required maxlength="50"
                    style="width: 100%; padding: 15px; border: 1px solid rgba(0, 255, 136, 0.2); border-radius: 12px; background: rgba(0, 255, 136, 0.05); color: white; outline: none; transition: all 0.3s ease; font-size: 1em; box-sizing: border-box;"
                    onmouseover="this.style.borderColor='rgba(0, 255, 136, 0.5)'"
                    onmouseout="this.style.borderColor='rgba(0, 255, 136, 0.2)'">
            </div>

            <div style="margin-bottom: 25px; text-align: left;">
                <label for="department" style="font-weight: 500; display: block; margin-bottom: 10px; color: #00ff88; font-size: 0.9em; text-transform: uppercase; letter-spacing: 1px;">Department</label>
                <input type="text" id="department" name="department" value="<?php echo $employee['department']; ?>" required maxlength="50"
                    style="width: 100%; padding: 15px; border: 1px solid rgba(0, 255, 136, 0.2); border-radius: 12px; background: rgba(0, 255, 136, 0.05); color: white; outline: none; transition: all 0.3s ease; font-size: 1em; box-sizing: border-box;"
                    onmouseover="this.style.borderColor='rgba(0, 255, 136, 0.5)'"
                    onmouseout="this.style.borderColor='rgba(0, 255, 136, 0.2)'">
            </div>

            <div style="margin-bottom: 35px; text-align: left;">
                <label for="salary" style="font-weight: 500; display: block; margin-bottom: 10px; color: #00ff88; font-size: 0.9em; text-transform: uppercase; letter-spacing: 1px;">Salary</label>
                <input type="number" step="0.01" id="salary" name="salary" value="<?php echo $employee['salary']; ?>" required min="1" max="1000000"
                    style="width: 100%; padding: 15px; border: 1px solid rgba(0, 255, 136, 0.2); border-radius: 12px; background: rgba(0, 255, 136, 0.05); color: white; outline: none; transition: all 0.3s ease; font-size: 1em; box-sizing: border-box;"
                    onmouseover="this.style.borderColor='rgba(0, 255, 136, 0.5)'"
                    onmouseout="this.style.borderColor='rgba(0, 255, 136, 0.2)'">
            </div>

            <div style="display: flex; justify-content: space-between; gap: 15px;">
                <button type="submit" name="update" 
                    style="flex: 1; padding: 15px; background: #00ff88; color: #000; border: none; border-radius: 12px; cursor: pointer; font-weight: 600; font-size: 1em; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 1px;"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(0,255,136,0.4)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">Update</button>
                
                <a href="index.php" 
                    style="flex: 1; padding: 15px; background: transparent; color: #fff; text-decoration: none; border: 1px solid rgba(255,255,255,0.2); border-radius: 12px; text-align: center; font-weight: 600; font-size: 1em; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 1px;"
                    onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)'"
                    onmouseout="this.style.backgroundColor='transparent'">Cancel</a>
            </div>
        </form>
    </div>
    <p style="color: #888; margin-bottom: 40px; font-size: 1.1em;">Created by Eroscodex with Mias</p>
</body>
</html>
