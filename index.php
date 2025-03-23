<?php
include 'connection.php';

$result = $conn->query("SELECT * FROM employee");
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel="icon" type="image/png" href="https://img.icons8.com/nolan/64/employee-card.png">
    <title>Employee Management System</title>
</head>
<body style='margin: 0; padding: 20px; min-height: 100vh; font-family: Arial, sans-serif; color: #ffffff; text-align: center; background: #0f0f0f;'>
    <img src="J4o.gif" alt="Background Animation" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.15; filter: blur(2px); z-index: -1;">

    <h1 style='color: #00ff88; margin-bottom: 10px; font-size: 2.5em; font-weight: 700; letter-spacing: 2px;'>EMPLOYEE MANAGEMENT SYSTEM</h1><br>
    <h2 style='color: #00ff88; margin-bottom: 10px; font-size: 2.5em; font-weight: 700; letter-spacing: 2px;'>Employee List</h2><br>

    <a href="add_employee.php"
        onclick="return confirm('Are you sure you want to add a new employee?');" 
        style="padding: 16px 30px; background: #00ff88; color: #000; text-decoration: none; border: none; border-radius: 50px; cursor: pointer; font-weight: 600; font-size: 0.95em; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 2px; box-shadow: 0 4px 15px rgba(0,255,136,0.2); display: inline-flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 20px;"
        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(0,255,136,0.4)'"
        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,255,136,0.2)'">
        + ADD EMPLOYEE
    </a>

    <table style='width: 100%; max-width: 1200px; margin: 0 auto; border-collapse: separate; border-spacing: 0; text-align: left; background: rgba(255,255,255,0.03); border-radius: 20px; backdrop-filter: blur(10px); border: 1px solid rgba(0,255,136,0.1); box-shadow: 0 8px 32px rgba(0,255,136,0.1); padding: 30px;'>
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
            while ($row = $result->fetch_assoc()) { ?>
                <tr style='transition: all 0.3s ease;' onmouseover='this.style.backgroundColor="rgba(0, 255, 136, 0.05)"' onmouseout='this.style.backgroundColor="transparent"'>
                    <td style='padding: 20px; color: #fff;'><?php echo $row['id']; ?></td>
                    <td style='padding: 20px; color: #fff;'><?php echo $row['first_name']; ?></td>
                    <td style='padding: 20px; color: #fff;'><?php echo $row['last_name']; ?></td>
                    <td style='padding: 20px; color: #fff;'><?php echo $row['department']; ?></td>
                    <td style='padding: 20px; color: #fff;'>₱<?php echo number_format($row['salary'], 2, '.', ','); ?></td>
                    <td style='padding: 20px; text-align: center;'>
                        <form method='GET' action='edit_employee.php' style='display: inline; margin-right: 10px;'>
                            <input type='hidden' name='id' value='<?php echo $row['id']; ?>'>
                            <input type='hidden' name='first_name' value='<?php echo $row['first_name']; ?>'>
                            <input type='hidden' name='last_name' value='<?php echo $row['last_name']; ?>'>
                            <input type='hidden' name='department' value='<?php echo $row['department']; ?>'>
                            <input type='hidden' name='salary' value='<?php echo $row['salary']; ?>'>
                            <button type='submit' onclick='return confirm("Are you sure you want to edit this employee?");'
                                style='background-color: transparent; color: #00ff88; border: 1px solid #00ff88; border-radius: 8px; padding: 8px 20px; cursor: pointer; font-weight: 500; transition: all 0.3s ease;' 
                                onmouseover='this.style.backgroundColor="#00ff88"; this.style.color="#000"' 
                                onmouseout='this.style.backgroundColor="transparent"; this.style.color="#00ff88"'>Edit</button>
                        </form>
                        <form method='POST' action='delete_employee.php' style='display: inline;' onsubmit='return confirm("Are you sure you want to delete this employee?");'>
                            <input type='hidden' name='id' value='<?php echo $row['id']; ?>'>
                            <button type='submit' 
                                style='background-color: transparent; color: #ff4444; border: 1px solid #ff4444; border-radius: 8px; padding: 8px 20px; cursor: pointer; font-weight: 500; transition: all 0.3s ease;'
                                onmouseover='this.style.backgroundColor="#ff4444"; this.style.color="#fff"' 
                                onmouseout='this.style.backgroundColor="transparent"; this.style.color="#ff4444"'>Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
            <?php if ($result->num_rows == 0) { ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: #888;">No employees found. Please add an employee.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <p style="color: #888; margin-top: 40px; font-size: 1.1em; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">Created by Eroscodex with Mias</p>
</body>
</html>
