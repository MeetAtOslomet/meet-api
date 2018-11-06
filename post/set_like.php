<?php

    class set_like
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

            if (!empty($id_user) && !empty($id_user_chosen))
            {
                $select = mysqli_query($db, "SELECT * FROM match_request WHERE id_userSend=".$id_user." AND id_userMatch=".$id_user_chosen.";");

                if (mysqli_num_rows($select)==1)
                {
                    //Its a match

                    $sql = "UPDATE match_request SET requestState=1 WHERE id_userSend=".$id_user."  AND id_userMatch=".$id_user_chosen.";";
                    $sql1 = " INSERT INTO tandem (`id_tandem`,`id_user1`, `id_user2`, `conversationName`, `delete_conversation_user`,`delete_conversation_user2`) VALUES ( NULL ,".$id_user.",".$id_user_chosen.", NULL , NULL , NULL);";
                    mysqli_query($db,$sql);
                    mysqli_query($db,$sql1);


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
                    $query = "REPLACE INTO match_request (`id_userSend`,`id_userMatch`, `requestState`) VALUES (".$id_user.", ".$id_user_chosen.", 0);";
                    mysqli_query($db, $query);

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