<?php
    class hobbies
    {
        public $id_hobbies;
        public $name;

        function __construct($id_hobbies, $name)
        {
            $this->id_hobbies = $id_hobbies;
            $this->name = $name;
        }
    }


?>