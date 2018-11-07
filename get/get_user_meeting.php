<?php
/**
 * Created by IntelliJ IDEA.
 * User: ANRIEU Quentin
 * Date: 07/11/2018
 * Time: 15:21
 */

require './classes/user_meeting.php';

class get_user_meeting
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
            $query = "SELECT mr.*, u.first_name FROM meeting_request AS mr INNER JOIN (SELECT * FROM user ) AS u ON mr.id_userSend = u.id_user WHERE id_userMatch = '".$id_user."' AND requestState=0 ;";
            $res = mysqli_query($db, $query);
            $array = array();
            while ($row = mysqli_fetch_array($res))
            {
                $invitmeeting = new user_meeting(
                    $row['id_userReceive'],
                    $row['id_userSend'],
                    $row['requestState'],
                    $row['first_name'],
                    $row['place'],
                    $row['dtime'],
                    $row['meetingMessage']
                );
                array_push($array, $invitmeeting);
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