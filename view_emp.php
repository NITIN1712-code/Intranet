<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Employees</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* General Page Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 40px;
        }

        h1 {
            color: #00a88f; /* Greenish Blue */
            text-align: center;
            margin: 0;
            font-size: 28px;
            padding: 10px;
        }

        /* Header Styling */
        header {
            background-color: #ffffff; /* White */
            color: #00a88f; /* Greenish Blue */
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 100%;
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        header .logo-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px;
        }

        header img {
            max-width: 200px;
            height: auto;
        }
        header h1 {
    margin-top: 10px;
    font-size: 28px;
    font-weight: bold;
    color: #00a88f; /* Changed color to #00a88f */
}


        /* Container for the Table */
        .container {
            width: 90%;
            max-width: 1200px;
            margin-top: 40px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: auto;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: left;
            font-size: 16px;
        }

        th {
            background-color: #00a88f;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        td {
            background-color: #f9f9f9;
        }

        /* Action Button Styling */
        td button {
            background-color: #00a88f;
            color: white;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        td button:hover {
            background-color: #008f76;
        }

        /* Inputs and Select Styling */
        td input[type="text"],
        td input[type="date"],
        td select {
            width: 90%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        td select {
            background-color: #ffffff;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding-top: 20px;
            }

            .container {
                width: 95%;
            }

            th, td {
                font-size: 14px;
            }

            td input[type="text"],
            td input[type="date"],
            td select {
                width: 100%;
            }
        }
    </style>
    <script>
        function editRow(button) {
            const editRow = button.parentNode.parentNode;
            const cells = editRow.getElementsByTagName('td');

            for (let i = 1; i < cells.length - 1; i++) {
                const cellValue = cells[i].innerText;
                if (cells[i].getAttribute('data-column') === "hire_date") {
                    cells[i].innerHTML = `<input type="date" value="${cellValue}" data-column="${cells[i].getAttribute('data-column')}">`;
                } else if (cells[i].getAttribute('data-column') === "dept_name") {
                    cells[i].innerHTML = `<select id="${cells[i].getAttribute('data-column')}" data-column="${cells[i].getAttribute('data-column')}">
                        <?php
                            require("db_conn.php");
                            $sql = "SELECT * FROM departments";
                            $results = $conn->query($sql);
                            if ($results->num_rows > 0) {
                                while ($row = $results->fetch_assoc()) {
                                    echo "<option value =".$row["id"].">".$row["dept_name"]."</option>";
                                }
                            }
                            $conn->close();
                        ?>
                    </select>`;
                    document.getElementById("dept_name").value = cells[i].getAttribute('data-id');
                } else if (cells[i].getAttribute('data-column') === "employee_category") {
                    cells[i].innerHTML = `<select id="${cells[i].getAttribute('data-column')}" data-column="${cells[i].getAttribute('data-column')}">
                        <option value="Full Time">Full Time</option>
                        <option value="Part Time">Part Time</option>
                    </select>`;
                    document.getElementById("employee_category").value = cellValue;
                } else {
                    cells[i].innerHTML = `<input type="text" value="${cellValue}" data-column="${cells[i].getAttribute('data-column')}">`;
                }
            }

            const actionCell = cells[cells.length - 1];
            actionCell.innerHTML = '<button onclick="saveRow(this)">Save</button>';
        }

        function saveRow(button) {
            const editRow = button.parentNode.parentNode;
            const cells = editRow.getElementsByTagName('td');

            const data = {};
            data.id = cells[0].innerText;
            for (let i = 1; i < cells.length - 1; i++) {
                const input = cells[i].querySelector('input, select');
                data[input.getAttribute('data-column')] = input.value;
            }

            fetch('edit_emp_process.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    for (let i = 1; i < cells.length - 1; i++) {
                        const input = cells[i].querySelector('input, select');
                        cells[i].innerText = data[input.getAttribute('data-column')];
                    }
                    cells[cells.length - 1].innerHTML = '<button onclick="editRow(this)">Edit</button>';
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</head>
<body>

<header>
    <div class="logo-container">
        <img src="images/g2.jpg" alt="Explore Mauritius Logo" class="logo" />
        <h1>View And Edit Employees</h1>
    </div>
</header>

<div class="container">
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
            include 'db_conn.php';
            $result = $conn->query("SELECT e.*, d.dept_name FROM employees e
                                    INNER JOIN departments d ON e.department_id = d.id");
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
                echo "<td data-column='dept_name' data-id='{$row['department_id']}'>{$row['dept_name']}</td>";
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
</div>

</body>
</html>