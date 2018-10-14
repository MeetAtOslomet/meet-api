# meet-api

| Methods | Supported |
| --- | --- |
| POST | yes |
| GET | yes |

## Requests
| GET | Implemented | Details |
| --- | --- |
| Heartbeat | yes | status will be **false** if a connection to the designated database could not be established |

**NOTE** Query name should allways be in lowercase <br />
Example usage http://meet.vlab.cs.hioa.no/api.php?request=heartbeat <br />
Url rewrite will probably be added at a later occasion

| POST | Implemented |
| --- | --- |
| N/A | N/A |



**NOTE**

Database connections should not be and will not be present in the repo
Connection file exists only on server and is only simple mysqli connection