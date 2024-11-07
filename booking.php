<?php

require("db_conn.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $tour_choice = $_POST['tour_choice'];
    $tourguide_id = null;
    $total_price = 0.00;

    // Retrieve number of adults and children
    $num_adults = $_POST['num_adults'];
    $num_children = $_POST['num_children'];

    if ($tour_choice == 'existing') {
        // Existing tour logic
        $existing_tour_id = $_POST['existing_tour_id'];

        $sql = "SELECT tourguide_id, SUM(destinations.price_adult * ?) + SUM(destinations.price_child * ?) as total_price 
                FROM tours 
                JOIN tour_destination ON tours.id = tour_destination.tourid
                JOIN destinations ON tour_destination.destinationid = destinations.id
                WHERE tours.id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $num_adults, $num_children, $existing_tour_id);
        $stmt->execute();
        $stmt->bind_result($tourguide_id, $total_price);
        $stmt->fetch();
        $stmt->close();

        $sql = "INSERT INTO bookings (user_id, tourguide_id, total_price, num_adults, num_children) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iidii", $user_id, $tourguide_id, $total_price, $num_adults, $num_children);
        $stmt->execute();
        $booking_id = $stmt->insert_id;
        $stmt->close();

        $sql = "INSERT INTO booking_destinations (booking_id, destination_id) 
                SELECT ?, destinationid 
                FROM tour_destination 
                WHERE tourid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $booking_id, $existing_tour_id);
        $stmt->execute();
        $stmt->close();

        echo "<div class='success-message'>Booking confirmed for existing tour with total price: " . $total_price . "</div>";

    } elseif ($tour_choice == 'custom') {
        // Custom tour logic
        $destinations = $_POST['custom_destinations'];
        $tourguide_id = $_POST['custom_tourguide_id'];

        $destination_ids = implode(',', array_map('intval', $destinations));
        $sql = "SELECT SUM(price_adult * ?) + SUM(price_child * ?) FROM destinations WHERE id IN ($destination_ids)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $num_adults, $num_children);
        $stmt->execute();
        $total_price = $stmt->get_result()->fetch_row()[0];
        $stmt->close();

        $sql = "INSERT INTO bookings (user_id, tourguide_id, total_price, num_adults, num_children) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iidii", $user_id, $tourguide_id, $total_price, $num_adults, $num_children);
        $stmt->execute();
        $booking_id = $stmt->insert_id;
        $stmt->close();

        $sql = "INSERT INTO booking_destinations (booking_id, destination_id) VALUES (?, ?)";
        foreach ($destinations as $destination_id) {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $booking_id, $destination_id);
            $stmt->execute();
        }
        $stmt->close();

        echo "<div class='success-message'>Custom booking confirmed with total price: " . $total_price . "</div>";
    }
}

// Fetch data for form options
$tourguides = $conn->query("SELECT tourguide_id, tourguide_name FROM tourguides");
$tours = $conn->query("SELECT id, tour_name FROM tours");
$destinations = $conn->query("SELECT id, name FROM destinations");
$users = $conn->query("SELECT id, username FROM users");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page</title>
    <style>
        /* General Page Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 0;
        }

        /* Header */
        header {
            background-color: #ffffff;
            color: #00a88f;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
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
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            margin-top: 80px;
            width: 100%;
            max-width: 500px;
        }

        /* Form Styling */
        form {
            width: 100%;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        form h2 {
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
        input[type="number"],
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        .existing-tour-options,
        .custom-tour-options {
            display: none;
            padding: 15px;
            border: 1px solid #e0e0e0;
            background-color: #f9f9f9;
            border-radius: 5px;
        }

        .success-message {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 15px;
            margin-top: 20px;
            border: 1px solid #d6e9c6;
            border-radius: 5px;
            text-align: center;
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
    <h1>Tour Booking</h1>
</header>

<div class="container">
    <form action="booking.php" method="POST">
        <h2>Book Your Tour</h2>

        <label for="user_id">Select User:</label>
        <select name="user_id" required>
            <?php while ($row = $users->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['username'] ?></option>
            <?php endwhile; ?>
        </select>

        <label>Select Tour Option:</label>
        <input type="radio" name="tour_choice" value="existing" id="existing" required> Existing Tour
        <input type="radio" name="tour_choice" value="custom" id="custom" required> Custom Tour

        <div class="existing-tour-options">
            <label for="existing_tour_id">Select Existing Tour:</label>
            <select name="existing_tour_id">
                <?php while ($row = $tours->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= $row['tour_name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="custom-tour-options">
            <label>Select Custom Destinations:</label>
            <?php while ($row = $destinations->fetch_assoc()): ?>
                <input type="checkbox" name="custom_destinations[]" value="<?= $row['id'] ?>"> <?= $row['name'] ?><br>
            <?php endwhile; ?>
            <label for="custom_tourguide_id">Select Tour Guide:</label>
            <select name="custom_tourguide_id">
                <?php while ($row = $tourguides->fetch_assoc()): ?>
                    <option value="<?= $row['tourguide_id'] ?>"><?= $row['tourguide_name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <label for="num_adults">Number of Adults:</label>
        <input type="number" name="num_adults" min="1" value="1" required>

        <label for="num_children">Number of Children:</label>
        <input type="number" name="num_children" min="0" value="0" required>

        <button type="submit">Book Now</button>
    </form>
</div>

<script>
    document.getElementById('existing').addEventListener('change', function() {
        document.querySelector('.existing-tour-options').style.display = 'block';
        document.querySelector('.custom-tour-options').style.display = 'none';
    });

    document.getElementById('custom').addEventListener('change', function() {
        document.querySelector('.existing-tour-options').style.display = 'none';
        document.querySelector('.custom-tour-options').style.display = 'block';
    });
</script>

</body>
</html>
