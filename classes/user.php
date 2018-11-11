<?php

    class user 
    {
        public $id_user;
        public $username; #required
        public $first_name; #required
        public $last_name;
        public $hide_last_name; #defaults to true
        public $type; #required
        public $gender; 
        public $age; #required
        public $hide_age; #defaults to true
        public $id_campus; #required
        public $biography; #defaults to empty

        function __construct($username, $first_name, $last_name, $hide_last_name, $type, $gender, $age, $hide_age, $id_campus, $biography)
        {
            $this->username = $username;
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->hide_last_name = $hide_last_name;
            $this->type = $type;
            $this->gender = $gender;
            $this->age = $age;
            $this->hide_age = $hide_age;
            $this->id_campus = $id_campus;
            $this->biography = $biography;

            if (empty($this->last_name) && is_null($this->last_name))
            {
                $this->last_name = "";
            }
            if (empty($this->hide_last_name) && is_null($this->hide_last_name))
            {
                $this->hide_last_name = true;
            }
            if (empty($this->gender) || is_null($this->gender))
            {
                $this->gender = -1;
            }
            if (empty($this->hide_age) && is_null($this->hide_age))
            {
                $this->hide_age = true;
            }
            if (empty($this->biography) && is_null($this->biography))
            {
                $this->biography = "";
            }

        }

        function hasRequiredValues()
        {
            if (!empty($this->username) &&
                !empty($this->first_name) && 
                is_numeric($this->type) && 
                !empty($this->age) &&
                is_numeric($this->id_campus))
            {
                return true;
            }
            else
            {
                return false;
            }

        }

        function getFilteredUser_JSON()
        {
            $array = array(
                "username" => $this->username,
                "first_name" => $this->first_name,
                "type" => $this->type,
                "gender" => $this->gender,
                "id_campus" => $this->id_campus,
                "biographgy" => $this->biography
            );

            if ($this->hide_last_name == false)
            {
                $array["last_name"] = $this->last_name;
            }
            if ($this->hide_age == false)
            {
                $array["age"] = $this->age;
            }
            $out = json_encode($array);
            return $out;
        }

        function getFilteredUser_Array()
        {
            $array = array(
                "username" => $this->username,
                "first_name" => $this->first_name,
                "type" => $this->type,
                "gender" => $this->gender,
                "id_campus" => $this->id_campus,
                "biographgy" => $this->biography
            );

            if ($this->hide_last_name == false)
            {
                $array["last_name"] = $this->last_name;
            }
            if ($this->hide_age == false)
            {
                $array["age"] = $this->age;
            }
            return $array;
        }



    }


?>