<?php

require './classes/user_language.php';

    class get_user_language
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
                //no allowed
            }
            else
            {
                $query = "SELECT ul.*, l.name FROM user_language AS ul INNER JOIN (SELECT * FROM language) AS l ON ul.id_language = l.id_language WHERE id_user = '".$id_user."';";
                $res = mysqli_query($db, $query);
                $array = array();
                while ($row = mysqli_fetch_array($res))
                {
                    $lang = new user_language(
                        $row['id_user'],
                        $row['id_language'],
                        $row['teachOrLearn'],
                        $row['name']
                    );
                    array_push($array, $lang);
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