<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <script>
        var emps;
    </script>
    <table id = "tab">
        <tr>
            <th>ID</th>
            <th>Name</th>
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