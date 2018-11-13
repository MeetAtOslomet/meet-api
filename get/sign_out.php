<?php

    class sign_out
    {
        public $out;
        function __construct($db, $data)
        {
            $status = ($db == true) ? true : false;
            $json = json_decode($data);
            $id_user = $json->{"id_user"};
            $username = $json->{"username"};
            $token = $json->{"authenticationToken"};

            if (!empty($id_user) && !empty($username) && !empty($token))
            {
                $res = mysqli_query($db, "UPDATE auth_users SET token=null, token_generated=null WHERE username='".$username."' AND token='".$token."';");
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
                $array = array(
                    "status" => $status,
                    "data" => "denied",
                    "dataExit" => 2,
                    "message" => "Data received did not contain the required fields, please verify the json data"
                );

                $this->out = json_encode($array);
            }

        }

    }


?>