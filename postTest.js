var jq = document.createElement('script');
jq.src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js";
document.getElementsByTagName('head')[0].appendChild(jq);
// ... give time for script to load, then type (or see below for non wait option)
jQuery.noConflict();



var hash = "c0aba0c3f3fdc55050e59b7eb596605d000d41e0625328b7e87c65336b000a15";

var obj = {
    username: "Admin",
    password: hash,
    type: "Student"
};

var jData = JSON.stringify(obj);


$.ajax({
    type : 'POST',
    url : "http://meet.vlab.cs.hioa.no/api.php",
    data : {
        request: "register_user",
        data: jData
    },
    success: function(data)
    {
        console.log(data);
        alert(data);
    },
    failure: function(errMsg)
    {
        console.error(errMsg);
        alert(errMsg);
    }
 
});