<?php

    require './classes/hobbies.php';

    class get_hobbies 
    {
        public $db;
        public $out;

        function __construct($db, $data)
        {
            $query = null;
            if ($data == null)
            {
                $query = "SELECT * FROM hobbies";
            }
            elseif (is_string($data) && strpos($data, ',') !== false)
            {
                $query = "SELECT * FROM hobbies WHERE id_hobbies IN (".$data.");";
            }
            else
            {
                $query = "SELECT * FROM hobbies WHERE id_hobbies = '".$data."'";
            }

            $res = mysqli_query($db, $query);
            $array = array();
            while ($row = mysqli_fetch_array($res))
            {
                $hobby = new hobbies($row['id_hobbies'], $row['name']);
                array_push($array, $hobby);
            }

            $status = false;
            if ($db == true)
            {
                $status = true;
            }

            $res = array("status" => $status, "data" => $array);
            $this->out = json_encode($res);

        }


    }


?>