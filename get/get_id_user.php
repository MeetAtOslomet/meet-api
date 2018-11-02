<?php

class get_id_user
{

    function __construct($db, $data)
    {
        $status = ($db == true) ? true : false;
        $res = mysqli_query($db, "SELECT * FROM user WHERE username = '".$data."';");
        if (mysqli_num_rows($res) == 1)
        {
            $sqlData = mysqli_fetch_assoc($res);
            $array = array
            (
                "id_user" => $sqlData['id_user']
            );
            $this->out = json_encode($array);
        }
        else
        {
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
                    "message" => "Data accepted but updating failed with the following error: ".$errorOut. " ::End::"
                );
    
                $this->out = json_encode($array);
            }
        }
    }


}




?>