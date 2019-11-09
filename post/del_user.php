<?php
require './classes/user.php';

class del_user
{
    public $db;
    public $status;
    public $out = null;
    public $user;
    public $user_id;


    private $qerror = array();
    function __construct($db, $data)
    {
        $this->status = ($db == true) ? true : false;
        $this->db = $db;
        $json = json_decode($data);
        $id_user = $json->{'id_user'};

        $this->user_id = $id_user;
        $this->user = $this->aquireRequiredData($id_user);

        if ($this->out != null)
        {  return; }

        /**
         * Running deletion
         */

        $this->removeFromHobbies($this->user_id);
        $this->removeFromLanguages($this->user_id);
        $this->removeFromMessages($this->user_id);
        $this->removeFromTandem($this->user_id);
        $this->removeFromTandemRequest($this->user_id);
        $this->removeFromMeetingRequest($this->user_id);
        $this->removeFromMeeting($this->user_id);

        

        $this->deleteUser($this->user_id);

        //$this->out = json_encode($this->qerror);
        $this->writeOutput();
    }

    function aquireRequiredData($uid)
    {
        $q = "SELECT * FROM user WHERE id_user = '".$uid."';";
        //$this->out = $q;
        //return;
        $res = mysqli_query($this->db, $q);
        if (mysqli_num_rows($res)== 1)
        {
            $sqlData = mysqli_fetch_assoc($res);
            $user = new user(
                $sqlData['username'],
                $sqlData['first_name'],
                $sqlData['last_name'],
                $sqlData['hide_last_name'],
                $sqlData['type'],
                $sqlData['gender'],
                $sqlData['age'],
                $sqlData['hide_age'],
                $sqlData['id_campus'],
                $sqlData['biography']
            );
            return $user;
        }
        else
        {
            $this->writeFailure(__FUNCTION__);
        }


    }


    function writeOutput()
    {        
        $array = array(
            "status" => $this->status,
            "data" => ((count($this->qerror) == 0) ? "success" : "error"),
            "dataExit" => 0,
            "message" => ((count($this->qerror) == 0) ? "User completely deleted from system" : "Something unexpected occured while deleting user, see error data"),
        );
        if (count($this->qerror) == 0)
        {
            $array["dataError"] = $this->qerror;
        }

        $array["userId"] = $this->user_id;
        $array["user"] = $this->user;

        $this->out = json_encode($array);
    }


    function writeFailure($called)
    {
        $array = array(
            "status" => $this->status,
            "data" => "failure",
            "dataExit" => 1,
            "sqlError" => mysqli_error($this->db),
            "message" => "An error occured while performing an request to the database"
        );
        $array["userId"] = $this->user_id;
        $array["user"] = $this->user;

        $this->out = json_encode($array);
    }


    function hasError($caller, $query)
    {
        $error = mysqli_error($this->db);
        $errorOut = (string)$error;
        if ($query == false && $error != null && strlen($errorOut) > 0)
        {
            $obj = new stdclass();
            $obj->caller = $caller;
            $obj->error = $error;
            array_push($this->qerror, $obj);
        }
    }


    /**
     * Removing users preferences
     */
    function removeFromHobbies($uid)
    {
        $q = "DELETE FROM user_hobbies WHERE id_user = '".$uid."';";
        $run = mysqli_query($this->db, $q);
        $this->hasError(__FUNCTION__, $q);
    }

    function removeFromLanguages($uid)
    {
        $q = "DELETE FROM user_language WHERE id_user = '".$uid."';";
        $run = mysqli_query($this->db, $q);
        $this->hasError(__FUNCTION__, $q);
    }

    /**
     * Removing arrangements or tandem where usier is present
     */
    function removeFromTandem($uid)
    {
        $q = "DELETE FROM tandem WHERE id_user1 = '".$uid."' OR id_user2 = '".$uid."';";
        $run = mysqli_query($this->db, $q);
        $this->hasError(__FUNCTION__, $q);
    }

    function removeFromTandemRequest($uid)
    {
        $q = "DELETE FROM match_request WHERE id_userSend = '".$uid."' OR id_userMatch = '".$uid."';";
        $run = mysqli_query($this->db, $q);
        $this->hasError(__FUNCTION__, $q);
    }


    function removeFromMeetingRequest($uid)
    {
        $q = "DELETE FROM meeting_request WHERE id_userSend = '".$uid."' OR id_userReceive = '".$uid."';";
        $run = mysqli_query($this->db, $q);
        $this->hasError(__FUNCTION__, $q);
    }

    function removeFromMeeting($uid)
    {
        $q = "DELETE FROM meeting WHERE id_user1 = '".$uid."' OR id_user2 = '".$uid."';";
        $run = mysqli_query($this->db, $q);
        $this->hasError(__FUNCTION__, $q);
    }




    /**
     * DELETION OF CHAT
     * If this should be preserved, please comment out the call
     */
    function removeFromMessages($uid)
    {
        $q = "DELETE FROM send_message WHERE id_userSend = '".$uid."' OR id_userReceive = '".$uid."';";
        $run = mysqli_query($this->db, $q);
        $this->hasError(__FUNCTION__, $q);
    }


    /** This function has to be called last */
    function deleteUser($uid)
    {
        // Id in this table is NOT the same id as in the user table 
        $q1 = "DELETE FROM auth_users WHERE username = '".$this->user->username."';";

        // Deletes the users activation key
        $q2 = "DELETE FROM activation_key WHERE username = '".$this->user->username."';";

        // Deletes the user FMC token (For Push notifications)
        $q3 = "DELETE FROM push_users WHERE username = '".$this->user->username."';";

        // Deletes the user entry
        $q4 = "DELETE FROM User WHERE id_user = '".$uid."';";

        $run1 = mysqli_query($this->db, $q1);
        $this->hasError(__FUNCTION__, $q1);

        $run2 = mysqli_query($this->db, $q2);
        $this->hasError(__FUNCTION__, $q2);

        $run3 = mysqli_query($this->db, $q3);
        $this->hasError(__FUNCTION__, $q3);

        $run4 = mysqli_query($this->db, $q4);
        $this->hasError(__FUNCTION__, $q4);
    }

/*

Test Query

SELECT * FROM auth_users WHERE username = "s326311";
SELECT * FROM user WHERE username = "s326311" OR id_user = 23;
SELECT * FROM match_request WHERE id_userSend = 23 OR id_userMatch = 23;
SELECT * FROM meeting WHERE id_user1 = 23 OR id_user2 = 23;
SELECT * FROM meeting_request WHERE id_userSend = 23 OR id_userReceive = 23;
SELECT * FROM push_users WHERE username = "s326311";
SELECT * FROM send_message WHERE id_userSend = 23 OR id_userReceive = 23;
SELECT * FROM tandem WHERE id_user1 = 23 OR id_user2 = 23;
SELECT * FROM user_hobbies WHERe id_user = 23;
SELECT * FROM user_language WHERE id_user = 23;

*/
    

}


?>