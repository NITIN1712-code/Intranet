<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
require("db_conn.php");

// Initialize message variable for success or error messages
$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user_id'], $_POST['tour_choice'], $_POST['booking_date'], $_POST['num_adults'], $_POST['num_children'])) {
        $user_id = $_POST['user_id'];
        $tour_choice = $_POST['tour_choice'];
        $booking_date = $_POST['booking_date'];

        $tourguide_id = null;
        $tourdriver_id = null;
        $total_price = 0.00;

        $num_adults = $_POST['num_adults'];
        $num_children = $_POST['num_children'];

        if ($tour_choice == 'existing') {
            if (isset($_POST['existing_tour_id'])) {
                $existing_tour_id = $_POST['existing_tour_id'];
                $sql = "SELECT tourguide_id, tourdriver_id, SUM(destinations.price_adult * ?) + SUM(destinations.price_child * ?) as total_price
                        FROM tours 
                        JOIN tour_destination ON tours.id = tour_destination.tourid
                        JOIN destinations ON tour_destination.destinationid = destinations.id
                        WHERE tours.id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iii", $num_adults, $num_children, $existing_tour_id);
                $stmt->execute();
                $stmt->bind_result($tourguide_id, $tourdriver_id, $total_price);
                $stmt->fetch();
                $stmt->close();

                $sql = "INSERT INTO bookings (user_id, tourguide_id, total_price, num_adults, num_children, tourdriver_id, booking_date)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iidiiis", $user_id, $tourguide_id, $total_price, $num_adults, $num_children, $tourdriver_id, $booking_date);
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

                $message = "Booking confirmed for existing tour with total price: " . $total_price;
            } else {
                $message = "Error: No existing tour selected.";
            }
        } elseif ($tour_choice == 'custom') {
            if (isset($_POST['custom_destinations'], $_POST['custom_tourguide_id'], $_POST['custom_tourdriver_id'])) {
                $destinations = $_POST['custom_destinations'];
                $tourguide_id = $_POST['custom_tourguide_id'];
                $tourdriver_id = $_POST['custom_tourdriver_id'];

                $destination_ids = implode(',', array_map('intval', $destinations));
                $sql = "SELECT SUM(price_adult * ?) + SUM(price_child * ?) 
                        FROM destinations 
                        WHERE id IN ($destination_ids)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $num_adults, $num_children);
                $stmt->execute();
                $total_price = $stmt->get_result()->fetch_row()[0];
                $stmt->close();

                $sql = "INSERT INTO bookings (user_id, tourguide_id, total_price, num_adults, num_children, tourdriver_id, booking_date)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iidiiis", $user_id, $tourguide_id, $total_price, $num_adults, $num_children, $tourdriver_id, $booking_date);
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

                $message = "Custom booking confirmed with total price: " . $total_price;
            } else {
                $message = "Error: Missing required fields for custom tour.";
            }
        } else {
            $message = "Error: Invalid tour choice.";
        }
    } else {
        $message = "Error: Missing form data.";
    }
}

$tourguides = $conn->query("SELECT tourguide_id, tourguide_name FROM tourguides");
$tourdrivers = $conn->query("SELECT tourdriver_id, tourdriver_name FROM tourdrivers");
$tours = $conn->query("SELECT id, tour_name FROM tours");
$destinations = $conn->query("SELECT id, name FROM destinations");
$users = $conn->query("SELECT id, username FROM users");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour Booking</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f7f7f7; margin: 0; padding: 0; }
        .container { width: 80%; margin: 20px auto; background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); }
        h1 { text-align: center; color: #333; }
        form { display: flex; flex-direction: column; gap: 15px; }
        label { font-weight: bold; margin-bottom: 5px; }
        input[type="text"], input[type="number"], select, input[type="date"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        .success-message { background-color: #dff0d8; color: #3c763d; padding: 15px; border: 1px solid #d6e9c6; border-radius: 5px; text-align: center; }
        button { background-color: #00a88f; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #008f76; }
        .back-button { margin-top: 10px; background-color: #ddd; color: #333; }
        .back-button:hover { background-color: #bbb; }
        



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
            max-width: 100px;s
            height: auto;
        }
    </style>
</head>
<body>
<header>
    <img src="images/g2.jpg" alt="Explore Mauritius Logo" />
    <h1>Tour Booking</h1>
</header>
<div class="container">
    <?php if ($message): ?>
        <div class="success-message"><?= $message ?></div>
    <?php endif; ?>

    <form action="booking.php" method="POST">
        <label for="user_id">Select User:</label>
        <select name="user_id" required>
            <?php while ($row = $users->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['username'] ?></option>
            <?php endwhile; ?>
        </select>
        <label for="booking_date">Booking Date:</label>
        <input type="date" name="booking_date" required>
        <label>Select Tour Option:</label>
        <input type="radio" name="tour_choice" value="existing" required> Existing Tour
        <input type="radio" name="tour_choice" value="custom" required> Custom Tour
        <div class="existing-tour-options" style="display: none;">
            <label for="existing_tour_id">Select Existing Tour:</label>
            <select name="existing_tour_id">
                <?php while ($row = $tours->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= $row['tour_name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="custom-tour-options" style="display: none;">
            <label>Select Custom Destinations:</label>
            <?php while ($row = $destinations->fetch_assoc()): ?>
                <input type="checkbox" name="custom_destinations[]" value="<?= $row['id'] ?>"><?= $row['name'] ?><br>
            <?php endwhile; ?>
            <label for="custom_tourguide_id">Select Tour Guide:</label>
            <select name="custom_tourguide_id">
                <?php while ($row = $tourguides->fetch_assoc()): ?>
                    <option value="<?= $row['tourguide_id'] ?>"><?= $row['tourguide_name'] ?></option>
                <?php endwhile; ?>
            </select>
            <label for="custom_tourdriver_id">Select Tour Driver:</label>
            <select name="custom_tourdriver_id">
                <?php while ($row = $tourdrivers->fetch_assoc()): ?>
                    <option value="<?= $row['tourdriver_id'] ?>"><?= $row['tourdriver_name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <label for="num_adults">Number of Adults:</label>
        <input type="number" name="num_adults" min="1" required>
        <label for="num_children">Number of Children:</label>
        <input type="number" name="num_children" min="0">
        <button type="submit">Confirm Booking</button>
        <button class="back-button" onclick="history.back(); return false;">Back To Booking</button>
    </form>
</div>
<script>
    const tourChoiceRadios = document.querySelectorAll('input[name="tour_choice"]');
    const existingTourOptions = document.querySelector('.existing-tour-options');
    const customTourOptions = document.querySelector('.custom-tour-options');

    tourChoiceRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            if (radio.value === 'existing') {
                existingTourOptions.style.display = 'block';
                customTourOptions.style.display = 'none';
            } else if (radio.value === 'custom') {
                existingTourOptions.style.display = 'none';
                customTourOptions.style.display = 'block';
            }
        });
    });
</script>
</body>
</html>






