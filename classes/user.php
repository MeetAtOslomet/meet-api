<?php

    class user 
    {
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

            if (empty($this->last_name) || !isset($this->last_name))
            {
                $this->last_name = "";
            }
            if (empty($this->hide_last_name) || !isset($this->hide_last_name))
            {
                $this->hide_last_name = true;
            }
            if (empty($this->gender) || !isset($this->gender))
            {
                $this->gender = -1;
            }
            if (empty($this->hide_age) || !isset($this->hide_age))
            {
                $this->hide_age = true;
            }
            if (empty($this->biography) || !isset($this->biography))
            {
                $this->biography = "";
            }

        }

        function hasRequiredValues()
        {
            if (!empty($this->username) &&
                !empty($this->first_name) && 
                !empty($this->type) && 
                !empty($this->age) &&
                !empty($this->id_campus))
            {
                return true;
            }
            else
            {
                return false;
            }

        }

    }


?>