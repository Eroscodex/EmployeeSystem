<?php
session_start();
include 'connection.php';

$sql = "SELECT * FROM employee";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel="icon" type="image/png" href="https://img.icons8.com/nolan/64/employee-card.png">
    <title>Employee Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body style='margin: 0; padding: 20px; min-height: 100vh; font-family: "Poppins", sans-serif; color: #ffffff; text-align: center; background: #0f0f0f;'>
    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; overflow: hidden;">
        <img src="J4o.gif" alt="Background Animation" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.15; filter: blur(2px);">
    </div>

    <div style="position: relative; z-index: 1;">
        <h1 style='color: #00ff88; margin-bottom: 10px; font-size: 2.5em; font-weight: 700; letter-spacing: 2px;'>EMPLOYEE MANAGEMENT SYSTEM</h1>

        <div style='max-width: 1200px; margin: 0 auto; padding: 30px; background: rgba(255,255,255,0.03); border-radius: 20px; backdrop-filter: blur(10px); border: 1px solid rgba(0,255,136,0.1); box-shadow: 0 8px 32px rgba(0,255,136,0.1);'>
            <table style='width: 100%; border-collapse: separate; border-spacing: 0; text-align: left;'>
                <thead>
                    <tr>
                        <th style='padding: 20px; color: #00ff88; font-size: 0.9em; font-weight: 600; border-bottom: 1px solid rgba(0,255,136,0.2); text-transform: uppercase; letter-spacing: 1px;'>ID</th>
                        <th style='padding: 20px; color: #00ff88; font-size: 0.9em; font-weight: 600; border-bottom: 1px solid rgba(0,255,136,0.2); text-transform: uppercase; letter-spacing: 1px;'>First Name</th>
                        <th style='padding: 20px; color: #00ff88; font-size: 0.9em; font-weight: 600; border-bottom: 1px solid rgba(0,255,136,0.2); text-transform: uppercase; letter-spacing: 1px;'>Last Name</th>
                        <th style='padding: 20px; color: #00ff88; font-size: 0.9em; font-weight: 600; border-bottom: 1px solid rgba(0,255,136,0.2); text-transform: uppercase; letter-spacing: 1px;'>Department</th>
                        <th style='padding: 20px; color: #00ff88; font-size: 0.9em; font-weight: 600; border-bottom: 1px solid rgba(0,255,136,0.2); text-transform: uppercase; letter-spacing: 1px;'>Salary</th>
                        <th style='padding: 20px; color: #00ff88; font-size: 0.9em; font-weight: 600; border-bottom: 1px solid rgba(0,255,136,0.2); text-transform: uppercase; letter-spacing: 1px; text-align: center;'>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($result->num_rows > 0) {
                        while ($employee = $result->fetch_assoc()) {
                    ?>
                            <tr style='transition: all 0.3s ease;' onmouseover='this.style.backgroundColor="rgba(0, 255, 136, 0.05)"' onmouseout='this.style.backgroundColor="transparent"'>
                                <td style='padding: 20px; color: #fff;'><?php echo $employee['id']; ?></td>
                                <td style='padding: 20px; color: #fff;'><?php echo $employee['first_name']; ?></td>
                                <td style='padding: 20px; color: #fff;'><?php echo $employee['last_name']; ?></td>
                                <td style='padding: 20px; color: #fff;'><?php echo $employee['department']; ?></td>
                                <td style='padding: 20px; color: #fff;'><?php echo $employee['salary']; ?></td>
                                <td style='padding: 20px; text-align: center;'>
                                    <form method='GET' action='edit_employee.php' style='display: inline; margin-right: 10px;'>
                                        <input type='hidden' name='id' value='<?php echo $employee['id']; ?>'>
                                        <input type='hidden' name='first_name' value='<?php echo $employee['first_name']; ?>'>
                                        <input type='hidden' name='last_name' value='<?php echo $employee['last_name']; ?>'>
                                        <input type='hidden' name='department' value='<?php echo $employee['department']; ?>'>
                                        <input type='hidden' name='salary' value='<?php echo $employee['salary']; ?>'>
                                        <button type='submit' onclick='return confirm("Are you sure you want to edit this employee?");'
                                            style='background-color: transparent; color: #00ff88; border: 1px solid #00ff88; border-radius: 8px; padding: 8px 20px; cursor: pointer; font-weight: 500; transition: all 0.3s ease;' 
                                            onmouseover='this.style.backgroundColor="#00ff88"; this.style.color="#000"' 
                                            onmouseout='this.style.backgroundColor="transparent"; this.style.color="#00ff88"'>Edit</button>
                                    </form>
                                    <form method='POST' action='delete_employee.php' style='display: inline;' onsubmit='return confirm("Are you sure you want to delete this employee?");'>
                                        <input type='hidden' name='id' value='<?php echo $employee['id']; ?>'>
                                        <button type='submit' 
                                            style='background-color: transparent; color: #ff4444; border: 1px solid #ff4444; border-radius: 8px; padding: 8px 20px; cursor: pointer; font-weight: 500; transition: all 0.3s ease;'
                                            onmouseover='this.style.backgroundColor="#ff4444"; this.style.color="#fff"' 
                                            onmouseout='this.style.backgroundColor="transparent"; this.style.color="#ff4444"'>Delete</button>
                                    </form>
                                </td>
                            </tr>
                    <?php 
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <a href='add_employee.php' onclick='return confirm("Are you sure you want to add a new employee?");' 
            style='background: #00ff88; color: #000; text-decoration: none; padding: 15px 40px; border: none; border-radius: 30px; display: inline-block; margin-top: 40px; font-weight: 600; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 1px;'
            onmouseover='this.style.transform="translateY(-2px)"; this.style.boxShadow="0 6px 20px rgba(0,255,136,0.4)"' 
            onmouseout='this.style.transform="translateY(0)"; this.style.boxShadow="none"'>
            + Add New Employee
        </a>
    </div>
    <p style="color: #888; margin-bottom: 40px; font-size: 1.1em;">Created by Eroscodex with Mias</p>
</body>
</html>
