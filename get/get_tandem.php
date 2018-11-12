<?php

require './classes/tandem.php';
require './classes/user.php';

    class get_tandem
    {
        public $db;
        public $out;

        function __construct($db, $data)
        {
            $this->db = $db;
            $status = ($db == true) ? true : false;
            $json = json_decode($data);
            $id_user = $data;

            $tandemsResult = array();
            $result = mysqli_query($db, "SELECT DISTINCT * FROM tandem AS t INNER JOIN (SELECT * FROM user) AS u1 ON (t.id_user1 = u1.id_user OR t.id_user2 = u1.id_user) WHERE (id_user1 = '".$id_user."' OR id_user2 = '".$id_user."') ORDER BY t.id_tandem;");
            while ($row = mysqli_fetch_array($result))
            {
                 $tEntry = new tandem(
                        $row['id_tandem'],
                        $row['id_user1'],
                        $row['id_user2'],
                        $row['conversationName']
                );

                $tUser = new user(
                    $row['username'],
                    $row['first_name'],
                    $row['last_name'],
                    $row['hide_last_name'],
                    $row['type'],
                    $row['gender'],
                    $row['age'],
                    $row['hide_age'],
                    $row['id_campus'],
                    $row['biography']
                );
                $tUser->id_user = $row['id_user'];

                $isIdPresent = $this->getIndexIfExists($tandemsResult, $tEntry->id_tandem);
                if ($isIdPresent > -1)
                {
                    array_push($tandemsResult[$isIdPresent]["users"], $tUser->getFilteredUser_Array());
                }
                else
                {
                    $item = array(
                        "id_tandem" => $tEntry->id_tandem,
                        "id_user1" => $tEntry->id_user1,
                        "id_user2" => $tEntry->id_user2,
                        "conversationName" => $tEntry->conversationName,
                        "users" => array(
                            $tUser->getFilteredUser_Array()
                        )
                    );
                    array_push($tandemsResult, $item);
                }


                
            }
            $res = array(
                "status" => $status,
                "data" => $tandemsResult
            );

            $this->out = json_encode($res);
        }

        function getIndexIfExists($array, $id)
        {
            $addIndex = -1;
            for ($i = 0; $i < count($array); $i++)
            {
                $tandem = $array[$i]["id_tandem"];
                if ($tandem == $id)
                {
                    $addIndex = $i;
                    return $addIndex;
                }
            }
            return $addIndex;
        }

    }




?>