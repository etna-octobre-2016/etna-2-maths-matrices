define(function(require){
    
    var request = require("core/request");
    
    return {
        
        getRoots: function(params, callback) {
            
            request
                .setURL("api/polynomial/roots")
                .setMethod("POST")
                .setBody(JSON.stringify(params))
                .setHeaders({"Content-Type": "application/json"})
                .send(callback);
        }
    };
});