<?php
/**
 * Created by IntelliJ IDEA.
 * User: ANRIEU Quentin
 * Date: 07/11/2018
 * Time: 21:39
 */
require './classes/tandem.php';
class get_my_tandem
{

    public $db;
    public $out;
    public $choice;

    function __construct($db, $data, $choice)
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
                $query = "SELECT t.*, u.first_name, u.last_name FROM tandem AS t INNER JOIN (SELECT * FROM user ) AS u ON t.id_user1 = u.id_user WHERE id_user2 = '".$id_user."'";
                $query2 = "SELECT t.*, u.first_name, u.last_name FROM tandem AS t INNER JOIN (SELECT * FROM user ) AS u ON t.id_user2 = u.id_user WHERE id_user1 = '".$id_user."'";

                $res = mysqli_query($db, $query);
                $res2 = mysqli_query($db, $query2);

                $array = array();
                if(!empty($res))
                {
                    while ($row = mysqli_fetch_array($res)) {
                        $meeting = new tandem(
                            $row['id_user2'],
                            $row['id_user1'],
                            $row['conversationName'],
                            $row['last_name'],
                            $row['first_name']
                            );
                        array_push($array, $meeting);
                    }
                }
                if(!empty($res2))
                {
                    while ($row2 = mysqli_fetch_array($res2)) {
                        $meeting2 = new tandem(
                            $row2['id_user1'],
                            $row2['id_user2'],
                            $row2['conversationName'],
                            $row2['last_name'],
                            $row2['first_name']
                        );
                        array_push($array, $meeting2);
                    }
                }
                if (mysqli_num_rows($res) == 0 AND mysqli_num_rows($res2)== 0 )
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