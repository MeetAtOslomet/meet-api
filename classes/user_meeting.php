<?php
/**
 * Created by IntelliJ IDEA.
 * User: ANRIEU Quentin
 * Date: 07/11/2018
 * Time: 13:54
 */

class user_meeting
{
    public $id_userSend;
    public $id_userReceive;
    public $requestState;
    public $name;
    public $dtime;
    public $meetingMessage;


    function __construct($id_user, $id_userSend, $requestState, $name, $dtime, $meetingMessage)
    {
        $this->id_userReceive = $id_user;
        $this->id_userSend = $id_userSend;
        $this->requestState = $requestState;
        $this->name = (isset($name) ? $name : "");
        $this->dtime = $dtime;
        $this->meetingMessage = (isset($meetingMessage) ? $meetingMessage:"");
    }
}