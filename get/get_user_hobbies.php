<?php

require './classes/user_hobbies.php';

    class get_user_hobbies
    {
        public $db;
        public $out;

        function __construct($db, $data)
        {
            $id_user = $data;
            $status = ($db == true) ? true : false;
            $query = null;
            if ($data == null || empty($data))
            {

            }
            else
            {
                $query = "SELECT uh.*, h.name FROM user_hobbies as uh INNER JOIN hobbies as h ON h.id_hobbies = uh.id_hobbies WHERE uh.id_user = ".$id_user.";"
                $res = mysqli_query($db, $query);
                $array = array();
                while ($row = mysqli_fetch_array($res))
                {
                    $hobby = new user_hobbies(
                        $row['id_user'],
                        $row['id_hobbies'],
                        $row['name']
                    );
                    array_push($array, $hobby);
                }
                if (mysqli_num_rows($res) == 0)
                {
                    $dat = array("status" => $status, "data" => null);
                    $this->out = json_encode($dat);
                }
                else
                {
                    $dat = array("status" => $status, "data" => $array);
                    $this->out = json_encode($dat);
                }
            }


        }


    }




?>