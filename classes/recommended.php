<?php

require_once './classes/user.php';
require_once './classes/user_language.php';
require_once './classes/user_hobbies.php';

    class recommended
    {

        public $user;
        public $languages;
        public $hobbies; 

        function __construct($user)
        {
            $this->user = $user;
            $this->languages = array();
            $this->hobbies = array();
        }

        function addLanguage($language)
        {
            array_push($this->languages, $language);
        }

        function addHobby($hobby)
        {
            array_push($this->hobbies, $hobby);
        }

    }


?>