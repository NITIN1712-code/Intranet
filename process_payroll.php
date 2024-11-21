<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="process_payroll.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>
<body>

    <script>
        var empdatas;
        const baseRates = new Map([
            ["CSG", 1.5/100],
            ["NSF",1/100],
            ["PRFG",3.7/100],
            ["CCSG",3/100],
            ["CNSF",2.5/100]
        ]);

        var curRates = new Map([
            ["CSG",0],
            ["NSF",0],
            ["PRFG",0],
            ["CCSG",0],
            ["CNSF",0]
        ])

    </script>
    
    <header>
        <h1>Processing Payroll</h1>
    </header>

    <main>
        <section class="search">
            <label for="Employee Name">Input Employee Name</label>
            <input id="Employee Name" type="text" name="Employee Name" onchange="generatePayslip();">
            <select name="Employee_Dropdown" id="Employee_Dropdown">
                <option value=""></option>
            </select>
            <button onclick="fillDoc();">Fill Form</button>
        </section>
        <section class = "holder">
            <div class="pdfElement" id="payslip">
                <div class="companyDetails">
                    <img src="images/payslip_logo.png">
                    <div class="locationDetails">
                        <h4 id="comp_name">
                        </h4>
                        <h4 id="loc">
                        </h4>
                        <h4 id="comp_address">
                        </h4>
                    </div>
                </div>
                <div class = "line" ></div>
                <div class="maindoc">
                    <div class="employeeDetails">
                        <div class="detailsExtented">
                            <div class="ex">
                                <div class = "filler">
                                    <h4>Surname:</h4>
                                    <h4 id = Surname></h4>
                                </div>
                                <div class = "filler">
                                    <h4>Name:</h4>
                                    <h4 id = Name></h4>
                                </div>
                                <div class = "filler">
                                    <h4>Address:</h4>
                                    <h4 id = Address></h4>
                                </div>
                                <br>
                                <div class = "filler">
                                    <h4>Start Date:</h4>
                                    <h4 id = StrtDate></h4>
                                </div>
                            </div>
                            <div class="ex">
                                <div class = "filler">
                                    <h4>Issue Date:</h4>
                                    <h4 id = IssDate></h4>
                                </div>
                                <div class = "filler">
                                    <h4>Department:</h4>
                                    <h4 id = Dept></h4>
                                </div>
                                <div class = "filler">
                                    <h4>Category:</h4>
                                    <h4 id = Cat></h4>
                                </div>
                                <div class = "filler">
                                    <h4>Post:</h4>
                                    <h4 id = Post></h4>
                                </div>
                                <div class = "filler">
                                    <h4>ID:</h4>
                                    <h4 id = Id></h4>
                                </div>
                                <div class = "filler">
                                    <h4>Min Wage:</h4>
                                    <h4 id = MinWg></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="paymentInformation">
                        <table>
                            <tr>
                                <th>Payment</th>
                                <th>Rate</th>
                                <th>Days</th>
                            </tr>
                            <tr>
                                <td>Salary</td>
                                <td></td>
                                <td id = "salDays"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id = "salaryTotal"></td>
                            </tr>
                            <tr>
                                <td>Travelling</td>
                                <td id = "travelRate"></td>
                                <td id = "travelDays"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id = "travelCost"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Gross Pay(A)</td>
                                <td id = "totalSalary"></td>
                            </tr>
                            <tr><td><br></td></tr>
                            <tr><td><br></td></tr>
                            <tr>
                                <td>Deduction</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><input onchange="fillDoc()" type="number" id="deductions"></input></td>
                            </tr>
                            <tr>
                                <td>NSF</td>
                                <td><input onchange="fillDoc()" type="number" id="NSFRate"></input>%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id = "NSFCost"></td>
                            </tr>
                            <tr>
                                <td>CSG</td>
                                <td><input onchange="fillDoc()" type="number" id="CSGRate"></input>%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id = "CSGCost"></td>
                            </tr>
                            <tr>
                                <td>Adv on Salary Deduction</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>(B)</td>
                                <td id="totalSD"></td>
                            </tr>
                            <tr><td><br></td></tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Net Pay(A-B)</td>
                                <td id="netSalary"></td>
                            </tr>
                            <tr><td><br></td></tr>
                            <tr><th>Employer Contribution</th></tr>
                            <tr>
                                <td>PRGF</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id = "PRGFCost"></td>
                            </tr>
                            <tr>
                                <td>CSG</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id = "CCSGCost"></td>
                            </tr>
                            <tr>
                                <td>NSF</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id = "CNSFCost"></td>
                            </tr>
                            <tr>
                                <td>Net Pay Breakdown</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id = "netPay"></td>
                            </tr>
                            <tr><td><br></td></tr>
                            <tr>
                                <th>Paid in Bank Account</th>
                                <td></td>
                                <th id="bankAccNum"></th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <th id="totalSalaryPaid"></th>
                            </tr>
                        </table>
                    </div>
                    <div class="otherInfo">
                        <div class = "sideBox">
                            <h3>Seal</h3>
                            <img src="" class = "imgBox">
                        </div>
                        <div class = "sideBox">
                            <h3>Signature</h3>
                            <img src="" class = "imgBox">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <button onclick="payslipPdf();">Save And Send</button>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Intranet HR System. All rights reserved.</p>
    </footer>


    <script>

        fetch("settings.json")
        .then((response)=>response.json())
        .then((json_data)=>{
            document.getElementById("comp_name").innerHTML= json_data["company"];
            document.getElementById("loc").innerHTML = json_data["location"]["location"];
            document.getElementById("comp_address").innerHTML = json_data["location"]["address"];
        })


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
                        dropdown.innerHTML = "";
                        return;
                    }
                    empdatas = JSON.parse(data);
                    var dropdownstring = ""
                    for(const empData of empdatas){
                        dropdownstring += "<option value="+ empData["id"] +">"+ empData["first_name"] + " " + empData["last_name"] +"</option>"; 
                    }
                    dropdown.innerHTML = dropdownstring;
                },
            });
        }
        
        function fillDoc(){

            setRate("CSG");
            setRate("NSF");
            if(document.getElementById("deductions").value == ""){
                document.getElementById("deductions").value = 0;
            }
            //setRate("PRFG");
            //setRate("CCSG");
            //setRate("CNSF");

            var val = document.getElementById("Employee_Dropdown").value;
            if(val == ""){
                return
            }
            var reqEmp;
            for(const empData of empdatas){
                if(empData["id"] == val){
                    reqEmp = empData;
                    break;
                }
            }
            var surnameEle = document.getElementById("Surname");
            var nameEle = document.getElementById("Name");
            var addressEle = document.getElementById("Address");
            var sdEle = document.getElementById("StrtDate");
            var issdEle = document.getElementById("IssDate");
            var deptEle = document.getElementById("Dept");
            var catEle = document.getElementById("Cat");
            var postEle = document.getElementById("Post");
            var idEle = document.getElementById("Id");
            var mwElement = document.getElementById("MinWg");

            var salDaysEle = document.getElementById("salDays");
            var salaryTotalEle = document.getElementById("salaryTotal");
            
            var travelRateEle = document.getElementById("travelRate");
            var travelDaysEle = document.getElementById("travelDays");
            var travelCostEle = document.getElementById("travelCost");

            var totalSalaryEle = document.getElementById("totalSalary");

            //var nsfRateEle = document.getElementById("NSFRate");
            var nsfCostEle = document.getElementById("NSFCost");

            //var csgRate = document.getElementById("CSGRate");
            var csgCostEle = document.getElementById("CSGCost");

            var totSalDec = document.getElementById("totalSD");

            var netSalEle = document.getElementById("netSalary");

            var prgfCost = document.getElementById("PRGFCost");
            var ccsgCost = document.getElementById("CCSGCost");
            var cnsfCost = document.getElementById("CNSFCost");

            var netPayEle = document.getElementById("netPay");
            var totalSalPaidEle = document.getElementById("totalSalaryPaid");
            var bankAccEle = document.getElementById("bankAccNum");


            var salaryBase = Number(reqEmp["salary"]).toFixed(2);

            var d = new Date();

            surnameEle.innerHTML = reqEmp["last_name"];
            nameEle.innerHTML = reqEmp["first_name"];
            sdEle.innerHTML = reqEmp["hire_date"];
            addressEle.innerHTML = reqEmp["address"];
            mwElement.innerHTML = reqEmp["salary"];
            idEle.innerHTML = reqEmp["id"];
            catEle.innerHTML = reqEmp["employee_category"];
            postEle.innerHTML = reqEmp["position"];
            deptEle.innerHTML = reqEmp["dept_name"]
            issdEle.innerHTML = d.toISOString().split('T')[0];
            travelRateEle.innerHTML = Number(reqEmp["travel_cost"]);
            bankAccEle.innerHTML = reqEmp["bank_account_number"];
            //to set days

            salaryTotalEle.innerHTML = salaryBase;
            totalSalaryEle.innerHTML = salaryBase;

            nsfCostEle.innerHTML = (curRates.get("NSF") * salaryBase).toFixed(2);
            csgCostEle.innerHTML = (curRates.get("CSG") * salaryBase).toFixed(2);
            
            var ded = Number(document.getElementById("deductions").value);
            var totded = Number(nsfCostEle.innerHTML) + Number(csgCostEle.innerHTML) + ded;

            totSalDec.innerHTML = totded.toFixed(2);

            var netPay = salaryBase - totded;

            netSalEle.innerHTML = netPay.toFixed(2);

            var prgf = (salaryBase * baseRates.get("PRFG")).toFixed(2);
            var ccsg = (salaryBase * baseRates.get("CCSG")).toFixed(2);
            var cnsf = (salaryBase * baseRates.get("CNSF")).toFixed(2);

            prgfCost.innerHTML = prgf;
            ccsgCost.innerHTML = ccsg;
            cnsfCost.innerHTML = cnsf;

            netPayEle.innerHTML = (Number(prgf)+Number(ccsg)+Number(cnsf)).toFixed(2);

            totalSalPaidEle.innerHTML = netPay;

        }

        function setRate(name){
            var id = name+"Rate";
            if(document.getElementById(id).value == ""){
                document.getElementById(id).value = baseRates.get(name) * 100;
                curRates.set(name, baseRates.get(name));
            }else{
                curRates.set(name,Number(document.getElementById(id).value)/100);
            }
        }
        function generate() {
            let length = 16;
            const characters = 'abcdefghijklmnopqrstuvwxyz123456789';
            let result = '';
            const charactersLength = characters.length;
            for(let i = 0; i < length; i++) {
                result +=  characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }

        async function payslipPdf(){
            if(document.getElementById("IssDate").innerHTML==""){
                alert("fill the form please");
                return;
            }
            const {jsPDF} = window.jspdf;

            const contentCanvas = await html2canvas(document.getElementById("payslip"));
            var img = contentCanvas.toDataURL("image/png");
            
            var randomValue = generate();

            var fileName = "payslip"+randomValue+".pdf"

            var doc = new jsPDF();
            doc.addImage(img, "png",0 ,0);

            doc.save(fileName);

            alert("Sending Mail...");

            var reqEmp;
            for(const empData of empdatas){
                if(empData["id"] == document.getElementById("Employee_Dropdown").value){
                    reqEmp = empData;
                    break;
                }
            }

            $.ajax({
                url: "save_mail_payslip.php",
                type: "POST",
                data: {
                    "doc": fileName,
                    "id" : document.getElementById("Employee_Dropdown").value,
                    "pay_amount": document.getElementById("totalSalaryPaid").innerHTML,
                    "date": document.getElementById("IssDate").innerHTML,
                    "NSF": curRates.get("NSF"),
                    "CSG": curRates.get("CSG"),
                    "prgf": baseRates.get("PRFG"),
                    "CCSG": baseRates.get("CCSG"),
                    "CNSF": baseRates.get("CNSF"),
                    "address": reqEmp["address"],
                    "salary_base": reqEmp["salary"],
                    "position": reqEmp["position"],
                    "category": reqEmp["employee_category"],
                    "dept_name": reqEmp["dept_name"],
                    "travel_cost": Number(reqEmp["travel_cost"]),
                    "bank_account_number": reqEmp["bank_account_number"],
                },
                success: function(data){
                    alert(data);
                },
            });

            return;
        }
    </script>
</body>
</html>