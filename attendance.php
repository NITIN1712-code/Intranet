<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html, body {
            height: 100%;
            width: 100%;
            background-color: #f9f9f9;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            width: 100%;
            height: 100%;
            max-width: none;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative; 
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            flex-grow: 1;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        button {
            padding: 5px 10px;
            margin: 2px;
            border: none;
            cursor: pointer;
        }
        .present {
            background-color: #4CAF50;
            color: white;
        }
        .absent {
            background-color: #f44336;
            color: white;
        }
        .back {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 8px 15px;
            background-color: #808080;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            width: auto; 
            min-width: 80px; 
            text-align: center;
        }
    </style>
</head>
<body>
    <script>
        var emps;
    </script>
    <table id = "tab">
        <tr>
            <th>Employee ID</th>
            <th>Employee Name</th>
            <th>Action</th>
        </tr>
    </table>
    <script>
        function setTable(){
            fetch("attendance_server.php")
            .then((response)=>response.json())
            .then((json_data)=>{
                var tab = document.getElementById("tab");
                tab.innerHTML = "";
                var rowHead = tab.insertRow(0);
                rowHead.innerHTML = "<th>ID</th><th>Name</th><th>Action</th>";
                if(json_data.size){
                    alert("No Datas");
                    return;
                }
                emps = json_data;
                emps.forEach(element => {
                    var row = tab.insertRow(-1);
                    var id = row.insertCell(0);
                    var name = row.insertCell(1);
                    var buttons = row.insertCell(2);
                    if(element["check"] == "pending"){
                        buttons.innerHTML = "<div><button onclick='onPress("+element["id"]+",`present`);'>Present</button><button onclick='onPress("+element["id"]+",`absent`);'>Absent</button></div>"
                    }else{
                        buttons.innerHTML = "<h3>"+element["check"]+"<h3>"
                    }
                    id.innerHTML = element["id"];
                    name.innerHTML = element["first_name"] + " " + element["last_name"];
                });
            })
        }
            

        function onPress(id, type){
            $.ajax({
              url: "attendance_server.php",
              type: "POST",
              data:{
                "id": id,
                "type": type
              },
              success:function(response){
                if(response){
                    alert(response);
                    return;
                }
                setTable();
              }  
            },)
        }

        setTable();

    </script>
</body>
</html>