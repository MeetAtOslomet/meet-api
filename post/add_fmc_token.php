<?php

class add_fmc_token
{
    public $out;
    function __construct($db, $data)
    {
        $status = ($db == true) ? true : false;

        $json = json_decode($data);
        $username = $json->{"username"};
        $fmcToken = $json->{"fmcToken"};
        $authToken = $json->{"authenticationToken"};
        $er = var_dump($json);
        if (empty($username) || empty($fmcToken) || empty($authToken))
        {
            $array = array(
                "status" => $status,
                "data" => "denied",
                "dataExit" => 2,
                "message" => "Data received did not contain the required fields, please verify the json data",
                "debug" => $er
            );
            $this->out = json_encode($array);
            return;
        }

        mysqli_query($db, "REPLACE INTO push_users (`username`, `fmcToken`) VALUES ('".$username."', '".$fmcToken."');");
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