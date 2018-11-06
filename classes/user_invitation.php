<?php

class user_invitation
{
    public $id_userSend;
    public $id_userMatch;
    public $requestState;
    public $name;


    function __construct($id_user, $id_userMatch, $requestState, $name)
    {
        $this->id_userSend = $id_user;
        $this->id_userMatch = $id_userMatch;
        $this->requestState = $requestState;
        $this->name = (isset($name) ? $name : "");
    }
}