<?php

class messaging
{
    public $id_message;
    public $id_userSend;
    public $id_userReceive;
    public $id_tandem;
    public $dtime;
    public $viewMessage;
    public $message;

    function __construct($id_message, $id_userSend, $id_userReceive, $id_tandem, $dtime, $viewMessage, $message)
    {
        $this->id_message = $id_message;
        $this->id_userSend = $id_userSend;
        $this->id_userReceive = $id_userReceive;
        $this->id_tandem = $id_tandem;
        $this->dtime = $dtime;
        $this->viewMessage = $viewMessage;
        $this->message = $message;
    }


}




?>