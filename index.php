<?php
include 'connection.php';

if (!isset($conn) || !$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM employee";
$result = $conn->query($sql);

if (!$result) {
    die("Error fetching employees: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>-
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>Employee Management</title>
    <script>
        function showAlert(message) {
            alert(message);
        }
    </script>
</head>
<body style="background: url('J4o.gif') center center / cover no-repeat, black; width: 100%; height: 100vh; font-family: Arial, sans-serif; color: #ffffff; text-align: center;">

    <h1 style="color: #ffffff;">Employee List</h1>

    <table style="width: 97%; margin: 20px auto; border-collapse: collapse; background-color: rgba(0, 0, 0, 0.51); border-radius: 10px; box-shadow: 2px 5px 50px lime; text-align: center;">
        <tr>
            <th style="padding: 12px 15px; border: 2px solid lime; background-color: rgb(0, 0, 0);">ID</th>
            <th style="padding: 12px 15px; border: 2px solid lime; background-color: rgb(0, 0, 0);">First Name</th>
            <th style="padding: 12px 15px; border: 2px solid lime; background-color: rgb(0, 0, 0);">Last Name</th>
            <th style="padding: 12px 15px; border: 2px solid lime; background-color: rgb(0, 0, 0);">Department</th>
            <th style="padding: 12px 15px; border: 2px solid lime; background-color: rgb(0, 0, 0);">Salary</th>
            <th style="padding: 12px 15px; border: 2px solid lime; background-color: rgb(0, 0, 0);">Actions</th>
        </tr>

        <?php
        while ($employee = $result->fetch_assoc()) {
            $bgColor = $employee['id'] % 2 == 0 ? "rgba(0, 0, 0, 0.5)" : "rgba(0, 0, 0, 0.16)";
            echo "<tr style='background-color: $bgColor;'>";
            echo "<td style='padding: 12px 15px; border: 2px solid lime;'>" . htmlspecialchars($employee['id']) . "</td>";
            echo "<td style='padding: 12px 15px; border: 2px solid lime;'>" . htmlspecialchars($employee['first_name']) . "</td>";
            echo "<td style='padding: 12px 15px; border: 2px solid lime;'>" . htmlspecialchars($employee['last_name']) . "</td>";
            echo "<td style='padding: 12px 15px; border: 2px solid lime;'>" . htmlspecialchars($employee['department']) . "</td>";
            echo "<td style='padding: 12px 15px; border: 2px solid lime;'>" . htmlspecialchars($employee['salary']) . "</td>";
            echo "<td style='padding: 12px 15px; border: 2px solid lime;'>
                    <a href='edit_employee.php?id=" . htmlspecialchars($employee['id']) . "' onclick='showAlert(\"Editing Employee\");'
                        style='background-color:rgb(0, 76, 255); color: #ffffff; text-decoration: none; padding: 5px 10px; border: 1px solid lime; border-radius: 5px; margin-right: 10px;'>Edit</a>
                    <a href='delete_employee.php?id=" . htmlspecialchars($employee['id']) . "' onclick='showAlert(\"Deleting Employee\");'
                        style='background-color:rgb(255, 0, 0); color: #ffffff; text-decoration: none; padding: 5px 10px; border: 1px solid lime; border-radius: 5px;'>Delete</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>
    <br><br>
    <a href="add_employee.php" onclick="showAlert('Redirecting to add employee page');" 
                style="background-color: rgb(0, 76, 255); color: white; text-decoration: none; padding: 5px 10px; border: 1px solid lime; border-radius: 5px; display: inline-block;">
                Add Employee</a>
</body>
</html>
