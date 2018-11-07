<?php
/**
 * Created by IntelliJ IDEA.
 * User: ANRIEU Quentin
 * Date: 07/11/2018
 * Time: 13:54
 */

class user_meeting
{
    public $id_user;
    public $id_userSend;
    public $requestState;
    public $name;
    public $place;
    public $dtime;
    public $meetingMessage;


    function __construct($id_user, $id_userSend, $requestState, $name, $place,  $dtime, $meetingMessage)
    {
        $this->id_user = $id_user;
        $this->id_userSend = $id_userSend;
        $this->requestState = $requestState;
        $this->name = (isset($name) ? $name : "");
        $this->place= $place;
        $this->dtime = $dtime;
        $this->meetingMessage = (isset($meetingMessage) ? $meetingMessage:"");
    }
}