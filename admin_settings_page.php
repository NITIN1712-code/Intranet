<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <header>
    </header>

    <section>
        <form action="settings_change.php" method="POST">
            <label for="download_path">Insert Download Path:</label>
            <input type="text" id="download_path" name="download_path">
            <input type="submit" value="Edit">
        </form>
        <br>
        <br>
        <form action="settings_change.php" method="POST" enctype="multipart/form-data">
            <label for="payslip_logo">(this will delete the current logo)Insert payslip logo:</label>
            <input type="file" id="payslip_logo" name="payslip_logo">
            <br>
            <input type="submit" value="Edit" name="psl">
        </form>
        <br>
        <br>
        <form action="settings_change.php" method="POST" enctype="multipart/form-data">
            <label for="main_logo">(this will delete the current logo)Insert main logo:</label>
            <input type="file" id="main_logo" name="main_logo">
            <br>
            <input type="submit" value="Edit" name="ml">
        </form>
        <br>
        <br>
        <form action="settings_change.php" method="POST">
            <label for="company">Company Name:</label>
            <input type="company" id="company" name="company" required>
            <input type="submit" value="Edit">
        </form>
        <br>
        <br>
        <form action="settings_change.php" method="POST">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>
            <br>
            <br>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>
            <br>
            <input type="submit" value="Edit">
        </form>
    </section>
    

    <script>
        fetch("settings.json")
        .then((response)=>response.json())
        .then((json_data)=>{
            document.getElementById("download_path").value = json_data["download_path"];
            document.getElementById("company").value = json_data["company"];
            document.getElementById("location").value = json_data["location"]["location"];
            document.getElementById("address").value = json_data["location"]["address"];
        })
    </script>
</body>
</html>