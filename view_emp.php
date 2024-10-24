<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Employees</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function editRow(button) {
            const editRow = button.parentNode.parentNode;
            const cells = editRow.getElementsByTagName('td');

            // Convert cells to input fields
            for (let i = 1; i < cells.length - 1; i++) {
                const cellValue = cells[i].innerText;
                cells[i].innerHTML = `<input type="text" value="${cellValue}" data-column="${cells[i].getAttribute('data-column')}">`;
            }

            // Change Edit button to Save
            const actionCell = cells[cells.length - 1];
            actionCell.innerHTML = '<button onclick="saveRow(this)">Save</button>';
        }

        function saveRow(button) {
            const editRow = button.parentNode.parentNode;
            const cells = editRow.getElementsByTagName('td');

            // Collect data to send to the server
            const data = {};
            data.id = cells[0].innerText; // Get ID
            for (let i = 1; i < cells.length - 1; i++) {
                const input = cells[i].getElementsByTagName('input')[0];
                data[input.getAttribute('data-column')] = input.value; // Get input values
            }

            console.log("Data being sent to the server:", data); // Debugging line

            // Send data to the server using fetch
            fetch('edit_emp_process.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // Log the response data
                if (data.success) {
                    // Update the table cells with the new values
                    for (let i = 1; i < cells.length - 1; i++) {
                        const column = cells[i].getElementsByTagName('input')[0].getAttribute('data-column');
                        cells[i].innerText = data[column]; // Update cell with new data
                    }
                    // Change Save button back to Edit
                    const actionCell = cells[cells.length - 1];
                    actionCell.innerHTML = '<button onclick="editRow(this)">Edit</button>';
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</head>
<body>
    <h1>View Employees</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Position</th>
                <th>Hire Date</th>
                <th>Salary</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch employees from the database
            include 'db_conn.php'; // Ensure you have this file
            $result = $conn->query("SELECT * FROM employees");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td data-column='first_name'>{$row['first_name']}</td>";
                echo "<td data-column='last_name'>{$row['last_name']}</td>";
                echo "<td data-column='position'>{$row['position']}</td>";
                echo "<td data-column='hire_date'>{$row['hire_date']}</td>";
                echo "<td data-column='salary'>{$row['salary']}</td>";
                echo "<td data-column='email'>{$row['email']}</td>";
                echo "<td data-column='phone_number'>{$row['phone_number']}</td>";
                echo "<td data-column='username'>{$row['username']}</td>";
                echo "<td><button onclick='editRow(this)'>Edit</button></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
