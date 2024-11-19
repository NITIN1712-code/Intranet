<?php
// Connect to the database
require("db_conn.php");

// Check if the connection is successful
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// SQL query with LEFT JOIN to retrieve booking information, including date and driver name
$query = "
    SELECT 
        b.booking_id, 
        b.total_price, 
        b.num_adults, 
        b.num_children, 
        b.booking_date, 
        u.username AS user_name, 
        u.full_name AS user_full_name, 
        t.tourguide_name AS tourguide,
        dvr.tourdriver_name AS driver_name,
        GROUP_CONCAT(d.name SEPARATOR ', ') AS destinations
    FROM bookings b
    LEFT JOIN users u ON b.user_id = u.id
    LEFT JOIN tourguides t ON b.tourguide_id = t.tourguide_id
    LEFT JOIN tourdrivers dvr ON b.tourdriver_id = dvr.tourdriver_id
    LEFT JOIN booking_destinations bd ON b.booking_id = bd.booking_id
    LEFT JOIN destinations d ON bd.destination_id = d.id
    GROUP BY b.booking_id, u.username, u.full_name, t.tourguide_name, dvr.tourdriver_name
    ORDER BY b.booking_id ASC
";

// Execute the query
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
    <style>
        /* General layout */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        h1, h2 {
            color: #00a88f; /* Greenish Blue */
            text-align: center;
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
        .logo {
            max-width: 150px;
            height: auto;
        }
        header img {
            max-width: 100px;
            height: auto;
        }

        /* Container */
        .container {
            width: 80%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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
        .message {
            color: #00a88f;
            margin-bottom: 20px;
            text-align: center;
        }

        .back-button { margin-top: 10px; background-color: #ddd; color: #333; }
        .back-button:hover { background-color: #bbb; }
    </style>
</head>
<body>

<header>
    <img src="images/g2.jpg" alt="Explore Mauritius Logo" class="logo" />
    <h1>Bookings Overview</h1>
</header>

<div class="container">
    <?php if (isset($message) && $message != ""): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>User Name</th>
                <th>User Full Name</th>
                <th>Tour Guide</th>
                <th>Driver</th>
                <th>Booking Date</th>
                <th>Destinations</th>
                <th>Total Price</th>
                <th>Adults</th>
                <th>Children</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are any results
            if ($result && $result->num_rows > 0) {
                // Output data for each booking
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['booking_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['user_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['user_full_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tourguide']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['driver_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['booking_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['destinations']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['total_price']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['num_adults']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['num_children']) . "</td>";
                    echo "</tr>";
                }
            } else {
                // If no bookings are found, display a message
                echo "<tr><td colspan='10'>No bookings found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <button class="back-button" onclick="history.back(); return false;">Back To Booking</button>
</div>

<?php
// Close the database connection
$conn->close();
?>

</body>
</html>