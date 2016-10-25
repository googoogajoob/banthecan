(function($) {
    if (!$.setCookie) {
        $.extend({
            setCookie: function(c_name, value, exdays) {
                try {
                    if (!c_name) return false;
                    var exdate = new Date();
                    exdate.setDate(exdate.getDate() + exdays);
                    var c_value = escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
                    document.cookie = c_name + "=" + c_value;
                }
                catch(err) {
                    return false;
                };
                return true;
            }
        });
    };
    if (!$.getCookie) {
        $.extend({
            getCookie: function(c_name) {
                try {
                    var i, x, y,
                        ARRcookies = document.cookie.split(";");
                    for (i = 0; i < ARRcookies.length; i++) {
                        x = ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
                        y = ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
                        x = x.replace(/^\s+|\s+$/g,"");
                        if (x == c_name) return unescape(y);
                    };
                }
                catch(err) {
                    return false;
                };
                return false;
            }
        });
    };
})(jQuery);