<?php

    require './classes/campus.php';

    class get_campus
    {
        public $db;
        public $out;

        function __construct($db, $data)
        {
            $query = null;
            if ($data == null)
            {
                $query = "SELECT * FROM campus";
            }
            elseif (is_string($data) && strpos($data, ',') !== false)
            {
                $query = "SELECT * FROM campus WHERE id_campus IN (".$data.");";
            }
            else
            {
                $query = "SELECT * FROM campus WHERE id_campus = '".$data."'";
            }

            $res = mysqli_query($db, $query);
            $array = array();
            while ($row = mysqli_fetch_array($res))
            {
                $hobby = new campus($row['id_campus'], $row['name']);
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