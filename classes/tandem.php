<?php
/**
 * Created by IntelliJ IDEA.
 * User: ANRIEU Quentin
 * Date: 07/11/2018
 * Time: 21:05
 */

class tandem
{
    public $id_user;
    public $id_user2;
    public $conversationName;
    public $name;
    public $lastname;

    function __construct($id_user, $id_user2, $conversationName, $name, $lastname)
    {
        $this->id_user = $id_user;
        $this->id_user2 = $id_user2;
        $this->conversationName =(isset($conversationName) ? $conversationName : "");
        $this->name = $name;
        $this->lastname = $lastname;
    }
}