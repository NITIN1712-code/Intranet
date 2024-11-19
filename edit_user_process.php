<?php
// Include database connection
include 'db_conn.php';

// Get the raw input data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Check if required data is provided
if (isset($data['id']) && isset($data['username']) && isset($data['email']) && isset($data['phone_num']) && isset($data['address'])) {
    // Sanitize inputs
    $id = intval($data['id']);
    $username = $conn->real_escape_string(trim($data['username']));
    $email = $conn->real_escape_string(trim($data['email']));
    $phone_num = $conn->real_escape_string(trim($data['phone_num']));
    $address = $conn->real_escape_string(trim($data['address']));

    // Update query
    $sql = "UPDATE users 
            SET username = '$username', email = '$email', phone_num = '$phone_num', address = '$address' 
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Success response
        echo json_encode([
            'success' => true,
            'message' => 'User details updated successfully.',
            'username' => $username,
            'email' => $email,
            'phone_num' => $phone_num,
            'address' => $address
        ]);
    } else {
        // Error response
        echo json_encode([
            'success' => false,
            'message' => 'Error updating user details: ' . $conn->error
        ]);
    }
} else {
    // Missing data response
    echo json_encode([
        'success' => false,
        'message' => 'Invalid input data.'
    ]);
}

// Close database connection
$conn->close();
?>
