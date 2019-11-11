<?php
    class del_hobbies
    {
        public $db;
        public $out;

        function __construct($db, $data)
        {

            $status = ($db == true) ? true : false;

            $json = json_decode($data);
            $hobiesses = $json->{'id_hobbies'};
            $id_user = $json->{'id_user'};

            $values = "";

            $jH = explode(',', $hobiesses);
            for ($i=0; $i < count($jH); $i++) { 
                if ( $jH[$i] == end($jH))
                {
                    $values .= "(".$id_user.", ".$jH[$i].")";
                }
                else
                {
                    $values .= "(".$id_user.", ".$jH[$i]."),";
                }
            }

            //$query = "DELETE FROM user_hobbies WHERE id_user = ".$id_user." AND id_hobbies IN (".$values.");";
            $query = "DELETE FROM user_hobbies WHERE (`id_user`, `id_hobbies`) IN (".$values.");";
            //DELETE FROM table WHERE (col1,col2) IN ((1,2),(3,4),(5,6))


            $result = mysqli_query($db, $query);
            $error = mysqli_error($db);

            $errorOut = (string)$error;
            if (strlen($errorOut) == 0)
            {
                //Success
                $array = array(
                    "status" => $status,
                    "data" => "success",
                    "dataExit" => 0,
                    "message" => "Data uploaded and updated successfully"
                );

                $this->out = json_encode($array);
            }
            else
            {
                $array = array(
                    "status" => $status,
                    "data" => "failure",
                    "dataExit" => 1,
                    "message" => "Data accepted but updating failed with the following error: ".$errorOut. " ::End::",
                    "query" => $query
                );

                $this->out = json_encode($array);
            }

        }


    }

?>