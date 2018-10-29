<?php

require './classes/language.php';

class get_language
{
    public $db;
    public $out;

    function __construct($db, $data)
    {
        $query = null;
        if ($data == null)
        {
            $query = "SELECT * FROM language";
        }
        elseif (is_string($data) && strpos($data, ',') !== false)
        {
            $query = "SELECT * FROM language WHERE id_language IN (".$data.");";
        }
        else
        {
            $query = "SELECT * FROM language WHERE id_language = '".$data."'";
        }

        $res = mysqli_query($db, $query);
        $array = array();
        while ($row = mysqli_fetch_array($res))
        {
            $hobby = new language ($row['id_language'], $row['name']);
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