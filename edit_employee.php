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
    if ($salary <= 40000 || $salary > 1000000) {
        echo "<script>alert('Salary must be between 50000 and 1,000,000'); window.location='edit_employee.php?id=$id';</script>";
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
    <title>Edit Employee</title>
</head>
<body style="margin: 0; padding: 20px; min-height: 100vh; font-family: Arial, sans-serif; color: #ffffff; text-align: center; background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%);">
    <img src="matrix.gif" alt="Matrix Animation" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.1; filter: blur(3px); z-index: -1;">

    <h1 style="color: #00ff88; margin-bottom: 30px; font-size: 2.8em; font-weight: 800; letter-spacing: 2px; text-shadow: 0 0 20px rgba(0,255,136,0.3);">EDIT EMPLOYEE</h1>

    <form id="EditEmployee" method="POST" style="width: 100%; max-width: 500px; margin: 0 auto; background: rgba(255, 255, 255, 0.05); padding: 40px; border-radius: 24px; box-shadow: 0 8px 32px rgba(0,255,136,0.1); backdrop-filter: blur(20px); border: 1px solid rgba(0,255,136,0.1);">
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">

        <label for="first_name" style="font-weight: 600; display: block; margin-bottom: 12px; color: #00ff88; font-size: 0.9em; text-transform: uppercase; letter-spacing: 1.5px;">First Name</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo $_GET['first_name']; ?>" required maxlength="50"
            style="width: 100%; padding: 16px; border: 2px solid rgba(0, 255, 136, 0.2); border-radius: 16px; background: rgba(0, 255, 136, 0.03); color: white; outline: none; transition: all 0.3s ease; font-size: 1.1em; box-sizing: border-box; margin-bottom: 25px; box-shadow: inset 0 0 10px rgba(0,255,136,0.05);"
            onmouseover="this.style.borderColor='rgba(0, 255, 136, 0.5)'; this.style.boxShadow='inset 0 0 15px rgba(0,255,136,0.1)'"
            onmouseout="this.style.borderColor='rgba(0, 255, 136, 0.2)'; this.style.boxShadow='inset 0 0 10px rgba(0,255,136,0.05)'">

        <label for="last_name" style="font-weight: 600; display: block; margin-bottom: 12px; color: #00ff88; font-size: 0.9em; text-transform: uppercase; letter-spacing: 1.5px;">Last Name</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo $_GET['last_name']; ?>" required maxlength="50"
            style="width: 100%; padding: 16px; border: 2px solid rgba(0, 255, 136, 0.2); border-radius: 16px; background: rgba(0, 255, 136, 0.03); color: white; outline: none; transition: all 0.3s ease; font-size: 1.1em; box-sizing: border-box; margin-bottom: 25px; box-shadow: inset 0 0 10px rgba(0,255,136,0.05);"
            onmouseover="this.style.borderColor='rgba(0, 255, 136, 0.5)'; this.style.boxShadow='inset 0 0 15px rgba(0,255,136,0.1)'"
            onmouseout="this.style.borderColor='rgba(0, 255, 136, 0.2)'; this.style.boxShadow='inset 0 0 10px rgba(0,255,136,0.05)'">

        <label for="department" style="font-weight: 600; display: block; margin-bottom: 12px; color: #00ff88; font-size: 0.9em; text-transform: uppercase; letter-spacing: 1.5px;">Department</label>
        <input type="text" id="department" name="department" value="<?php echo $_GET['department']; ?>" required maxlength="50"
            style="width: 100%; padding: 16px; border: 2px solid rgba(0, 255, 136, 0.2); border-radius: 16px; background: rgba(0, 255, 136, 0.03); color: white; outline: none; transition: all 0.3s ease; font-size: 1.1em; box-sizing: border-box; margin-bottom: 25px; box-shadow: inset 0 0 10px rgba(0,255,136,0.05);"
            onmouseover="this.style.borderColor='rgba(0, 255, 136, 0.5)'; this.style.boxShadow='inset 0 0 15px rgba(0,255,136,0.1)'"
            onmouseout="this.style.borderColor='rgba(0, 255, 136, 0.2)'; this.style.boxShadow='inset 0 0 10px rgba(0,255,136,0.05)'">

        <label for="salary" style="font-weight: 600; display: block; margin-bottom: 12px; color: #00ff88; font-size: 0.9em; text-transform: uppercase; letter-spacing: 1.5px;">Salary</label>
        <input type="number" step="0.01" id="salary" name="salary" value="<?php echo number_format($_GET['salary'], 2, '.', ''); ?>" required min="1" max="1000000"
            style="width: 100%; padding: 16px; border: 2px solid rgba(0, 255, 136, 0.2); border-radius: 16px; background: rgba(0, 255, 136, 0.03); color: white; outline: none; transition: all 0.3s ease; font-size: 1.1em; box-sizing: border-box; margin-bottom: 35px; box-shadow: inset 0 0 10px rgba(0,255,136,0.05);"
            onmouseover="this.style.borderColor='rgba(0, 255, 136, 0.5)'; this.style.boxShadow='inset 0 0 15px rgba(0,255,136,0.1)'"
            onmouseout="this.style.borderColor='rgba(0, 255, 136, 0.2)'; this.style.boxShadow='inset 0 0 10px rgba(0,255,136,0.05)'"
            oninput="this.value = this.value.match(/^\d*\.?\d{0,2}$/)"
            placeholder="Enter amount (e.g. 100000.00)">

        <div style="display: flex; justify-content: space-between; gap: 20px;">
            <button type="submit" name="update" 
                style="flex: 1; padding: 16px 30px; background: #00ff88; color: #000; border: none; border-radius: 50px; cursor: pointer; font-weight: 600; font-size: 0.95em; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 2px; box-shadow: 0 4px 15px rgba(0,255,136,0.2); display: flex; align-items: center; justify-content: center; gap: 8px;"
                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(0,255,136,0.4)'"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,255,136,0.2)'">
                UPDATE
            </button>
            
            <a href="index.php" 
                style="flex: 1; padding: 16px 30px; background: transparent; color: #fff; text-decoration: none; border: 1.5px solid rgba(255,255,255,0.2); border-radius: 50px; text-align: center; font-weight: 600; font-size: 0.95em; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 2px; display: flex; align-items: center; justify-content: center;"
                onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(255,255,255,0.4)'"
                onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='rgba(255,255,255,0.2)'">CANCEL</a>
        </div>
    </form>
    <p style="color: #888; margin-top: 40px; font-size: 1.1em; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">Created by Eroscodex with Mias</p>
</body>
</html>
