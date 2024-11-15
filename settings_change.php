<?php

    if(isset($_POST["company"])){
        $jsonData = json_decode(file_get_contents("settings.JSON"),true);

        $jsonData["company"] = $_POST["company"];

        file_put_contents("settings.JSON", json_encode($jsonData));

        echo "Edited path successfully!";

        exit();
    }

    if(isset($_POST["location"]) && isset($_POST["address"])){
        $jsonData = json_decode(file_get_contents("settings.JSON"),true);

        $jsonData["location"]["location"] = $_POST["location"];
        $jsonData["location"]["address"] = $_POST["address"];

        file_put_contents("settings.JSON", json_encode($jsonData));

        echo "Edited path successfully!";

        exit();
    }

    if(isset($_POST["download_path"])){

        $jsonData = json_decode(file_get_contents("settings.JSON"),true);

        $jsonData["download_path"] = $_POST["download_path"];

        file_put_contents("settings.JSON", json_encode($jsonData));

        echo "Edited path successfully!";

        exit();
    }

    if(isset($_POST["psl"])){
        $imagePath = "images/";
        $target_file = $imagePath . "payslip_logo.png";

        if(file_exists($target_file)){
            unlink($target_file);
        }

        if(move_uploaded_file($_FILES["payslip_logo"]["tmp_name"], $target_file)){
            echo "Successfully updated payslip Logo!";
        }
        exit();
    }

    if(isset($_POST["ml"])){
        $imagePath = "images/";
        $target_file = $imagePath . "g2.jpg";
        
        

        if(file_exists($target_file)){
            unlink($target_file);
        }

        if(move_uploaded_file($_FILES["main_logo"]["tmp_name"], $target_file)){
            echo "Successfully updated main Logo!";
        }
        exit();
    }

    echo "Please fill appropriately!";



?>