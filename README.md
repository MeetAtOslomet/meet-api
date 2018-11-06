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
| add_language | yes | yes | Does not check if the entry exists and will throw error if field exists |*


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



*Requires key
Authentication key is required to perform this type of request
This is passed as a post parameter with the name = authenticationToken
Requests that fails to provide a valid token will be rejected with a status message



**NOTE**

Database connections should not be and will not be present in the repo
Connection file exists only on server and is only simple mysqli connection


Jenkins