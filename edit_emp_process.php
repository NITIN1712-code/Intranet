<?php
// Include your database connection file
include 'db_conn.php'; // Adjust the path if necessary

// Get the incoming data
$data = json_decode(file_get_contents('php://input'), true);

// Debugging: Check what data is being received
error_log(print_r($data, true)); // Log the received data for debugging

$response = [];
// Check if the necessary data is received
if (isset($data['id'])) {
    // Assign data to variables
    $id = $data['id'];
    $first_name = $data['first_name'];
    $last_name = $data['last_name'];
    $position = $data['position'];
    $hire_date = $data['hire_date'];
    $salary = $data['salary'];
    $email = $data['email'];
    $phone_number = $data['phone_number'];
    $username = $data['username'];

    // Prepare the SQL statement
    $sql = "UPDATE employees SET first_name=?, last_name=?, position=?, hire_date=?, salary=?, email=?, phone_number=?, username=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssdsssi", $first_name, $last_name, $position, $hire_date, $salary, $email, $phone_number, $username, $id);

    // Execute the statement
    if ($stmt->execute()) {
        // Respond with the updated data
        $response['success'] = true;
        $response['first_name'] = $first_name;
        $response['last_name'] = $last_name;
        $response['position'] = $position;
        $response['hire_date'] = $hire_date;
        $response['salary'] = $salary;
        $response['email'] = $email;
        $response['phone_number'] = $phone_number;
        $response['username'] = $username;
    } else {
        $response['success'] = false;
        $response['message'] = "Failed to update employee data: " . $stmt->error; // Include error message
    }
} else {
    // Handle missing ID case
    error_log("No ID received."); // Log an error if ID is not present
    $response['success'] = false;
    $response['message'] = "Invalid request.";
}

// Send the response back to the client
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
$conn->close();
?>