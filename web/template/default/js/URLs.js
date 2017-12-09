var GET = {
    request: function () {
        var object = {};
        var url = window.location.search.substr(1);
        var components = url.split('&');
        for (var i in components) {
            var spl = components[i].split('=');
            object[spl[0]] = spl[1];
        }
        return object;
    },
    get: function (key) {
        var params = this.params();
        return key in params ? params[key] : false;
    },
    set: function (key, value) {
        this.params();
        this.search[key] = value;
        return this;
    },
    params: function () {
        if (Object.keys(this.search).length == 0)
            this.search = this.request();
        return this.search;
    },
    setObject: function (object) {
        this.params();
        if (Object.keys(object).length != 0) {
            for (var k in object) {
                this.search[k] = object[k];
            }

        }
        return this;
    },
    toString: function (object) {
        var string = '?';
        for (var key in object) {
            string += key + '=' + object[key] + '&';
        }
        return string.substr(0, string.length - 1);
    },
    unset: function (key) {
        if (key in this.search)
            delete this.search[key];
        return this;
    },
    unsetEmpty: function () {
        for (var key in this.search) {
            if (this.search[key] == '') {
                delete this.search[key];
            }
        }
        return this;
    },
    go: function () {
        window.location.href = this.toString(this.search);
    },
    getString: function () {
        return this.toString(this.search);
    },
    search: {}
};