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
    public $choice;

    function __construct($db, $data, $choice)
    {
        $id_user = $data;
        $status = ($db == true) ? true : false;
        $query = null;
        if ($choice==0)
        {

            if ($data == null || empty($data))
            {
                //no allowed
            }
            else
            {
                $query = "SELECT mr.*, u.first_name FROM meeting_request AS mr INNER JOIN (SELECT * FROM user ) AS u ON mr.id_userSend = u.id_user WHERE id_userReceive = '".$id_user."'";
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
        if ($choice==1)
        {
            if ($data == null || empty($data))
            {
                //no allowed
            }
            else
            {
                $query = "SELECT m.*, u.first_name FROM meeting AS m INNER JOIN (SELECT * FROM user ) AS u ON m.id_user1 = u.id_user WHERE id_user2 = '".$id_user."'";
                $query2 = "SELECT m.*, u.first_name FROM meeting AS m INNER JOIN (SELECT * FROM user ) AS u ON m.id_user2 = u.id_user WHERE id_user1 = '".$id_user."'";

                $res = mysqli_query($db, $query);


                $array = array();
                while ($row = mysqli_fetch_array($res)) {
                    $meeting = new user_meeting(
                        $row['id_user2'],
                        $row['id_user1'],
                        1,
                        $row['first_name'],
                        $row['place'],
                        $row['dtime'],
                        $row['meetingMessage']
                    );
                    array_push($array, $meeting);
                }

                $res2 = mysqli_query($db, $query2);
                
                while ($row2 = mysqli_fetch_array($res2)) {
                        $meeting2 = new user_meeting(
                            $row2['id_user1'],
                            $row2['id_user2'],
                            1,
                            $row2['first_name'],
                            $row2['place'],
                            $row2['dtime'],
                            $row2['meetingMessage']
                        );
                        array_push($array, $meeting2);
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

}
