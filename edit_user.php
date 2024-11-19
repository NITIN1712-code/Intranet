<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Users</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 40px;
        }

        /* Header */
        header {
            background-color: #ffffff;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo {
            max-width: 150px;
            height: auto;
        }


    


        .container {
            width: 90%;
            max-width: 1200px;
            margin-top: 40px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #00a88f;
            color: white;
            text-transform: uppercase;
        }

        td button {
            background-color: #00a88f;
            color: white;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 5px;
        }

        td button:hover {
            background-color: #008f76;
        }

        td input[type="text"] {
            width: 90%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .container {
                width: 95%;
            }

            th, td {
                font-size: 14px;
            }
        }
    </style>
    <script>
    function editRow(button) {
        const row = button.parentNode.parentNode;
        const cells = row.querySelectorAll('td[data-column]');

        cells.forEach(cell => {
            const column = cell.getAttribute('data-column');
            const value = cell.innerText;

            if (['username', 'email', 'phone_num', 'address'].includes(column)) {
                cell.innerHTML = `<input type="text" value="${value}" data-column="${column}">`;
            }
        });

        row.querySelector('td:last-child').innerHTML = `
            <button onclick="saveRow(this)">Save</button>
            <button onclick="deleteRow(this)">Delete</button>`;
    }

    function saveRow(button) {
        const row = button.parentNode.parentNode;
        const cells = row.querySelectorAll('td[data-column]');
        const data = { id: row.querySelector('td[data-id]').innerText };

        cells.forEach(cell => {
            const input = cell.querySelector('input');
            if (input) {
                data[input.getAttribute('data-column')] = input.value;
            }
        });

        fetch('edit_user_process.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                cells.forEach(cell => {
                    const input = cell.querySelector('input');
                    if (input) cell.innerText = input.value;
                });
                row.querySelector('td:last-child').innerHTML = `
                    <button onclick="editRow(this)">Edit</button>
                    <button onclick="deleteRow(this)">Delete</button>`;
            } else {
                alert('Error: ' + result.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function deleteRow(button) {
        const row = button.parentNode.parentNode;
        const userId = row.querySelector('td[data-id]').innerText;

        if (confirm('Are you sure you want to delete this user?')) {
            fetch('delete_user_process.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: userId }),
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    row.remove(); // Remove the row from the table
                } else {
                    alert('Error: ' + result.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }
</script>

</head>
<body>

<header>
    <img src="images/g2.jpg" alt="Explore Mauritius Logo" class="logo" />
    <h1 style="color: #00a88f;">View, Edit And Delete Users</h1>

</header>

<div class="container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
include 'db_conn.php';
$result = $conn->query("SELECT id, username, full_name, email, phone_num, address FROM users");
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td data-id>{$row['id']}</td>";
    echo "<td>{$row['full_name']}</td>";
    echo "<td data-column='username'>{$row['username']}</td>";
    echo "<td data-column='email'>{$row['email']}</td>";
    echo "<td data-column='phone_num'>{$row['phone_num']}</td>";
    echo "<td data-column='address'>{$row['address']}</td>";
    echo "<td>
            <button onclick='editRow(this)'>Edit</button>
            <button onclick='deleteRow(this)'>Delete</button>
          </td>";
    echo "</tr>";
}
$conn->close();
?>

        </tbody>
    </table>
    <button class="back-button" onclick="history.back(); return false;">Back To Booking</button>
</div>

</body>
</html>
