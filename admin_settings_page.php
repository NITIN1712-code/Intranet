<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <style>
        /* General Page Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column; /* Stack header and content */
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

        header img {
            max-width: 100px;
            height: auto;
        }

        header h1 {
            font-size: 24px;
            margin-top: 10px;
            color: #00a88f;
        }

        /* Main Content Section */
        section {
            flex: 1; /* Fill remaining space */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 600px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #00a88f;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            color: #333;
            margin: 10px 0 5px;
        }

        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        input[type="submit"] {
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

        input[type="submit"]:hover {
            background-color: #008f76;
        }

        .note {
            font-size: 14px;
            color: #e74c3c;
            margin-bottom: 10px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            input[type="text"],
            input[type="file"],
            input[type="submit"] {
                font-size: 14px;
            }
        }
        .back-button { margin-top: 10px; background-color: #ddd; color: #333; }
        .back-button:hover { background-color: #bbb; }
    </style>
</head>
<body>

<header>
    <img src="images/g2.jpg" alt="Explore Mauritius Logo" class="logo">
    <h1>Settings</h1>
</header>

<section>
    <div class="container">
        <h2>Manage Settings</h2>

        <!-- Download Path Form -->
        <form action="settings_change.php" method="POST">
            <label for="download_path">Insert Download Path:</label>
            <input type="text" id="download_path" name="download_path">
            <input type="submit" value="Edit">
        </form>

        <br>

        <!-- Payslip Logo Form -->
        <form action="settings_change.php" method="POST" enctype="multipart/form-data">
            <label for="payslip_logo">(This will delete the current logo) Insert Payslip Logo:</label>
            <input type="file" id="payslip_logo" name="payslip_logo">
            <input type="submit" value="Edit" name="psl">
        </form>

        <br>

        <!-- Main Logo Form -->
        <form action="settings_change.php" method="POST" enctype="multipart/form-data">
            <label for="main_logo">(This will delete the current logo) Insert Main Logo:</label>
            <input type="file" id="main_logo" name="main_logo">
            <input type="submit" value="Edit" name="ml">
        </form>

        <br>

        <!-- Company Name Form -->
        <form action="settings_change.php" method="POST">
            <label for="company">Company Name:</label>
            <input type="text" id="company" name="company" required>
            <input type="submit" value="Edit">
        </form>

        <br>

        <!-- Location and Address Form -->
        <form action="settings_change.php" method="POST">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>

            <br><br>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <input type="submit" value="Edit">
        </form>
        <button class="back-button" onclick="history.back(); return false;">Back To Booking</button>
    </div>
</section>

<script>
    fetch("settings.json")
        .then((response) => response.json())
        .then((json_data) => {
            document.getElementById("download_path").value = json_data["download_path"];
            document.getElementById("company").value = json_data["company"];
            document.getElementById("location").value = json_data["location"]["location"];
            document.getElementById("address").value = json_data["location"]["address"];
        });
</script>

</body>
</html>