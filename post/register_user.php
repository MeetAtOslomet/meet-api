<?php

    class register_user
    {
        private $db;
        public $out;
        function __construct($db, $data)
        {
            $this->db = $db;

            $json = json_decode($data);

            $username = $json->{'username'};
            $password = $json->{'password'};
            $type = $json->{'type'};

            if (empty($username) || empty($password) || empty($type))
            {
                $array = array(
                    "status" => false,
                    "message" => "Json Post is not a vail json for registration..."
                );
                $this->out = json_encode($array);
            }
            else
            {
                $error = $this->sql($username, $password, $type);
                if ($error == false)
                {
                    $array = array(
                        "status" => true,
                        "registration" => "success",
                        "registrationExit" => 0
                    );
                    $this->out = json_encode($array);
                }
                else
                {
                    $status = false;
                    if ($this->db == true)
                    {
                        $status = true;
                    }

                    $array = array(
                        "status" => $status,
                        "registration" => "failure",
                        "registrationExit" => 1
                    );

                    $this->out = json_encode($array);
                }
            }

        }

        function sql($username, $password, $type)
        {
            $exists = false;
            /*$res = mysqli_query($this->db, "SELECT username FROM `users` WHERE `username` LIKE '".$username."';");
            print_r($this->db);
            print_r($res);*/
            echo "SELECT username FROM `users` WHERE `username` LIKE '".$username."';";
            if (mysqli_num_rows(mysqli_query($this->db, "SELECT username FROM `users` WHERE `username` LIKE '".$username."';"))== 1)
            {
                //User exists
                $exists = true;
            }
            else
            {
                $res = mysqli_query($this->db, "INSERT INTO users (`username`, `password`, `type`) VALUES ('".$username."', '".$password."', '".$type."')");
                echo $res;
            }
            return $exists;
        }

    }



?>