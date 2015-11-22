function moduleFactory()
{
    return {
        xhr:     new XMLHttpRequest(),
        url:     null,
        body:    null,
        method:  "GET",
        headers: {},

        setURL: function(url)
        {
            this.url = url;
            return this;
        },
        setBody: function(body)
        {
            this.body = body;
            return this;
        },
        setMethod: function(method)
        {
            this.method = method;
            return this;
        },
        setHeaders: function(headers)
        {
            var prop;

            if (headers instanceof Object)
            {
                for (prop in headers)
                {
                    if (headers.hasOwnProperty(prop))
                    {
                        this.headers[prop] = headers[prop];
                    }
                }
            }
            return this;
        },
        send: function(callback)
        {
            var prop;

            this.xhr.open(this.method, this.url, true);
            for (prop in this.headers)
            {
                if (this.headers.hasOwnProperty(prop))
                {
                    this.xhr.setRequestHeader(prop, this.headers[prop]);
                }
            }
            this.xhr.onreadystatechange = function()
            {
                var error;

                error = false;
                if (this.xhr.readyState === 4)
                {
                    if (typeof callback === "function")
                    {
                        if (this.xhr.status >= 400)
                        {
                            error = true;
                        }
                        callback(error, this.xhr);
                    }
                }

            }.bind(this);
            if (this.body !== null)
            {
                this.xhr.send(this.body);
            }
            else
            {
                this.xhr.send();
            }
        },
        urlParamsSerialize: function(params)
        {
            var paramsArray;

            if (!(params instanceof Object))
            {
                throw new Error("urlParamsSerialize method expects params to be an object");
            }
            paramsArray = [];
            Object.getOwnPropertyNames(params).forEach(function(prop)
            {
                paramsArray.push(prop + "=" + params[prop].toString());
            });
            return "?" + paramsArray.join("&");
        },
        urlParamsUnserialize: function(paramsString)
        {
            var params,
                paramsArray,
                parsedValue;

            if (typeof paramsString !== "string")
            {
                throw new Error("urlParamsUnserialize method expects paramsString to be a string");
            }
            params = {};
            paramsString = paramsString.replace("?", "");
            paramsArray = paramsString.split("&");
            paramsArray.forEach(function(item)
            {
                var itemArray;

                itemArray = item.split("=");
                if (itemArray.length !== 2)
                {
                    throw new Error("invalid url params string : " + paramsString);
                }
                if ( !isNaN(parsedValue = parseFloat(itemArray[1])) )
                {
                    params[itemArray[0]] = parsedValue;
                }
                else if ( !isNaN(parsedValue = parseInt(itemArray[1], 10)) )
                {
                    params[itemArray[0]] = parsedValue;
                }
                else
                {
                    params[itemArray[0]] = itemArray[1];
                }
            });
            return params;
        }
    };
}
(function(root, factory){

    if (typeof define === "function" && define.amd)
    {
        define(factory);
    }
    else if (typeof exports === "object")
    {
        module.exports = factory();
    }

})(this, moduleFactory);
