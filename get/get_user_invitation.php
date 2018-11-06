<?php
/**
 * Created by IntelliJ IDEA.
 * User: ANRIEU Quentin
 * Date: 06/11/2018
 * Time: 17:21
 */
require './classes/user_invitation';


class get_user_invitation
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
            $query = "SELECT mq.*, u.first_name FROM match_request AS mq INNER JOIN (SELECT * FROM user ) AS u ON mq.id_userMatch = u.id_user WHERE id_userSend = '".$id_user."' AND requestState=0 ;";
            $res = mysqli_query($db, $query);
            $array = array();
            while ($row = mysqli_fetch_array($res))
            {
                $lang = new user_language(
                    $row['id_userSend'],
                    $row['id_userMatch'],
                    $row['requestState'],
                    $row['first_name']
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