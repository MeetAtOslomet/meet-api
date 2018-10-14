<?php

    class heartbeat
    {
        private $db;
        private $json;
        private $timestamp;

        function __construct($db)
        {
            if ($db != null)
            {
                $this->db = $db;
            }

            $d = new DateTime();
            $this->timestamp = $d->getTimestamp(); 
        }
        
        function getJson()
        {
            $status = false;
            if ($this->db == true)
            {
                $status = true;
            }

            $array = array(
                "status" => $status,
                "timestamp" => $this->timestamp
            );
            return json_encode($array);
        }


    }


?>