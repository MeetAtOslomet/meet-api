<?php

    class user_hobbies
    {
        public $id_user;
        public $id_hobbies;
        public $name;

        function __construct($id_user, $id_hobbies, $name)
        {
            $this->id_user = $id_user;
            $this->id_hobbies = $id_hobbies;
            $this->name = (isset($name) ? $name : "");
        }
    }

?>