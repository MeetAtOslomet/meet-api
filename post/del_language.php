<?php
class del_language
{
    public $db;
    public $out;

    function __construct($db, $data)
    {
        $query = null;
        $teachOrLearn = null;
        $id_language = null;
        $id_user = null;

        $status = ($db == true) ? true : false;
        $this->db = $db;
        $json = json_decode($data);
        $id_language = $json->{'id_language'};
        $id_user = $json->{'id_user'};
        $teachOrLearn = $json->{'teachOrLearn'};

        $gl = "SELECT * FROM user_language WHERE id_user = '".$id_user."' AND id_language = '".$id_language."';";
        $gres = mysqli_query($this->db, $gl);
        $sqgres = mysqli_fetch_assoc($gres);
        
        $tol = $sqgres["teachOrLearn"];
        if ($tol != null)
        {
            if ($tol == "2" && $teachOrLearn == "1")
            {
                // Update and set teachOrLearn to 0
                $query = $this->updateEntry($id_user, $id_language, '0');
            }
            else if ($tol == "2" && $teachOrLearn == "0")
            {
                // Update and set teachOrLearn to 1
                $query = $this->updateEntry($id_user, $id_language, '1');
            }
            else
            {
                // Just delete the row so that the user can re-add either one
                $query = $this->deleteEntry($id_user, $id_language);
            }
        }
        else
        {
            $array = array(
                "status" => $status,
                "data" => "failure",
                "dataExit" => 1,
                "message" => "Data accepted but obtaining relevant data failed"
            );

            $this->out = json_encode($array);
        }

        if($query != null)
        {
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
                    "message" => "Data uploaded and updated successfully",
                    "query" => $query
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
        else
        {
            $array = array(
                "status" => $status,
                "data" => "failure",
                "dataExit" => 1,
                "message" => "Data rejected, data does not correspond with data stored in the database",
                "query" => $query
            );

            $this->out = json_encode($array);
        }


        

    }

    function deleteEntry($id_user, $id_language)
    {
        $q = "DELETE FROM user_language WHERE id_user = '".$id_user."' AND id_language = '".$id_language."'";
        return $q;
    }

    function updateEntry($id_user, $id_language, $teachOrLearn)
    {
        $q = "UPDATE user_language SET teachOrLearn = '".$teachOrLearn."' WHERE id_user = '".$id_user."' AND id_language = '".$id_language."';";
        return $q;
    }


}

?>