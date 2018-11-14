<?php

require './classes/messaging.php';

class receive_message
{
    public $out;

    function __construct($db, $data)
    {
        $status = ($db == true) ? true : false;
        $json = json_decode($data);
        $id_tandem = $json->{"id_tandem"};
        $id_user = $json->{"id_user"};
        $authToken = $json->{"authenticationToken"};

        if (empty($id_tandem) || empty($id_user) || empty($authToken))
        {
            $array = array(
                "status" => $status,
                "data" => "denied",
                "dataExit" => 2,
                "message" => "Data received did not contain the required fields, please verify the json data"
            );
            $this->out = json_encode($array);
            return;
        }

        $verifyId = mysqli_query($db, "SELECT * FROM tandem WHERE id_tandem = '".$id_tandem."' AND (id_user1 = '".$id_user."' OR id_user2 = '".$id_user."');");
        if (mysqli_num_rows($verifyId) == 1)
        {
            $authenticty = mysqli_query($db, "SELECT * FROM `auth_users` AS au INNER JOIN (SELECT id_user, username FROM user WHERE id_user = '".$id_user."') AS u ON u.username = au.username WHERE au.token = '".$authToken."';");
            if (mysqli_num_rows($authenticty) == 1)
            {
                $received = array();
                $receive = mysqli_query($db, "SELECT * FROM send_message WHERE id_tandem = '".$id_tandem."' AND (id_userSend = '".$id_user."' OR id_userReceive = '".$id_user."')");
                while ($row = mysqli_fetch_array($receive))
                {
                    $msg = new messaging(
                        $row["id_message"],
                        $row["id_userSend"],
                        $row["id_userReceive"],
                        $row["id_tandem"],
                        $row["dtime"],
                        $row["viewMessage"],
                        $row["message"]
                    );
                    array_push($received, $msg);
                }

                if (count($received) > 0)
                {
                    $msg = $received[0];
                    if (isset($msg) && !empty($msg))
                    {
                        $query = "UPDATE send_message SET viewMessage = 1 WHERE (viewMessage = 0 OR viewMessage IS NULL) AND id_tandem = '".$msg->id_tandem."' AND id_userReceive='".$id_user."';";
                        ///Set messages as read
                        mysqli_query($db, $query);
                    }
                }



                $resArray = array(
                    "status" => $status,
                    "data" => $received
                );
        
                $this->out = json_encode($resArray);

            }
        }



    }



}




?>