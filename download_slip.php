
<script>
    function goBack(){
        history.go(-1);
    }
</script>


<?php

    if(!isset($_GET["id"])){
        echo "<script>goBack();</script>";
        exit();
    }

    require("db_conn.php");

    $res = $conn->query("SELECT e.*,p.* FROM payrolls p
                        INNER JOIN employees e ON e.id = p.employee_id
                        WHERE payroll_id = ".$_GET["id"]);

    $data = $res->fetch_assoc();

    if(!$data){
       echo "<script>goBack();</script>";
    }

    $conn->close();

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../process_payroll.css"></link>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>
<body>
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
                                    <h4 id = Surname><?php echo $data["last_name"]; ?></h4>
                                </div>
                                <div class = "filler">
                                    <h4>Name:</h4>
                                    <h4 id = Name><?php echo $data["first_name"]; ?></h4>
                                </div>
                                <div class = "filler">
                                    <h4>Address:</h4>
                                    <h4 id = Address><?php echo $data["address"]; ?></h4>
                                </div>
                                <br>
                                <div class = "filler">
                                    <h4>Start Date:</h4>
                                    <h4 id = StrtDate><?php echo $data["hire_date"]; ?></h4>
                                </div>
                            </div>
                            <div class="ex">
                                <div class = "filler">
                                    <h4>Issue Date:</h4>
                                    <h4 id = IssDate><?php echo $data["payment_date"]; ?></h4>
                                </div>
                                <div class = "filler">
                                    <h4>Department:</h4>
                                    <h4 id = Dept><?php echo $data["dept_name"]; ?></h4>
                                </div>
                                <div class = "filler">
                                    <h4>Category:</h4>
                                    <h4 id = Cat><?php echo $data["category"]; ?></h4>
                                </div>
                                <div class = "filler">
                                    <h4>Post:</h4>
                                    <h4 id = Post><?php echo $data["position"]; ?></h4>
                                </div>
                                <div class = "filler">
                                    <h4>ID:</h4>
                                    <h4 id = Id><?php echo $data["employee_id"]; ?></h4>
                                </div>
                                <div class = "filler">
                                    <h4>Min Wage:</h4>
                                    <h4 id = MinWg><?php echo $data["salary_base"]; ?></h4>
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
                                <td id = "salaryTotal"><?php echo $data["salary_base"]; ?></td>
                            </tr>
                            <tr>
                                <td>Travelling</td>
                                <td id = "travelRate"></td>
                                <td id = "travelDays"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id = "travelCost"><?php //echo $data["travel_cost"]; ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Gross Pay(A)</td>
                                <td id = "totalSalary"><?php echo $data["salary_base"]; ?></td>
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
                                <td><input><?php echo $data["deductions"]; ?></input></td>
                            </tr>
                            <tr>
                                <td>NSF</td>
                                <td><input value=<?php echo $data["nsf"]; ?>>%</input></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id = "NSFCost"><?php echo $data["salary_base"] * $data["nsf"]; ?></td>
                            </tr>
                            <tr>
                                <td>CSG</td>
                                <td><input value= <?php echo $data["csg"]; ?>>%</input></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id = "CSGCost"><?php echo $data["salary_base"] * $data["csg"]; ?></td>
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
                                <td id="totalSD"><?php echo $data["salary_base"] - $data["paymentAmount"];  ?></td>
                            </tr>
                            <tr><td><br></td></tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Net Pay(A-B)</td>
                                <td id="netSalary"><?php echo $data["paymentAmount"];  ?></td>
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
                                <td id = "PRGFCost"><?php echo $data["salary_base"] * $data["prgf"];?></td>
                            </tr>
                            <tr>
                                <td>CSG</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id = "CCSGCost"><?php echo $data["salary_base"] * $data["CCsg"];?></td>
                            </tr>
                            <tr>
                                <td>NSF</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id = "CNSFCost"><?php echo $data["salary_base"] * $data["CNsf"];?></td>
                            </tr>
                            <tr>
                                <td>Net Pay Breakdown</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id = "netPay"><?php echo $data["salary_base"] * ($data["CNsf"] + $data["CCsg"] + $data["prgf"]);?></td>
                            </tr>
                            <tr><td><br></td></tr>
                            <tr>
                                <th>Paid in Bank Account</th>
                                <td></td>
                                <th id="bankAccNum"><?php echo $data["bank_account_number"];?></th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <th id="totalSalaryPaid"><?php echo $data["paymentAmount"];?></th>
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
        <script>
            fetch("../settings.json")
            .then((response)=>response.json())
            .then((json_data)=>{
                document.getElementById("comp_name").innerHTML= json_data["company"];
                document.getElementById("loc").innerHTML = json_data["location"]["location"];
                document.getElementById("comp_address").innerHTML = json_data["location"]["address"];
                download();
            })
            async function download(){
                const {jsPDF} = window.jspdf;
                const contentCanvas = await html2canvas(document.getElementById("payslip"));
                var img = contentCanvas.toDataURL("image/png");
                var fileName = "payslipredownload.pdf"
                var doc = new jsPDF();
                doc.addImage(img, "png",0 ,0);
                doc.save(fileName);
                goBack();
            }
            
        </script>
</body>
</html>