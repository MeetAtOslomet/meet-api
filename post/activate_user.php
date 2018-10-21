<?php

    class activate_user
    {
        public $db;
        public $username;
        public $key;   
        public $out;
        function __construct($db, $data)
        {
            $this->db = $db;
            
            $json = json_decode($data);
            $this->username = $json->{'username'};
            $this->key = $json->{'activationKey'};

            $this->handleActivation($this->username, $this->key);
        }

        function handleActivation($username, $code)
        {
            $res = mysqli_query($this->db, "SELECT * FROM activation_key WHERE username='".$username."' AND activationKey='".$code."';");
            if (mysqli_num_rows($res) == 1)
            {
                mysqli_query($this->db, "UPDATE users SET valid=1 WHERE username='".$username."';");
                $this->out = json_encode(array(
                    "status" => true,
                    "authentication" => "success",
                    "authenticationExit" => 0,
                    "message" => "Account activated"
                ));
            }
            else
            {
                $this->out = json_encode(array(
                    "status" => true,
                    "authentication" => "failure",
                    "authenticationExit" => 1,
                    "message" => "Code could not be validated.."
                ));
            }
        }

    }



?>