<?php
    require './classes/user.php';

    class get_me
    {
        public $db;
        public $out;

        function __construct($db, $data)
        {
            $json = json_decode($data);
            $id_user = $json->{'id_user'};
            $authenticationToken = $json->{'authenticationToken'};
            $res = mysqli_query($db, "SELECT * FROM user WHERE id_user='".$id_user."';");
            if (mysqli_num_rows($res)== 1)
            {
                $sqlData = mysqli_fetch_assoc($res);
                $user = new user(
                    $sqlData['username'],
                    $sqlData['first_name'],
                    $sqlData['last_name'],
                    $sqlData['hide_last_name'],
                    $sqlData['type'],
                    $sqlData['gender'],
                    $sqlData['age'],
                    $sqlData['hide_age'],
                    $sqlData['id_campus'],
                    $sqlData['biography']
                );

               // echo "SELECT * FROM auth_users WHERE username='".$sqlData['username']."' AND token = '".$authenticationToken."';";
                $isAuthUser = mysqli_query($db, "SELECT * FROM auth_users WHERE username='".$sqlData['username']."' AND token = '".$authenticationToken."';");
                if (mysqli_num_rows($isAuthUser)== 1)
                {
                    $this->out = json_encode($user);
                }

                
            }
            else
            {
                $array = array(
                    "status" => $status,
                    "data" => "failure",
                    "dataExit" => 1,
                    "message" => "Data accepted but receiving failed: ".$errorOut. " ::End::"
                );

                $this->out = json_encode($array);
            }

        }
    }

?>