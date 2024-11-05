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
                if(cells[i].getAttribute('data-column') == "hire_date"){
                    cells[i].innerHTML = `<input type="date" value="${cellValue}" data-column="${cells[i].getAttribute('data-column')}">`;
                    continue;
                }
                if(cells[i].getAttribute('data-column') == "dept_name"){
                    cells[i].innerHTML = `<select id="${cells[i].getAttribute('data-column')}" data-column="${cells[i].getAttribute('data-column')}">
                        <?php
                            require("db_conn.php");
        
                            $sql = "SELECT * FROM departments";
                            $results = $conn->query($sql);
        
                            if($results->num_rows > 0){
                                while($row = $results->fetch_assoc()){
                                    echo "<option value =".$row["id"].">".$row["dept_name"]."</option>";
                                }
                            }
        
                            $conn->close();
                        ?>
                    </select>`;
                    var sel = document.getElementById("dept_name");
                    sel.value = cells[i].getAttribute('data-id');
                    continue;
                }
                if(cells[i].getAttribute('data-column') == "employee_category"){
                    cells[i].innerHTML = `<select id="${cells[i].getAttribute('data-column')}" value="${cellValue}" data-column="${cells[i].getAttribute('data-column')}">
                        <option value="Full Time">Full Time</option>
                        <option value="Part Time">Part Time</option>
                    </select>`;
                    var sel = document.getElementById("employee_category");
                    sel.value = cellValue;
                    continue;
                }
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
                var input = cells[i].getElementsByTagName('input')[0];
                if(!input){
                    input = cells[i].getElementsByTagName('select')[0];
                }
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
                        var cell = cells[i].getElementsByTagName('input')[0];
                        if(!cell){
                            cell = cells[i].getElementsByTagName('select')[0];
                        }
                        cells[i].innerText = data[cell.getAttribute('data-column')]; // Update cell with new data
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
                <th>Department</th>
                <th>Address</th>
                <th>Employee Category</th>
                <th>Bank Account Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch employees from the database
            include 'db_conn.php'; // Ensure you have this file
            $result = $conn->query("SELECT e.*,d.dept_name FROM employees e
                                    INNER JOIN departments d
                                    ON e.department_id = d.id");
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
                echo "<td data-column='dept_name' data-id={$row['department_id']}>{$row['dept_name']}</td>";
                echo "<td data-column='address'>{$row['address']}</td>";
                echo "<td data-column='employee_category'>{$row['employee_category']}</td>";
                echo "<td data-column='bank_account_number'>{$row['bank_account_number']}</td>";
                echo "<td><button onclick='editRow(this)'>Edit</button></td>";
                echo "</tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
