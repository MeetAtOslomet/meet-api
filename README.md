# meet-api

| Methods | Supported |
| --- | --- |
| POST | yes |
| GET | yes |

## Requests
| GET | Implemented | requires key | Details |
| --- | --- | --- | --- |
| heartbeat | yes | no | status will be **false** if a connection to the designated database could not be established |

**NOTE** Query name should allways be in lowercase <br />
Example usage http://meet.vlab.cs.hioa.no/api.php?request=heartbeat <br />
Url rewrite will probably be added at a later occasion

| POST | Implemented | requires key | details |
| --- | --- | --- | --- |
| register_user | yes | no | checks if user is present, if not user will be added |
| login_user | yes | no | returns key for verification |



**NOTE**

Database connections should not be and will not be present in the repo
Connection file exists only on server and is only simple mysqli connection