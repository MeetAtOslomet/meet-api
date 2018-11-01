<?php

    class chk_user
    {
        public $db;
        public $out;

        function __construct($db, $data)
        {
            $status = ($db == true) ? true : false;
            if (!empty($data))
            {

                $res = mysqli_query($db, "SELECT * FROM user WHERE username LIKE '".$data."';");
                $error = mysqli_error($db);
                $errorOut = (string)$error;
                $userExists = false;
                if (mysqli_num_rows($res)== 1)
                {
                    //User exists
                    $userExists = true;
                }
                if ($userExists)
                {
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
                    if (strlen($errorOut) == 0)
                    {
                        $array = array(
                            "status" => $status,
                            "data" => "success",
                            "dataExit" => 1,
                            "message" => "User does not exist in user table"
                        );
                        $this->out = json_encode($array);
                    }
                    else
                    {
                        $array = array(
                            "status" => $status,
                            "data" => "error",
                            "dataExit" => -1,
                            "message" => "Data accepted but updating failed with the following error: ".$errorOut. " ::End::"
                        );
            
                        $this->out = json_encode($array);
                    }        
                    
                }

            }


        }

    }



?>