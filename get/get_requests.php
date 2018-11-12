<?php

require './classes/user.php';

class get_requests
{
    public $db;
    public $out;

    function __construct($db, $data)
    {
        $this->db = $db;
        $status = ($db == true) ? true : false;

        $outArray = array();

        $id_user = $data;
        $result = mysqli_query($db, "SELECT * FROM match_request AS m INNER JOIN user AS u ON m.id_userSend = u.id_user WHERE m.requestState = 0 AND m.id_userMatch = ".$id_user.";");
        while ($row = mysqli_fetch_array($result))
        {
            $match = array(
                "id_userSend" => $row["id_userSend"],
                "id_userMatch" => $row["id_userMatch"],
                "requestState" => $row["requestState"]
            );

            $user = new user(
                $row["username"],
                $row["first_name"],
                $row["last_name"],
                $row["hide_last_name"],
                $row["type"],
                $row["gender"],
                $row["age"],
                $row["hide_age"],
                $row["id_campus"],
                $row["biography"]
            );
            $userArray = $user->getFilteredUser_Array();
            array_push($match, $userArray);

            array_push($outArray, $match);
        }

        $resArray = array(
            "status" => $status,
            "data" => $outArray
        );

        $this->out = json_encode($resArray);

    }



}




?>