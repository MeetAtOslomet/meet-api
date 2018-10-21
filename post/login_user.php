<?php

    class login_user
    {
        private $db;
        private $secret;
        public $out;
        function __construct($db, $data, $secret)
        {
            $this->db = $db;
            $this->secret = $secret;
            $json = json_decode($data);
            
            $username = $json->{'username'};
            $password = $json->{'password'};

            if (empty($username) || empty($password))
            {
                $this->out = json_encode(array(
                    "status" => true,
                    "authentication" => "failure",
                    "authenticationExit" => -1,
                    "message" => "No valid data were provided"
                ));
            }
            else
            {
                $this->handleLogin($username, $password);
            }

        }

        function handleLogin($username, $password)
        {
            $res = mysqli_query($this->db, "SELECT id, username, password, valid FROM `users` WHERE `username` LIKE '".$username."';");
            //print_r($res);
            if (mysqli_num_rows($res) == 1)
            {
                $sqlData = mysqli_fetch_assoc($res);
                //print_r($sqlData);
                $dbId = $sqlData['id'];
                $dbUsername = $sqlData['username'];
                $dbPassword = $sqlData['password'];
                $dbValid = $sqlData['valid'];

                if ($dbUsername == $username && $dbPassword == $password && !empty($dbPassword) && $dbPassword != "null" && $dbValid == 1)
                {
                    $d = new DateTime();
                    $key = hash_hmac('sha256', $username.$d->getTimestamp(), $this->secret);

                    $this->out = json_encode(array(
                        "status" => true,
                        "authentication" => "success",
                        "authenticationExit" => 0,
                        "authenticationToken" => $key
                    ));
                    $storeKey = mysqli_query($this->db, "UPDATE `users` SET token='".$key."' WHERE id='".$dbId."';");
                    //print_r($storeKey);

                }
                else if ($dbUsername == $username && $dbPassword == $password && $dbValid == 0)
                {
                    $this->out = json_encode(array(
                        "status" => true,
                        "authentication" => "failure",
                        "authenticationExit" => 2,
                        "message" => "Accont not activated"
                    ));
                }
                else
                {
                    $this->out = json_encode(array(
                        "status" => true,
                        "authentication" => "failure",
                        "authenticationExit" => 1,
                        "message" => "Username or password did not match"
                    ));
                }
            }
            else
            {
                //Could not locate username
                $this->out = json_encode(array(
                    "status" => true,
                    "authentication" => "failure",
                    "authenticationExit" => 2,
                    "message" => "No user is registrated by that username"
                ));
            }
        }



    }


?>