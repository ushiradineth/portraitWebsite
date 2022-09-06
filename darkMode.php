<?php     
    if(isset($_GET["mode"])){
        $myObj = new stdClass();
        $myObj->mode = $_GET["mode"];
        $myJSON = json_encode($myObj);
        $myfile = fopen("darkmode.json", "w");
        fwrite($myfile, $myJSON);
        fclose($myfile);
    }

    if(isset($_GET["get"])){
        $json = json_decode(file_get_contents("darkmode.json"), true);
        print_r($json['mode']);
    }
?>