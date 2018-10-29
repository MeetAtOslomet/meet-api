<?php
    class language
    {
        public $id_language;
        public $name;

        function __construct($id_language, $name)
        {
            $this->id_language = $id_language;
            $this->name = $name;
        }
    }


?>