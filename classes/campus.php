<?php

    class campus
    {
        public $id_campus;
        public $name;

        function __construct($id_campus, $name)
        {
            $this->id_campus = $id_campus;
            $this->name = $name;
        }
    }


?>