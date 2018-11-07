<?php

class user_invitation
{
    public $id_userSend;
    public $id_userMatch;
    public $requestState;
    public $name;


    function __construct($id_user, $id_userSend, $requestState, $name)
    {
        $this->id_userMatch = $id_user;
        $this->id_userSend = $id_userSend;
        $this->requestState = $requestState;
        $this->name = (isset($name) ? $name : "");
    }
}