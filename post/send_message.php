<?php

class send_message
{
    public $db;
    public $out;

    function __construct($db, $data)
    {
        $this->db = $db;
        $status = ($db == true) ? true : false;

        $json = json_decode($data);
        $id_userSend = $json->{"id_userSend"};
        $id_userReceive = $json->{"id_userReceive"};
        $id_tandem = $json->{"id_tandem"};
        $authToken = $json->{"authenticationToken"};
        $messge = $json->{"message"};

        if (empty($id_userSend) || empty($id_userReceive) || empty($id_tandem) || empty($messge) || empty($authToken))
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
        
        $verifyIds = mysqli_query($db, "SELECT * FROM tandem WHERE id_tandem='".$id_tandem."' 
        AND (id_user1 = '".$id_userSend."' OR id_user2 = '".$id_userSend."' ) AND
        (id_user1 = '".$id_userReceive."' OR id_user2 = '".$id_userReceive."')");

        if (mysqli_num_rows($verifyIds) == 1)
        {
            //Last check to verify that post is not spoofed
            $authenticty = mysqli_query($db, "SELECT * FROM `auth_users` AS au INNER JOIN (SELECT id_user, username FROM user WHERE id_user = '".$id_userSend."') AS u ON u.username = au.username WHERE au.token = '".$authToken."';");
            if (mysqli_num_rows($authenticty) == 1)
            {
                $send = mysqli_query($db, "INSERT INTO send_message (`id_userSend`, `id_userReceive`, `id_tandem`, `message`) VALUES
                ('".$id_userSend."','".$id_userReceive."','".$id_tandem."','".$messge."');");
                
                $error = mysqli_error($db);
                $errorOut = (string)$error;
                if (strlen($errorOut) == 0)
                {
                    //Success
                    $array = array(
                        "status" => $status,
                        "data" => "success",
                        "dataExit" => 0,
                        "message" => "Data uploaded and updated successfully"
                    );

                    $this->out = json_encode($array);
                }
                else
                {
                    $array = array(
                        "status" => $status,
                        "data" => "failure",
                        "dataExit" => 1,
                        "message" => "Data accepted but updating failed with the following error: ".$errorOut. " ::End::"
                    );

                    $this->out = json_encode($array);
                }
            }
            else
            {
                // Spoof out
                $array = array(
                    "status" => $status,
                    "data" => "denied",
                    "dataExit" => 2,
                    "message" => "Data received but it did not correspond with data existing, please try signing out and then in"
                );
                $this->out = json_encode($array);
                return;
            }
        }
        else
        {
            $array = array(
                "status" => $status,
                "data" => "denied",
                "dataExit" => 2,
                "message" => "Data received but it did not correspond with data existing, please try signing out and then in"
            );
            $this->out = json_encode($array);
            return;
        }
    }
}




?>