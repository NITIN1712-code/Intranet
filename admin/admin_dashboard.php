<h2>Create New Employee</h2>
<form action="create_employee.php" method="post">
    <label for="first_name">First Name:</label>
    <input type="text" name="first_name" required><br>

    <label for="last_name">Last Name:</label>
    <input type="text" name="last_name" required><br>

    <label for="position">Position:</label>
    <select name="position" required>
        <option value="Tour Manager">Tour Manager</option>
        <option value="Tour Guide">Tour Guide</option>
        <option value="Accountant">Accountant</option>
        <option value="HR Manager">HR Manager</option>
    </select><br>

    <label for="hire_date">Hire Date:</label>
    <input type="date" name="hire_date"><br>

    <label for="salary">Salary:</label>
    <input type="number" name="salary" step="0.01"><br>

    <label for="email">Email:</label>
    <input type="email" name="email" required><br>

    <label for="phone_number">Phone Number:</label>
    <input type="text" name="phone_number"><br>

    <input type="submit" value="Create Employee">
</form>


<?php
// Display success or error messages
if (isset($_GET['success'])) {
    echo "<p style='color: green;'>New employee created successfully.</p>";
}
if (isset($_GET['error'])) {
    echo "<p style='color: red;'>Error creating employee. Please try again.</p>";
}
?>
