<?php

require './classes/get/tandem.php';

    class get_tandem
    {
        public $db;
        public $out;

        public __construct($db, $data)
        {
            $this->db = $db;
            $json = json_decode($data);
            $id_user = $json->{'id_user'};

            $tandemArray = array();

            $query = "SELECT * FROM tandem WHERE id_user1 = ".$id_user." OR id_user2 = ".$id_user.";";
            $res = mysqli_query($db, $query);
            
            while ($row = mysqli_fetch_array($res))
            {
                $tandem = new tandem(
                    $row['id_user1'],
                    $row['id_user2'],
                    $row['conversationName']
                );
            }




        }


    }




?>