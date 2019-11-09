"use strict";
/**
 * How to call:
 * - Calling function has to be of type async function
 * - Recieving variable has to be of type const, along with calling await get(<url>)
 * 
 * Returning data is type of JSON
 * @param {API url} _url 
 */
async function get(_url)
{
    let result = null;
    console.log("Calling Api");
    /// Perform Api Request
    try
    {
        let response = await $.ajax({
            type : 'GET',
            url : _url
        });
        result = JSON.parse(response);
        return result;
    }
    catch (error)
    {
        console.error(_url);
        console.log(error);
    }
}


/**
 * param:
 * - post | required
 * - data | required
 * 
 * @param {Api Url} _url 
 * @param {Object with desired paramters for api} param 
 */
async function post(_url, param)
{
    let result = null;
    console.log("Post param");
    console.log(param);
    console.log("Calling Api");
    /// Perform Api Request
    var response = null;
    try
    {
        response = await $.ajax({
            type : 'POST',
            url : _url,
            data : param
        });
        //console.info(response);
        result = JSON.parse(response);
    }
    catch (error)
    {
        console.error(_url);
        console.error(error);

        let caller = {
            url : _url,
            error : error
        }

        let errorData = {
            ajax : caller,
            message : response
        };
        result = errorData;
    }
    finally
    {
        console.debug("Raw Api Response");
        console.debug(response);
        return result;
    }
}