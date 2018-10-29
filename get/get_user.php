<?php
    require './classes/user.php';

    class get_user
    {
        public $db;
        public $out;

        function __construct($db, $data)
        {
            $res = mysqli_query($db, "SELECT * FROM user WHERE id_user='".$data."';");
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
                $this->out = $user->getFilteredUser_JSON();
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