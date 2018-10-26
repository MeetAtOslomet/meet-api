# meet-api

## Requires HTTPS

| Methods | Supported |
| --- | --- |
| POST | yes |
| GET | yes |

## Requests
| GET | Implemented | Requires key | Details |
| --- | --- | --- | --- |
| heartbeat | yes | no | status will be **false** if a connection to the designated database could not be established |

**NOTE** Query name should allways be in lowercase <br />
Example usage https://meet.vlab.cs.hioa.no/api.php?request=heartbeat <br />
Url rewrite will probably be added at a later occasion

| POST | Implemented | Requires key* | Details |
| --- | --- | --- | --- |
| register_user | yes | no | checks if user is present, if not user will be added |
| login_user | yes | no | returns key for verification |
| auth_check | yes | yes | checks if key provided is valid |
| activate_user | no | checks if key corresponds with key stored |
| initPass_user | yes | Sets first time password |

*Requires key
Authentication key is required to perform this type of request
This is passed as a post parameter with the name = authenticationToken
Requests that fails to provide a valid token will be rejected with a status message



**NOTE**

Database connections should not be and will not be present in the repo
Connection file exists only on server and is only simple mysqli connection