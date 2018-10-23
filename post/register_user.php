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
            //$password = $json->{'password'};
            //$type = $json->{'type'};

            if (empty($username))
            {
                $array = array(
                    "status" => false,
                    "message" => "Json Post is not a vail json for registration..."
                );
                $this->out = json_encode($array);
            }
            else
            {
                $error = $this->sql($username);
                if ($error == false)
                {
                    $array = array(
                        "status" => true,
                        "registration" => "success",
                        "registrationExit" => 0
                    );

                    $numbers = range(1,4);
                    shuffle($numbers);
                    $code = $numbers[0].$numbers[1].$numbers[2].$numbers[3];



                    $to = $username."@oslomet.no";
                    $from = "From: Meet at Oslomet <meetistheway@gmail.com>";
                    $subject = "Verification code for Meet @ OsloMet";
                    $message = "Your verification code is ".$code. "\n Please insert this code to verify that you are a student or employee at OsloMet"; 
                    $retval = mail($to, $subject, $message, $from);

                    if ($retval == true)
                    {
                        //Insert into database
                        mysqli_query($this->db, "REPLACE INTO activation_key (`username`, `activationKey`) VALUES ('".$username."', '".$code."')");
                        $this->out = json_encode($array);
                    }
                    else
                    {
                        
                        $array = array(
                            "status" => $status,
                            "registration" => "server error",
                            "registrationExit" => 2
                        );

                        $this->out = json_encode($array);
                    }

                    
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

        function sql($username)
        {
            $exists = false;
            /*$res = mysqli_query($this->db, "SELECT username FROM `users` WHERE `username` LIKE '".$username."';");
            print_r($this->db);
            print_r($res);*/
            //echo "SELECT username FROM `users` WHERE `username` LIKE '".$username."';";
            $res = mysqli_query($this->db, "SELECT username, valid FROM `auth_users` WHERE `username` LIKE '".$username."';");
            if (mysqli_num_rows($res)== 1)
            {
                $sqlData = mysqli_fetch_assoc($res);
                $valid = $sqlData['valid'];
                if ($valid == 0)
                {
                    $exists = false;
                }
                else
                {
                    $exists = true;
                }
                //User exists
                
            }
            else
            {
                $res = mysqli_query($this->db, "INSERT INTO auth_users (`username`) VALUES ('".$username."')");
                //echo $res;
            }
            return $exists;
        }

    }



?>