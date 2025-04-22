<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $department = $_POST['department'];
    $salary = $_POST['salary'];

    if (empty($first_name) || strlen($first_name) < 2 || strlen($first_name) > 50) {
        echo "<script>alert('First name must be between 2 and 50 characters'); window.location='add_employee.php';</script>";
        exit();
    }

    if (empty($last_name) || strlen($last_name) < 2 || strlen($last_name) > 50) {
        echo "<script>alert('Last name must be between 2 and 50 characters'); window.location='add_employee.php';</script>";
        exit();
    }

    if (empty($department) || strlen($department) < 4 || strlen($department) > 50) {
        echo "<script>alert('Department must be between 4 and 50 characters'); window.location='add_employee.php';</script>";
        exit();
    }

    if ($salary <= 6000 || $salary < 50000 || $salary > 1000000) {
        echo "<script>alert('Salary must be between 40,000 and 1,000,000'); window.location='add_employee.php';</script>";
        exit();
    }

    $check_duplicate = $conn->query("SELECT id FROM employee WHERE UPPER(first_name) = LOWER('$first_name') AND UPPER(last_name) = LOWER('$last_name') AND department = '$department' AND salary = $salary");
    if ($check_duplicate->num_rows > 0) {
        echo "<script>alert('Duplicate employee details found'); window.location='add_employee.php';</script>";
        exit();
    }

    if (strtolower($first_name) === strtolower($last_name)) {
        echo "<script>alert('First name and last name cannot be the same'); window.location='add_employee.php';</script>";
        exit();
    }

    $insert = $conn->query("INSERT INTO employee (first_name, last_name, department, salary) VALUES ('$first_name', '$last_name', '$department', $salary)");
    
    if ($insert) {
        echo "<script>alert('Employee added successfully!'); window.location='index.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error adding employee'); window.location='add_employee.php';</script>";
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
    <title>Add Employee</title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            color: #ffffff;
            text-align: center;
            background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%);
        }
        img {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.1;
            filter: blur(3px);
            z-index: -1;
        }
        h1 {
            color: #00ff88;
            margin-bottom: 30px;
            font-size: 2.8em;
            font-weight: 800;
            letter-spacing: 2px;
            text-shadow: 0 0 20px rgba(0,255,136,0.3);
        }
        table {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.05);
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0,255,136,0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(0,255,136,0.1);
        }
        label {
            font-weight: 600;
            display: block;
            margin-bottom: 12px;
            color: #00ff88;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 16px;
            border: 2px solid rgba(0, 255, 136, 0.2);
            border-radius: 16px;
            background: rgba(0, 255, 136, 0.03);
            color: white;
            outline: none;
            transition: all 0.3s ease;
            font-size: 1.1em;
            box-sizing: border-box;
            margin-bottom: 25px;
            box-shadow: inset 0 0 10px rgba(0,255,136,0.05);
        }
        input[type="text"]:hover, input[type="number"]:hover {
            border-color: rgba(0, 255, 136, 0.5);
            box-shadow: inset 0 0 15px rgba(0,255,136,0.1);
        }
        button {
            flex: 1;
            padding: 16px 30px;
            background: #00ff88;
            color: #000;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.95em;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .cancel-button {
            flex: 1;
            padding: 16px 30px;
            background: transparent;
            color: #fff;
            text-decoration: none;
            border: 1.5px solid rgba(255,255,255,0.2);
            border-radius: 50px;
            text-align: center;
            font-weight: 600;
            font-size: 0.95em;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
    </style>
</head>
<body>
    <img src="blue.gif" alt="Background Animation">
    <h1>ADD NEW EMPLOYEE</h1>
    <form id="AddEmployee" method="POST">
        <table>
            <tr>
                <td>
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" required minlength="2" maxlength="50" placeholder="Enter a first name">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" required minlength="2" maxlength="50" placeholder="Enter a last name">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="department">Department</label>
                    <input type="text" id="department" name="department" required minlength="4" maxlength="50" placeholder="Enter a department">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="salary">Salary</label>
                    <input type="number" step="0.01" id="salary" name="salary" required min="50000" max="1000000" placeholder="Enter amount (e.g. ₱100,000.00)">
                </td>
            </tr>
            <tr>
                <td>
                    <div style="display: flex; justify-content: space-between; gap: 20px;">
                        <button type="submit" onclick="return confirm('Are you sure you want to add this new employee?');">+ ADD EMPLOYEE</button>
                        <a href="index.php" class="cancel-button">CANCEL</a>
                    </div>
                </td>
            </tr>
        </table>
    </form>
    <p style="color: #888; margin-top: 40px; font-size: 1.1em; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">Created by Eroscodex</p>
</body>
</html>
