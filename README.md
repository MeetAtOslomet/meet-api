# meet-api

## Requires HTTPS

| Methods | Supported |
| --- | --- |
| POST | yes |
| GET | yes |

## Requests
| GET | Implemented | Requires key* | Details |
| --- | --- | --- | --- |
| heartbeat | yes | no | status will be **false** if a connection to the designated database could not be established |
| get_user | yes | yes | Gets user based on username or user id |
| get_hobbies | yes | no | Gets hobbies based on input, supports single number and multiple values like this "1,2,3,4" |
| get_language | yes | no | Gets language based on input, supports single number and multiple values like this "1,2,3,4" |
| get_user_language | yes | no | returns language details for user |
| get_user_hobbies | yes | no | returns hobbies for user |
| get_user_invitation | yes | no | returns tandem invitation receive by the user |
| get_user_meeting | yes | no | returns meeting invitations receive by the user |
| get_my_tandem | yes | no | returns tandem list for one user |
| receive_message | yes | yes | Once called view state will switch to viewed |


**NOTE** Query name should allways be in lowercase <br />
Example usage https://meet.vlab.cs.hioa.no/api.php?request=heartbeat <br />
Url rewrite will probably be added at a later occasion

| POST | Implemented | Requires key* | Details |
| --- | --- | --- | --- |
| register_user | yes | no | checks if user is present, if not user will be added |
| login_user | yes | no | returns key for verification |
| auth_check | yes | yes | checks if key provided is valid |
| activate_user | yes | no | checks if key corresponds with key stored |
| initPass_user | yes | yes | Sets first time password |
| add_user | yes | yes | JSON data provied needs to comply with required database fields |
| add_hobbies | yes | yes | Does not check if the entry exists and will throw error if field exists |
| add_language | yes | yes | Does not check if the entry exists and will throw error if field exists |
| set_like | yes | yes | Does not check if the entry exists and will throw error if field exists, send tandem invitation and change is state if the invitation already exist  |
| set_meet | yes | yes | Does not check if the entry exists and will throw error if field exists, send meeting invitation and change is state if the invitation already exist |*
| send_message | yes | yes | Controls details and sends message |
| delete_hobbies | yes | yes | Can delete individual entries or batch delete |
| delete_langauges | yes | yes | Only one entry, if language contains teach and learn you will have to provide 1 as teachOrLearn to set it to 0, and 0 to set it to 1 |
| delete_user | yes | yes | |


| POST | Fields | Required | 
| --- | --- | --- |
| add_user |  |  |
|  | username | yes |
|  | first_name | yes |
|  | last_name | no |
|  | hide_last_name | no |
|  | type | yes |
|  | gender | yes |
|  | age | yes |
|  | hide_age | no |
|  | id_campus | yes |
|  | biography | no |
| add_hobbies | | |
|  | id_user | yes |
|  | id_hobbies | yes |
| add_language | | |
|  | id_user | yes |
|  | id_language | yes |
|  | teachOrLearn | yes |
| get_user_language | | |
|  | id_user | yes |
| get_user_hobbies |  |  |
|  | id_user | yes |
| set_like |  |  |
|  | id_userSend | yes |
|  | id_userMatch | yes |
| set_meet |  |  |
|  | id_userSend | yes |
|  | id_userReceive | yes |
|  | place | no |
|  | dtime | yes |
|  | meetingMessage | no |
|  | requestState | yes |
| send_message |    |   |
|  | id_userSend | yes |
|  | id_userReceive | yes |
|  | id_tandem | yes |
|  | authenticationToken | yes |
|  | message | yes |
| delete_user|     |   |
|  | authenticationToken | yes |
|  | id_user | yes |
| delete_language|  |   |
|  | id_user | yes  |
|  | id_language | yes |
|  | teachOrLearn | no |

| GET | Fields | Required | Comment |
| --- | --- | --- | --- |
| get_recommended |     |    |      |
|     | request | yes | needs to be "get_recommended" |
|     | authenticationToken | yes | will be rejected if not provided |
|     | data | yes | needs to be a json object with "id_user" and "username" |
| receive_message |     |    |      |
|     | id_tandem | yes |    |
|     | id_user   | yes |    |
|     | authenticationToken | yes |




*Requires key
Authentication key is required to perform this type of request
This is passed as a post parameter with the name = authenticationToken
Requests that fails to provide a valid token will be rejected with a status message

*NOTE* Partially apiTester <br />
Example usage https://meet.vlab.cs.hioa.no/apiTest.html <br />




**NOTE**
api.php Includes the following:
db.php
key.php

The purpose of key.php is to keep the secrets for firebase.
The purpose of db.php is to create the database connection.

Changning valus for Key.php is required to change ownership and control over notifications etc.
No other changes are required other than chaning keys in key.php. The rest is dynamic

Database connections file should not be and will not be present in the repo 


Skeleton of db.php
```PHP
<?php
$Server = "undefined";
$Usr = "undefined";
$Pwd = "undefined";
$DB = "undefined";

$db = mysqli_connect($Server, $Usr, $Pwd, $DB);

if ($db == false)
{
    echo "Connection failed";
    die(print_r (mysqli_errors(), true));
}

?>

```

Skeleton of key.php
```PHP
<?php
    $secret = "Firebase secret";
    $fmcKey = "Firebase cloud messaging key";
    $GLOBALS['fcmKey'] = $fcmKey;
?>

```
