<?php

class user_invitation
{

    public $id_user;
    public $id_userSend;
    public $requestState;
    public $name;


    function __construct($id_user, $id_userSend, $requestState, $name)
    {
        $this->id_user = $id_user;
        $this->id_userSend = $id_userSend;
        $this->requestState = $requestState;
        $this->name = (isset($name) ? $name : "");
    }
}