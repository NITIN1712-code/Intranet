<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request</title>
    <style>
        /* General Page Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        header {
            background-color: #ffffff;
            color: #00a88f;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .logo {
            max-width: 150px;
            height: auto;
        }

        header img {
            max-width: 100px;
            height: auto;
        }

        /* Main Content */
        .content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .leave-request-section {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #00a88f;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            color: #333;
            margin: 10px 0 5px;
            text-align: left;
        }

        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #00a88f;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #008f76;
        }
    </style>
</head>
<body>

<header>
    <img src="images/g2.jpg" alt="Explore Mauritius Logo" class="logo" />
    <h1>Leave Request Form</h1>
</header>

<div class="content">
    <section class="leave-request-section">
        <h2>Leave Request Form</h2>
        <form action="process_leave_requests.php" method="POST" onsubmit="return validateForm();">
            <div class="form-group">
                <label for="employee_id">Employee ID:</label>
                <input type="text" id="employee_id" name="employee_id" required>
            </div>
            <div class="form-group">
                <label for="leaveDate">Leave Date:</label>
                <input type="date" id="leaveDate" name="leaveDate" required>
            </div>
            <div class="form-group">
                <label for="leaveType">Leave Type:</label>
                <select id="leaveType" name="leaveType" required>
                    <option value="Sick Leave">Sick Leave</option>
                    <option value="Casual Leave">Casual Leave</option>
                    <option value="Annual Leave">Annual Leave</option>
                </select>
            </div>
            <button type="submit" class="submit-button">Submit Leave Request</button>
        </form>
    </section>
</div>

</body>
</html>
