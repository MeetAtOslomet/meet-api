<?php
require '../db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === "GET")
{
    switch ($_GET['request']) {
        case 'heartbeat':
        {
            require './get/heartbeat.php';
            $obj = new heartbeat();
            $json = $obj->getJson();
            echo $json;
            break;
        }

        
        default:
            echo "Break missing in case!";
            # code...
            break;
    }
    #echo "Request is GET";
    
}
else if ($_SERVER['REQUEST_METHOD'] === "POST")
{
    echo "Request is POST";


}

mysqli_close($db);
?>