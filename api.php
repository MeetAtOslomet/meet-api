<?php
require '../db.php';
require '../key.php';

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

if ($_SERVER['HTTPS'] != "on")
{
    $out = json_encode(array(
        "status" => true,
        "security" => "none",
        "securityExit" => 1,
        "message" => "API does not accept non HTTPS requests!"
    ));
    echo $out;
    exit;
}


$authKey = $_REQUEST['authenticationToken'];

if ($_SERVER['REQUEST_METHOD'] === "GET")
{
    switch ($_GET['request']) {
        case 'heartbeat':
        {
            require './get/heartbeat.php';
            $obj = new heartbeat($db);
            $json = $obj->getJson();
            echo $json;
            break;
        }

        
        default:
            echo "Defaulted";
            # code...
            break;
    }
    #echo "Request is GET";
    
}
else if ($_SERVER['REQUEST_METHOD'] === "POST")
{
    switch ($_POST['request'])
    {
        case 'register_user':
        {
            //echo 'Inndata: ' . $_POST['data'];
            require './post/register_user.php';
            $obj = new register_user($db, $_POST['data']);
            echo $obj->out;
            break;
        }
        case 'login_user':
        {
            require './post/login_user.php';
            $obj = new login_user($db, $_POST['data'], $secret);
            echo $obj->out;
            break;
        }
        
        case 'auth_check':
        {
            $haskey = hasKey($db, $authKey);
            $hasKeyoUT = hasKeyJson($haskey);
            echo $hasKeyoUT;
            break;
        }

        case 'activate_user':
        {
            require './post/activate_user.php';
            $obj = new activate_user($db, $_POST['data']);
            echo $obj->out;
            break;
        }

        case 'initPass_user':
        {
            require './post/initPass_user.php';
            $obj = new initPass_user($db, $_POST['data']);
            echo $obj->out;

            break;
        }

        case 'list_users':
        {
            if (hasKey($db, $authKey) == true)
            {
                echo "Valid " . true;
            }
            else
            {
                echo "Invalid" . false;
            }
            break;
        }

        default:
            echo $_POST['request'] . ' is not a valid request';
            break;
    }

}

function hasKey($db, $authKey)
{
    $out = false;
    $res = mysqli_query($db, "SELECT token FROM `auth_users` WHERE token='".$authKey."';");
    if (mysqli_num_rows($res)== 1)
    {
        $out = true;
    }
    else
    {
        $out = false;
    }

    return $out;
}

function hasKeyJson($hasKey)
{
    $out = NULL;
    if ($hasKey == true)
    {
        $out = json_encode(array(
            "status" => true,
            "authentication" => "yes",
            "authenticationExit" => 0,
            "message" => "Key is valid, request approved"
        ));
    }
    else
    {
        $out = json_encode(array(
            "status" => true,
            "authentication" => "no",
            "authenticationExit" => 1,
            "message" => "Key is not valid, request rejected!"
        ));
    }
    return $out;
}

mysqli_close($db);
?>