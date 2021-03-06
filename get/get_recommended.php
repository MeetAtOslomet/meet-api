<?php

    require_once './classes/user.php';
    require_once './classes/user_language.php';
    require_once './classes/user_hobbies.php';
    require './classes/recommended.php';

    class get_recommended
    {
        public $db;
        public $id_user;
        public $out;

        function __construct($db, $data)
        {
            $this->db = $db;
            $status = ($db == true) ? true : false;
            $json = json_decode($data);
            $id_user = $json->{'id_user'};
            $username = $json->{'username'};
            $this->id_user = $id_user;

            if (!empty($id_user) && !empty($username))
            {
                $langauge = $this->getWantToLearn();
                $hobbies = $this->getMyHobbies();

                if (!empty($langauge))
                {
                    $result = $this->getRecommended($langauge, $hobbies);
                    $this->out = $result;
                }
                else
                {
                    $array = array(
                        "status" => $status,
                        "data" => "failure",
                        "dataExit" => 1,
                        "message" => "Data retrieved but user has not comply with required data"
                    );
    
                    $this->out = json_encode($array);
                }
                
            }





        }

        function getWantToLearn()
        {
            $result = mysqli_query($this->db, "SELECT l.id_language FROM user AS u 
                INNER JOIN ( SELECT ul.*, l.name FROM user_language AS ul 
                INNER JOIN language AS l ON ul.id_language = l.id_language) AS l ON u.id_user = l.id_user 
                WHERE u.id_user = ".$this->id_user." ;");

            $langId = array();
            while ($row = mysqli_fetch_array($result))
            {
                array_push($langId, $row['id_language']);
            }
            $langStr = "";
            for ($i=0; $i < count($langId); $i++) { 
                if (end($langId) == $langId[$i])
                {
                    $langStr .= $langId[$i];
                }
                else
                {
                    $langStr .= $langId[$i].",";
                }
            }
            return $langStr;
        }

        function getMyHobbies()
        {
            $result = mysqli_query($this->db, "SELECT uh.id_hobbies FROM user_hobbies as uh 
            INNER JOIN hobbies as h ON h.id_hobbies = uh.id_hobbies 
            WHERE uh.id_user = ".$this->id_user.";");

            $hobbId = array();
            while ($row = mysqli_fetch_array($result))
            {
                array_push($hobbId, $row['id_hobbies']);
            }

            $hobbyStr = "";
            for ($i=0; $i < count($hobbId); $i++) { 
                if (end($hobbId) == $hobbId[$i])
                {
                    $hobbyStr .= $hobbId[$i];
                }
                else
                {
                    $hobbyStr .= $hobbId[$i].",";
                }
            }
            return $hobbyStr;

        }



        function getRecommended($langStr, $hobbyStr)
        {
            $query = "SELECT u.*, l.id_language, l.lname, l.teachOrLearn, h.id_hobbies, h.name FROM user AS u 
            INNER JOIN ( SELECT ul.*, l.name AS lname FROM user_language AS ul 
                INNER JOIN language AS l ON ul.id_language = l.id_language ) AS l ON u.id_user = l.id_user 
            LEFT JOIN ( SELECT uh.*, h.name FROM user_hobbies AS uh 
                INNER JOIN hobbies AS h ON uh.id_hobbies = h.id_hobbies WHERE uh.id_hobbies IN (".$hobbyStr.") ) AS h ON u.id_user = h.id_user  
            LEFT JOIN ( SELECT * FROM match_request WHERE id_userSend = ".$this->id_user." OR id_userMatch = ".$this->id_user.") AS mr
            	ON (u.id_user = mr.id_userSend OR u.id_user = mr.id_userMatch)
            WHERE l.id_language IN (".$langStr.") AND (mr.requestState = 0 OR mr.requestState IS NULL ) AND u.id_user !=".$this->id_user.";";

            $user = array();
            $language = array();
            $hobbies = array();

            $result = mysqli_query($this->db, $query);
            while ($row = mysqli_fetch_array($result))
            {
                $usr = new user(
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
                $usr->id_user = $row['id_user'];
                if ($this->checkIfUserIsPresent($user, $usr) == false)
                {
                    array_push($user, $usr);
                }

                $lang = new user_language(
                    $row['id_user'],
                    $row['id_language'],
                    $row['teachOrLearn'],
                    $row['lname']
                );
                if ($this->checkIfLanguageIsPresent($language, $lang) == false)
                {
                    array_push($language, $lang);
                }
                

                $hobby = new user_hobbies(
                    $row['id_user'],
                    $row['id_hobbies'],
                    $row['name']
                );
                if ($this->checkIfHobbyIsPresent($hobbies, $hobby) == false)
                {
                    array_push($hobbies, $hobby);
                }
                
            }
            
            $recommend = array();

            for ($i=0; $i < count($user); $i++) { 
                # code...
                $rec = new recommended($user[$i]);
                for ($x=0; $x < count($language); $x++) { 
                    if ($language[$x]->id_user == $user[$i]->id_user)
                    {
                        $rec->addLanguage($language[$x]);
                    }
                }
                for ($x=0; $x < count($hobbies); $x++) { 
                    if ($hobbies[$x]->id_user == $user[$i]->id_user)
                    {
                        $hob = $hobbies[$x];
                        $rec->addHobby($hob);
                    }
                }
                array_push($recommend, $rec);
            }

            $toRemove = array();
            $getMatched = mysqli_query($this->db, "SELECT * FROM match_request WHERE (id_userSend = ".$this->id_user." OR id_userMatch = ".$this->id_user.") AND requestState = 1;");
            while ($row = mysqli_fetch_array($getMatched))
            {
                $Suid = $row['id_userSend'];
                $Muid = $row['id_userMatch'];
                
                if (!in_array($Suid, $toRemove))
                {
                    array_push($toRemove, $Suid);
                }
                if (!in_array($Muid, $toRemove))
                {
                    array_push($toRemove, $Muid);
                }
            }

            $newRecommend = array();
            for ($i = 0; $i < count($recommend); $i++)
            {
                $_user = $recommend[$i]->user;
                $userId = $_user->id_user;
                if (!in_array($userId, $toRemove))
                {
                    array_push($newRecommend, $recommend[$i]);
                }
            }            



            $recOut = array(
                "status" => true,
                "data" => $newRecommend
            );

            $json = json_encode($recOut);
            return $json;


        }

        function checkIfUserIsPresent($array, $user)
        {
            for ($i = 0; $i < count($array); $i++)
            {
                if ($array[$i]->id_user == $user->id_user)
                {
                    return true;
                }
            }
            return false;
        }

        function checkIfLanguageIsPresent($array, $language)
        {
            foreach($array as $item)
            {
                if ($item->id_user == $language->id_user && $item->id_language == $language->id_language)
                {
                    return true;
                }
            }
            return false;
        }

        function checkIfHobbyIsPresent($array, $hobby)
        {
            foreach ($array as $item)
            {
                if ($item->id_user == $hobby->id_user && $item->id_hobbies == $hobby->id_hobbies)
                {
                    return true;
                }
            }
            return false;
        }

    }


?>