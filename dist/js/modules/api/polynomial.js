define(function(require){
    
    var request = require("core/request");
    
    return {
        
        getRoots: function(params, callback) {
            
            request
                .setURL("../api/polynomial/roots")
                .setMethod("POST")
                .setBody(JSON.stringify(params))
                .setHeaders({"Content-Type": "application/json"})
                .send(function(err, xhr){
                    
                    try
                    {
                        var response = JSON.parse(xhr.responseText);
                        
                        callback(response);
                    }
                    catch (e)
                    {
                        throw new Error("[API] polynomial: Error during getRoots response parsing");
                    }
                });
        }
    };
});