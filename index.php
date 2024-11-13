<?php
    $settings = json_decode(file_get_contents("settings.JSON"),true);
    $quotes = json_decode(file_get_contents("quotes.JSON"),true);

    if($settings["quote"]["date"] != date("d")){
        $quote = $quotes[rand(0,16)];
        $settings["quote"]["quote"] = $quote["quote"];
        $settings["quote"]["author"] = $quote["author"];
        $settings["quote"]["date"] = date("d");

        file_put_contents("settings.JSON", json_encode($settings));
    }

    header("Location:login.php");

?>