<?php
    require './classes/user.php';

    class add_user
    {
        public $db;
        public $status;
        public $out;

        function __construct($db, $data)
        {
            $this->db = $db;

            $status = false;
            if ($this->db == true)
            {
                $status = true;
            }
            $this->status = $status;
            $json = json_decode($data);
            //var_dump($json);
            $usr = new user(
                $json->{'username'},
                $json->{'first_name'},
                $json->{'last_name'},
                ($json->{'hide_last_name'}) ? 1 : 0, // Just F php code
                $json->{'type'},
                $json->{'gender'},
                $json->{'age'},
                ($json->{'hide_age'}) ? 1 : 0, // Just F php code, this should not be necessary!
                $json->{'id_campus'},
                $json->{'biography'}
            );

            if ($usr->hasRequiredValues() == true)
            {
                $this->update_database($usr);
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

        function update_database($user)
        {
            $query = null;
            //print_r($user);
            $res = mysqli_query($this->db, "SELECT id_user, username FROM `user` WHERE username = '".$user->username."';");
            if (mysqli_num_rows($res)== 1)
            {
                $sqlData = mysqli_fetch_assoc($res);
                $id_user = $sqlData['id_user'];
                //Update
                $query = "UPDATE user SET 
                first_name='".$user->first_name."', 
                last_name='".$user->last_name."',
                hide_last_name='".$user->hide_last_name."',
                type='".$user->type."',
                gender='".$user->gender."',
                age='".$user->age."',
                hide_age='".$user->hide_age."',
                id_campus='".$user->id_campus."',
                biography='".$user->biography."'
                WHERE username='".$user->username."' AND id_user=".$id_user.";";
                
            }
            else
            {
                $query = "INSERT INTO user (`username`, `first_name`, `last_name`, `hide_last_name`, `type`, `gender`, `age`, `hide_age`, `id_campus`, `biography`) 
                VALUES ('".$user->username."', '".$user->first_name."', '".$user->last_name."', '".$user->hide_last_name."', '".$user->type."', '".$user->gender."', '".$user->age."', '".$user->hide_age."', '".$user->id_campus."',  '".$user->biography."');";
            }
            
            $result = mysqli_query($this->db, $query);
            $error = mysqli_error($this->db);

            $errorOut = (string)$error;
            if (strlen($errorOut) == 0)
            {
                //Success
                $array = array(
                    "status" => $this->status,
                    "data" => "success",
                    "dataExit" => 0,
                    "message" => "Data uploaded and updated successfully"
                );

                $this->out = json_encode($array);
            }
            else
            {
                $array = array(
                    "status" => $this->status,
                    "data" => "failure",
                    "dataExit" => 1,
                    "message" => "Data accepted but updating failed with the following error: ".$errorOut. " ::End::"
                );

                $this->out = json_encode($array);
            }


        }





    }


?>