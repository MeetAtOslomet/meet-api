<?php
class add_language
{
    public $db;
    public $out;

    function __construct($db, $data)
    {

        $status = ($db == true) ? true : false;

        $json = json_decode($data);
        //print_r($json);
        $values = "";
        $languageArray = $json->{'languages'};
        for ($i = 0; $i < count($languageArray); $i++)
        {
            //print_r($languageArray[$i]);
            if ($languageArray[$i] == end($languageArray))
            {
                $values .= "('".$languageArray[$i]->{'id_user'}."', '".$languageArray[$i]->{'id_language'}."', '".$languageArray[$i]->{'teachOrLearn'}."');";
            }
            else
            {
                $values .= "('".$languageArray[$i]->{'id_user'}."', '".$languageArray[$i]->{'id_language'}."', '".$languageArray[$i]->{'teachOrLearn'}."'), ";
            }
        }



        /*$languageses = $json->{'id_language'};
        $id_user = $json->{'id_user'};
        $teachOrLearn = $json->{'teachOrLearn'};

        $values = "";

        $jH = explode(',', $languageses);
        for ($i=0; $i < count($jH); $i++) {
            if ( $jH[$i] == end($jH))
            {
                $values .= "('".$id_user."', '".$jH[$i]."', '".$teachOrLearn."');";
            }
            else
            {
                $values .= "('".$id_user."', '".$jH[$i]."', '".$teachOrLearn."'),";
            }
        }*/

        $query = "REPLACE INTO user_language (`id_user`, `id_language`,`teachOrLearn`) VALUES ".$values;

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
                "message" => "Data accepted but updating failed with the following error: ".$errorOut. " ::End::"
            );

            $this->out = json_encode($array);
        }

    }


}

?>