<?php

    class initPass_user
    {
        public $out;
        public $db;
        function __construct($db, $data)
        {
            $this->db = $db;
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
                $this->initPassword($username, $password);
            }

        }

        function initPassword($username, $password)
        {
            $res = mysqli_query($this->db, "SELECT id, username, password, valid FROM `users` WHERE username='".$username."' AND password IS NULL;");
            if (mysqli_num_rows($res) == 1)
            {
                $sqlData = mysqli_fetch_assoc($res);
                $dbId = $sqlData['id'];
                $dbUsername = $sqlData['username'];
                $dbPassword = $sqlData['password'];
                $dbValid = $sqlData['valid'];

                if ($dbPassword == null)
                {
                    mysqli_query($this->db, "UPDATE users SET password='".$password."' WHERE username='".$username."' AND id=".$dbId.";");
                    $this->out = json_encode(array(
                        "status" => true,
                        "authentication" => "accepted",
                        "authenticationExit" => 0,
                        "message" => "Password has been passed"
                    ));
                }
                else
                {
                    $this->out = json_encode(array(
                        "status" => true,
                        "authentication" => "denied",
                        "authenticationExit" => 2,
                        "message" => "This method is for first time password setup!"
                    ));
                }

            }
            else
            {
                $this->out = json_encode(array(
                    "status" => true,
                    "authentication" => "denied",
                    "authenticationExit" => 2,
                    "message" => "This method is for first time password setup!"
                ));
            }
        }


    }

?>