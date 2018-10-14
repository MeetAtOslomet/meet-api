<?php

    class heartbeat
    {
        private $json;
        private $timestamp;

        function __construct()
        {
            $d = new DateTime();
            $this->timestamp = $d->getTimestamp(); 
        }
        
        function getJson()
        {
            $array = array(
                "status" => true,
                "timestamp" => $this->timestamp
            );
            return json_encode($array);
        }


    }


?>