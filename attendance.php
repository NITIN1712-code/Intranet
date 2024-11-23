<?php
include 'db_conn.php';

$result = mysqli_query($conn, "SELECT id, first_name, last_name FROM employees");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html, body {
            height: 100%;
            width: 100%;
            background-color: #f9f9f9;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            width: 100%;
            height: 100%;
            max-width: none;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative; 
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            flex-grow: 1;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        button {
            padding: 5px 10px;
            margin: 2px;
            border: none;
            cursor: pointer;
        }
        .present {
            background-color: #4CAF50;
            color: white;
        }
        .absent {
            background-color: #f44336;
            color: white;
        }
        .back {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 8px 15px;
            background-color: #808080;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            width: auto; 
            min-width: 80px; 
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="javascript:history.back()" class="back">Back</a>
        <h1>Mark Attendance</h1>
        <form method="post" action="save_attendance.php">
            <label for="attendance_date">Date:</label>
            <input type="date" name="attendance_date" id="attendance_date" required>
            <table>
                <tr>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
                    <td>
                        <button type="submit" name="status[<?= $row['id'] ?>]" value="Present" class="present">Present</button>
                        <button type="submit" name="status[<?= $row['id'] ?>]" value="Absent" class="absent">Absent</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </form>
    </div>
</body>
</html>
