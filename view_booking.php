<?php
// Connect to the database
require("db_conn.php");

// Check if the connection is successful
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// SQL query with LEFT JOIN to retrieve booking information
$query = "
    SELECT 
        b.booking_id, 
        b.total_price, 
        b.num_adults, 
        b.num_children, 
        u.username AS user_name, 
        u.full_name AS user_full_name, 
        t.tourguide_name AS tourguide,
        GROUP_CONCAT(d.name SEPARATOR ', ') AS destinations
    FROM bookings b
    LEFT JOIN users u ON b.user_id = u.id
    LEFT JOIN tourguides t ON b.tourguide_id = t.tourguide_id
    LEFT JOIN booking_destinations bd ON b.booking_id = bd.booking_id
    LEFT JOIN destinations d ON bd.destination_id = d.id
    GROUP BY b.booking_id, u.username, u.full_name, t.tourguide_name
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
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        h1 {
            color: #00a88f; /* Greenish Blue */
            text-align: center;
            margin: 0;
            padding: 20px 0;
        }
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
        .container {
            width: 80%;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            flex-grow: 1;
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
        .message {
            color: #00a88f; /* Greenish Blue */
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<header>
    <img src="images/g2.jpg" alt="Explore Mauritius Logo" class="logo" />
    <h1>Bookings Overview</h1>
</header>

<div class="container">
    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>User Name</th>
                <th>User Full Name</th>
                <th>Tour Guide</th>
                <th>Destinations</th>
                <th>Total Price</th>
                <th>Adults</th>
                <th>Children</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are any results
            if ($result->num_rows > 0) {
                // Output data for each booking
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['booking_id'] . "</td>";
                    echo "<td>" . $row['user_name'] . "</td>";
                    echo "<td>" . $row['user_full_name'] . "</td>";
                    echo "<td>" . $row['tourguide'] . "</td>";
                    echo "<td>" . $row['destinations'] . "</td>";
                    echo "<td>" . $row['total_price'] . "</td>";
                    echo "<td>" . $row['num_adults'] . "</td>";
                    echo "<td>" . $row['num_children'] . "</td>";
                    echo "</tr>";
                }
            } else {
                // If no bookings are found, display a message
                echo "<tr><td colspan='8'>No bookings found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
// Close the database connection
$conn->close();
?>

</body>
</html>




