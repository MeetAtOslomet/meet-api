<?php
/**
 * Created by IntelliJ IDEA.
 * User: ANRIEU Quentin
 * Date: 07/11/2018
 * Time: 21:05
 */

class tandem
{
    public $id_tandem;
    public $id_user1;
    public $id_user2;
    public $conversationName;
    public $name;
    public $lastname;

    function __construct($id_tandem, $id_user1, $id_user2, $conversationName)
    {
        $this->id_tandem = $id_tandem;
        $this->id_user1 = $id_user1;
        $this->id_user2 = $id_user2;
        $this->conversationName =(isset($conversationName) ? $conversationName : "");
    }
}