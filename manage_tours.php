<?php
require("db_conn.php");
// Initialize message variable
$message = "";

// Function to fetch data and display in a table
function displayTable($conn, $query, $tableTitle) {
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        echo "<h2>$tableTitle</h2>";
        echo "<table border='1' cellspacing='0' cellpadding='10'>";
        echo "<thead><tr>";
        
        // Fetch field names
        while ($field = $result->fetch_field()) {
            echo "<th>" . ucfirst($field->name) . "</th>";
        }
        echo "</tr></thead><tbody>";
        
        // Fetch rows
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
            }
            echo "</tr>";
        }
        echo "</tbody></table><br>";
    } else {
        echo "<h2>$tableTitle</h2><p>No records found.</p>";
    }
}

// Create a new tour
if (isset($_POST['create'])) {
    $tour_name = $_POST['tour_name'];
    $tourguide_id = $_POST['tourguide_id'];
    $tourdriver_id = $_POST['tourdriver_id'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO tours (tour_name, tourguide_id, tourdriver_id) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $tour_name, $tourguide_id, $tourdriver_id);

    if ($stmt->execute() === TRUE) {
        $message = "New tour created successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Delete a tour
if (isset($_POST['delete'])) {
    $tour_id = $_POST['tour_id'];
    
    // Prepare and bind
    $stmt = $conn->prepare("DELETE FROM tours WHERE id = ?");
    $stmt->bind_param("i", $tour_id);
    
    if ($stmt->execute() === TRUE) {
        $message = "Tour deleted successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Update a tour's name and tour guide
if (isset($_POST['update'])) {
    $tour_id = $_POST['tour_id'];
    $tour_name = $_POST['tour_name'];
    $tourguide_id = $_POST['tourguide_id'];
    $tourdriver_id = $_POST['tourdriver_id'];

    // Prepare and bind
    $stmt = $conn->prepare("UPDATE tours SET tour_name = ?, tourguide_id = ?, tourdriver_id = ?  WHERE id = ?");
    $stmt->bind_param("siii", $tour_name, $tourguide_id, $tour_id, $tourdriver_id);


    if ($stmt->execute() === TRUE) {
        $message = "Tour updated successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Change the price of a destination
if (isset($_POST['change_price'])) {
    $destination_id = $_POST['destination_id'];
    $new_price_adult = $_POST['new_price_adult'];
    $new_price_child = $_POST['new_price_child'];

    // Prepare and bind
    $stmt = $conn->prepare("UPDATE destinations SET price_adult = ?, price_child = ? WHERE id = ?");
    $stmt->bind_param("ddi", $new_price_adult, $new_price_child, $destination_id);
    
    if ($stmt->execute() === TRUE) {
        $message = "Prices updated successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tours</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        h2 {
            color: #00a88f; /* Greenish Blue */
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            flex-grow: 1;
        }
        form {
            margin-bottom: 30px;
        }
        input[type="text"],
        input[type="number"],
        input[type="submit"] {
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
        }
        input[type="submit"] {
            background-color: #00a88f; /* Greenish Blue */
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #3498db;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: inline-block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: fixed;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #00a88f; /* Greenish Blue */
            color: white;
        }
        td {
            background-color: #f9f9f9;
        }

        /* Header */
        header {
            background-color: #ffffff; /* White */
            color: #00a88f; /* Greenish Blue */
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            width: 100%;
            z-index: 100;
        }
        /* Logo */
        .logo {
            max-width: 150px;
            height: auto;
        }
        header img {
            max-width: 100px; /* Adjust size as needed */
            height: auto;
        }
        header h1 {
            margin: 0;
            font-size: 36px;
        }
        .message {
            color: #00a88f; /* Message color */
            margin-bottom: 20px;
        }

        .back-button { margin-top: 10px; background-color: #ddd; color: #333; }
        .back-button:hover { background-color: #bbb; }
    </style>
</head>
<body>

<header>
    <img src="images/g2.jpg" alt="Explore Mauritius Logo" class="logo" />
    <h1>Manage Tours</h1>
</header>

<div class="container">
    <!-- Display the tables here -->
    <?php
    // Re-establish connection to the database for fetching table data after the header
    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    // Display the tables
    displayTable($conn, "SELECT * FROM tours", "Tours");
    displayTable($conn, "SELECT * FROM destinations", "Destinations");
    displayTable($conn, "SELECT * FROM tourguides", "Tour Guides");
    displayTable($conn, "SELECT * FROM tourdrivers", "Tour Drivers");
    displayTable($conn, "SELECT * FROM tour_destination", "Tour Destination");
    ?>


    <h2>Create a New Tour</h2>
    <form method="post">
        <div class="form-group">
            <label for="tour_name">Tour Name:</label>
            <input type="text" name="tour_name" required>
        </div>
        <div class="form-group">
            <label for="tourguide_id">Tour Guide ID:</label>
            <input type="number" name="tourguide_id" required>
        </div>
        <div class="form-group">
            <label for="tourguide_id">Tour Driver ID:</label>
            <input type="number" name="tourdriver_id" required>
        </div>
        <input type="submit" name="create" value="Create Tour">
    </form>

    <h2>Delete a Tour</h2>
    <form method="post">
        <div class="form-group">
            <label for="tour_id">Tour ID:</label>
            <input type="number" name="tour_id" required>
        </div>
        <input type="submit" name="delete" value="Delete Tour">
    </form>

    <h2>Update a Tour</h2>
    <form method="post">
        <div class="form-group">
            <label for="tour_id">Tour ID:</label>
            <input type="number" name="tour_id" required>
        </div>
        <div class="form-group">
            <label for="tour_name">New Tour Name:</label>
            <input type="text" name="tour_name" required>
        </div>
        <div class="form-group">
            <label for="tourguide_id">New Tour Guide ID:</label>
            <input type="number" name="tourguide_id" required>
        </div>
        <div class="form-group">
            <label for="tourdriver_id">New Tour Driver ID:</label>
            <input type="number" name="tourdriver_id" required>
        </div>
        <input type="submit" name="update" value="Update Tour">
    </form>

    <h2>Change Destination Prices</h2>
    <form method="post">
        <div class="form-group">
            <label for="destination_id">Destination ID:</label>
            <input type="number" name="destination_id" required>
        </div>
        <div class="form-group">
            <label for="new_price_adult">New Adult Price:</label>
            <input type="number" name="new_price_adult" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="new_price_child">New Child Price:</label>
            <input type="number" name="new_price_child" step="0.01" required>
        </div>
        <input type="submit" name="change_price" value="Update Prices">
    </form>
    <button class="back-button" onclick="history.back(); return false;">Back To Booking</button>
</div>

</body>
</html>