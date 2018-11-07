<?php
require '../db.php';
require '../key.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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


$authKey = (isset($_REQUEST['authenticationToken'])) ? $_REQUEST['authenticationToken'] : null;

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

        case 'chk_user':
        {
            require './get/chk_user.php';
            $obj = new chk_user($db, $_GET['username']);
            echo $obj->out;
            break;
        }

        case 'get_user':
        {
            if (hasKey($db, $authKey) == true)
            {
                require './get/get_user.php';
                $obj = new get_user($db, $_GET['id_user']);
                echo $obj->out;
            }
            else
            {
                echo hasKeyJson(false);
            }
            break;
        }

        case 'get_me':
        {
            if (hasKey($db, $authKey) == true)
            {
                require './get/get_me.php';
                $obj = new get_me($db, $_GET['data']);
                echo $obj->out;
            }
            else
            {
                echo hasKeyJson(false);
            }
            break;
        }

        case 'get_id_user':
        {
            if (hasKey($db, $authKey) == true)
            {
                require './get/get_id_user.php';
                $obj = new get_id_user($db, $_GET['username']);
                echo $obj->out;
            }
            else
            {
                echo hasKeyJson(false);
            }
            break;
        }

        case 'get_hobbies':
        {
            require './get/get_hobbies.php';
            
            $obj = new get_hobbies($db, (isset($_GET['hobbies'])) ? $_GET['hobbies'] : null);
            echo $obj->out;
            break;
        }

        case 'get_user_hobbies':
        {
            require './get/get_user_hobbies.php';

            $obj = new get_user_hobbies($db, (isset($_GET['id_user'])) ? $_GET['id_user'] : null);
            echo $obj->out;
            break;
        }

        case 'get_language':
        {
            require './get/get_language.php';
            
            $obj = new get_language($db, (isset($_GET['language'])) ? $_GET['language'] : null);
            echo $obj->out;
            break;
        }

        case 'get_user_language':
        {
            require './get/get_user_language.php';
            $obj = new get_user_language($db, (isset($_GET['id_user'])) ? $_GET['id_user'] : null);
            echo $obj->out;
            break;
        }

        case 'get_user_invitation':
        {
            require './get/get_user_invitation.php';
            $obj = new get_user_invitation($db, (isset($_GET['id_user'])) ? $_GET['id_user'] : null);
            echo $obj->out;
            break;
        }
        case 'get_my_tandem':
        {
            require './get/get_my_tandem.php';
            $obj = new get_my_tandem($db, (isset($_GET['id_user'])) ? $_GET['id_user'] : null);
            echo $obj->out;
            break;
        }
        case 'get_user_meeting':
        {
            require './get/get_user_meeting.php';
            $obj = new get_user_meeting($db, (isset($_GET['id_user'])) ? $_GET['id_user'] : null, (isset($_GET['choice'])) ? $_GET['choice'] : null);
            echo $obj->out;
            break;
        }

        case 'get_recommended':
        {
            if (hasKey($db, $authKey) == true)
            {
                require './get/get_recommended.php';
                $obj = new get_recommended($db, (isset($_GET['data'])) ? $_GET['data'] : null);
                echo $obj->out;   
            }
            else
            {
                echo hasKeyJson(false);
            }
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

        case 'add_user':
        {
            if (hasKey($db, $authKey) == true)
            {
                require './post/add_user.php';
                $obj = new add_user($db, $_POST['data']);
                echo $obj->out;
            }
            else
            {
                echo hasKeyJson(false);
            }

            break;
        }

        case 'add_hobbies':
        {
            if (hasKey($db, $authKey) == true)
            {
                require './post/add_hobbies.php';
                $obj = new add_hobbies($db, $_POST['data']);
                echo $obj->out;
            }
            else
            {
                echo hasKeyJson(false);
            }

            break;
        }

        case 'del_hobbies':
        {
            if (hasKey($db, $authKey) == true)
            {
                require './post/del_hobbies.php';
                $obj = new del_hobbies($db, $_POST['data']);
                echo $obj->out;
            }
            else
            {
                echo hasKeyJson(false);
            }

            break;
        }

        case 'add_language':
        {
            if (hasKey($db, $authKey) == true)
            {
                require './post/add_language.php';
                $obj = new add_language($db, $_POST['data']);
                echo $obj->out;
            }
            else
            {
                echo hasKeyJson(false);
            }

            break;
        }

        case 'del_language':
        {
            if (hasKey($db, $authKey) == true)
            {
                require './post/del_language.php';
                $obj = new del_language($db, $_POST['data']);
                echo $obj->out;
            }
            else
            {
                echo hasKeyJson(false);
            }

            break;
        }
        
        case 'set_meet':
        {
            if (hasKey($db, $authKey) == true)
            {
                require './post/set_meet.php';
                $obj = new set_meet($db, $_POST['data']);
                echo $obj->out;
            }
            else
            {
                echo hasKeyJson(false);
            }

            break;
        }

        case 'set_like':
        {
            if (hasKey($db, $authKey) == true)
            {
                require './post/set_like.php';
                $obj = new set_like($db, $_POST['data']);
                echo $obj->out;
            }
            else
            {
                echo hasKeyJson(false);
            }
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