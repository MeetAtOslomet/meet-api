<?php

    class set_meet
    {
        public $db;
        public $out;

        function __construct($db, $data)
        {
            $this->db = $db;
            $status = ($db == true) ? true : false;

            $json = json_decode($data);
            $id_user = $json->{'id_user'};
            $id_user_chosen = $json->{'id_user_chosen'};
            $meetingMessage = $json->{'meetingMessage'};
            $dtime = $json->{'dtime'};
            $place = $json->{'place'};


            if (!empty($id_user) && !empty($id_user_chosen))
            {
                $select = mysqli_query($db, "SELECT * FROM meeting_request WHERE id_userSend=".$id_user." AND id_userReceive=".$id_user_chosen.";");

                if (mysqli_num_rows($select)==1)
                {
                    //Its a match
                    $sql = "UPDATE meeting_request SET requestState=1 WHERE id_userSend=".$id_user."  AND id_userReceive=".$id_user_chosen.";";
                    $sql .= "REPLACE INTO meeting_request (`id_userSend`, `id_userReceive`, `place`, `dtime`, `meetingMessage`, `requestState` ) VALUES (".$id_user.", ".$id_user_chosen.", '".$place."', ".$dtime.", '".$meetingMessage."', 0);";
                    mysqli_multi_query($db,$sql);

                    //Call A match notification here

                    $error = mysqli_error($db);

                    $errorOut = (string)$error;
                    if (strlen($errorOut) == 0)
                    {
                        //Success
                        $array = array(
                            "status" => $status,
                            "data" => "success",
                            "requestState" => 1,
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
                    $query = "REPLACE INTO meeting_request (`id_userSend`, `id_userReceive`, `place`, `dtime`, `meetingMessage`, `requestState` ) VALUES (".$id_user.", ".$id_user_chosen.", '".$place."', ".$dtime.", '".$meetingMessage."', 0);";
                    $res = mysqli_query($db, $query);

                    $error = mysqli_error($db);

                    $errorOut = (string)$error;
                    if (strlen($errorOut) == 0)
                    {
                        //Success
                        $array = array(
                            "status" => $status,
                            "data" => "success",
                            "requestState" => 0,
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

            }
            else
            {
                $array = array(
                    "status" => $status,
                    "data" => "denied",
                    "dataExit" => 2,
                    "message" => "Data rejected due to requirments not met"
                );

                $this->out = json_encode($array);
            }


        }
    }


?>