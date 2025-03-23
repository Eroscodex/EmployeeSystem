<?php
include 'connection.php';

$employee = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $employee = [
        'id' => $_POST['id'],
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'department' => $_POST['department'],
        'salary' => $_POST['salary']
    ];
} else {
    echo "<script>alert('Invalid access!'); window.location='index.php';</script>";
    exit();
}

if (isset($_POST['update'])) {  
    $id = $_POST['id'];
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
    
    $check_duplicate = $conn->query("SELECT id FROM employee WHERE first_name = '$first_name' AND last_name = '$last_name' AND department = '$department' AND salary = $salary AND id != $id");

    if ($check_duplicate->num_rows > 0) {
        echo "<script>alert('An employee with these details already exists'); window.location='edit_employee.php';</script>";
        exit();
    }

    $update = $conn->query("UPDATE employee SET first_name='$first_name', last_name='$last_name', department='$department', salary=$salary WHERE id=$id");

    if ($update) {
        echo "<script>alert('Employee updated successfully!'); window.location='index.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error updating employee'); window.location='edit_employee.php';</script>";
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
        form {
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
        input[type="text"]:focus, input[type="number"]:focus {
            border-color: rgba(0, 255, 136, 0.5);
            box-shadow: inset 0 0 15px rgba(0,255,136,0.1);
        }
        button {
            flex: 1;
            padding: 16px 30px;
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
        .save-button {
            background: #00ff88;
            color: #000;
            box-shadow: 0 4px 15px rgba(0,255,136,0.2);
        }
        .save-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,255,136,0.3);
        }
        .cancel-button {
            background: #ff0066;
            color: #fff;
            box-shadow: 0 4px 15px rgba(255,0,102,0.2);
        }
        .cancel-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255,0,102,0.3);
        }
    </style>
</head>
<body>
    <img src="matrix.gif" alt="Background Animation">
    <h1>EDIT EMPLOYEE</h1>
    <form id="EditEmployee" method="POST">
        <input type="hidden" name="id" value="<?php echo $employee['id']; ?>">
        <input type="hidden" name="update" value="1">

        <label for="first_name">First Name</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo $employee['first_name']; ?>" required minlength="2" maxlength="50" placeholder="Enter a first name">

        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo $employee['last_name']; ?>" required minlength="2" maxlength="50" placeholder="Enter a last name">

        <label for="department">Department</label>
        <input type="text" id="department" name="department" value="<?php echo $employee['department']; ?>" required minlength="4" maxlength="50" placeholder="Enter a department">

        <label for="salary">Salary</label>
        <input type="number" id="salary" name="salary" value="<?php echo $employee['salary']; ?>" required min="50000" max="1000000 placeholder="Enter amount (e.g. ₱100,000.00)">

        <div style="display: flex; justify-content: space-between; gap: 20px;">
            <button type="submit" name="update" class="save-button" onclick="return confirm('Are you sure you want to update this employee?');">
                <i class="fa fa-save"></i> Save Changes
            </button>
            <button type="button" onclick="window.location='index.php';" class="cancel-button">
                <i class="fa fa-times"></i> Cancel
            </button>
        </div>
    </form>
</body>
</html>
