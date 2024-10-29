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
            <label for="Employee Name">Input Employee Name</label>
            <input id="Employee Name" type="text" name="Employee Name" onchange="generatePayslip();">
            <select name="Employee_Dropdown" id="Employee_Dropdown">
                <option value=""></option>
            </select>
            <!--<button onclick="generatePayslip();">Fill Form</button>-->
        </section>
        <section class = "PDFElement" style = "display:none">

        </section>
    </main>

    <footer>
        <p>&copy; 2024 Intranet HR System. All rights reserved.</p>
    </footer>


    <script>
        function generatePayslip(){
            if(document.getElementById("Employee Name").value == ""){
                document.getElementById("Employee_Dropdown").innerHTML = "";
                return;
            }
            $.ajax({
                url: "get_employee_data.php",
                type: "GET",
                data: {
                    "employeeName": document.getElementById("Employee Name").value,
                },
                success: function(data){
                    var dropdown = document.getElementById("Employee_Dropdown");
                    if(data == "ND"){
                        //NO DATA
                        dropdown.innerHTML = "";
                        return;
                    }
                    data = JSON.parse(data);
                    var dropdownstring = ""
                    for(const empData of data){
                        dropdownstring += "<option value="+ empData["id"] +">"+ empData["first_name"] + " " + empData["last_name"] +"</option>"; 
                    }
                    dropdown.innerHTML = dropdownstring;
                },
            });
        }
    </script>
</body>
</html>