<?php
    class language
    {
        public $id_language;
        public $name;
        public $teachOrLearn;
        function __construct($id_language, $name, $teachOrLearn)
        {
            $this->id_language = $id_language;
            $this->name = $name;
            $this->teachOrLearn= $teachOrLearn;
        }
    }


?>