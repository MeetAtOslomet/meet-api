<?php

    class user_language
    {
        public $id_user;
        public $id_language;
        public $teachOrLearn;
        public $name;

        function __construct($id_user, $id_language, $teachOrLearn, $name)
        {
            $this->id_user = $id_user;
            $this->id_language = $id_language;
            $this->teachOrLearn = $teachOrLearn;
            $this->name = (isset($name) ? $name : "");
        }
    }


?>