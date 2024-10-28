<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="process_payroll.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    
    <header>
        <h1>Processing Payroll</h1>
    </header>

    <main>
        <section>

            <form>
                <label for="Employee Name">Input Employee Name</label>
                <input id="Employee Name" type="text" name="Employee Name">
            </form>
            <button onclick="generatePayslip();">Search Employee</button>
        </section>
        <section class = "PDFElement" style = "display:none">

        </section>
    </main>

    <footer>
        <p>&copy; 2024 Intranet HR System. All rights reserved.</p>
    </footer>


    <script>
        function generatePayslip(){
            $.ajax({
                url: "get_employee_data.php",
                data: {
                    "employeeName": document.getElementById("Employee Name").value,
                },
                success: function(data){
                },
            });
        }
    </script>
</body>
</html>