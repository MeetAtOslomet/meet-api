<?php

class push
{
    public $db;
    public $server_key;
    public $out;
    function __construct($db, $server_key, $data)
    {
        $this->server_key = $server_key;
        
        $this->db = $db;
        $json = json_decode($data);
        $username = $json->{"username"};
        $type = $json->{"type"};

        $devToken = $this->GetDeviceToken($username);
        if ($devToken != false)
        {
            if ($type == "notification")
            {

            }
            else if ($type == "data")
            {
                $dataPayload = $json->{"data"};
                $payload = array(
                    "to" => $devToken,
                    "notification" => array(
                        "title" => "Api Push",
                        "body" => "Push from Api server",
                        "icon" => "ic_launcher"
                    ),
                    "data" => array(
                        "data" => $dataPayload
                    )
                );
                $this->out = var_dump($payload);
                $jsonPayLoad = json_encode($payload);
                $this->out .= $this->SendPushData($jsonPayLoad);

            }
        }
    }

    function GetDeviceToken($username)
    {
        if (!isset($username))
        {
            return false;
        }
        
        $res = mysqli_query($this->db, "SELECT * FROM push_users WHERE username='".$username."';");
        if (mysqli_num_rows($res) == 1)
        {
            $dat = mysqli_fetch_assoc($res);
            $devToken = $dat['fmcToken'];
            return $devToken;
        }

    }

    function SendPushData($json)
    {
        if (!isset($this->server_key))
        {
            $array = array(
                "data" => "denied",
                "dataExit" => 2,
                "message" => "Data received did not contain the required fields, please verify the json data"
            );
            $this->out = json_encode($array);
        }

        $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = array(
            'Content-Type:application/json',
            'Authorization: key='.$this->server_key
        );


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $result = curl_exec($ch);
        $this->out = var_dump($result);
        if ($result === FALSE)
        {
            $array = array(
                "data" => "failure",
                "dataExit" => 1,
                "message" => "FCM sending error: ".curl_error($ch)
            );

            $this->out = json_encode($array);
        }
        else
        {
            $array = array(
                "data" => "success",
                "dataExit" => 0,
                "message" => "Data uploaded and updated successfully"
            );
            $this->out = json_encode($array);
        }
        curl_close($ch);
    }


}


?>