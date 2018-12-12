var $T = ($T) ? $T : null;

(function ($) {
    checkT();

    $(window).ready(function() {
        // var greetings = "Hey, the systems is going perfectly.";
        // console.log(greetings);
        initBar();

    });
    function checkT() {
        if (!$ && $.fn.jQuery.split('.')[0] != '1' && parseInt($.fn.jQuery.split('.')[1]) < 10) {
            console.error('Terraforming JS engine needs jQuery 1.10');
        }

        if ($T !== null) {
            return;
        } else {
            $T = initT();
        }
    }
    function initT() {
        var build = function () {

        };

        build.addAfterSuccessServiceHook = function (fn) {
            afterSuccessServiceHook.push(fn);
        }

        // Move global window to $T.window. In short, no DOM accessing global variable allowed.
        build.window = window;

        build.ajax = function (opt) {
            opt.progress = opt.progress || true;
            var ajaxType = opt.type || 'GET';
            var popup = null;
            ++ajaxRequest;
            if (!showLoadBar) {
                loadBar();
            }

            // Set default behavior for POST
            // For GET, the default behavior is do nothing
            if (opt.progress === true) {
                if (ajaxType.toLowerCase() === 'post') {
                    popup = $T.popup.create({
                        content: '<p style="font-size: 14px">Processing request. Please wait until this message disappear.',
                        modal: true
                    });

//                    setTimeout(function () {
//                        if (popup != null) {
//                            popup.close();
//                        }
//                        popup = $T.popup.create({
//                            content: '<p style="font-size: 14px">Processing request server'
//                        });
//                    }, 30000);
                }
            } else if (typeof opt.progress === 'function') {
                opt.progress();
            }

            // The data will be using object, or JSON, so we need to stringify it if it is not
            if (typeof opt.data === 'object') {
                opt.data = JSON.stringify(opt.data);
            }

            return $.ajax({
                url: opt.url,
                data: opt.data || {},
                type: ajaxType,
                timeout: typeof(opt.timeout) != 'undefined' ? opt.timeout : 30000, //Set your timeout value in milliseconds or 0 for unlimited
                contentType: typeof(opt.contentType) != 'undefined' ? opt.contentType : 'application/json',
                processData: typeof(opt.processData) != 'undefined' ? opt.processData : true,
                dataType: opt.dataType || 'json',
                success: function (data, status) {
                    // Support for legacy code without status
                    if (!data.status) {
                        var oldData = data;
                        data = {};
                        data.status = '200';
                        data.data = oldData;

                        console.warn('Using the old service payload style. Please move to the new service style');
                    }

                    opt.success(data.data, data.status);
                },
                complete: function () {
                    ++processedRequest;
                    if (opt.complete) {
                        opt.complete.apply(this, arguments);
                    }

                    // Don't forget to close loading popup
                    if (popup != null) {
                        popup.close();
                    }

                    for (var i = 0; i < afterSuccessServiceHook.length; i++) {
                        afterSuccessServiceHook[i]();
                    }
                },
                error: function (xhr, text, err) {
                    if (popup != null) {
                        popup.close();
                    }

                    if (xhr.status === 401) {
                        location.href = $T.config.get('loginUri');
                    }

                    if (xhr.status === 403) {
                        location.href = $T.config.get('baseUri') + 'forbidden.html';
                    }
                    console.error('Service error (for POST data, see below): ' + err + "\n" + xhr.responseText);
                    if (this.type.toLowerCase() === 'post') {
                        // Must be reparsed from opt.data
                        console.info(JSON.parse(this.data));
                    }

                    if(xhr.status == 500){
                        var errorPopup = $T.popup.create({
                            content: '<p style="font-size: 14px">The application has been encountered problem. Please try again later.</p>'
                        });
                    } else if(text==="timeout") {
                        var errorPopup = $T.popup.create({
                            content: '<p style="font-size: 14px">Internet connection problem. Please check your internet connection and try again later.</p>'
                        });
                    } else if(xhr.status == 0){
                        var errorPopup = $T.popup.create({
                            content: '<p style="font-size: 14px">Internet connection problem. Please check your internet connection and try again later.</p>'
                        });
                    } else if(xhr.status == 408){
                        var errorPopup = $T.popup.create({
                            content: '<p style="font-size: 14px">Internet connection problem. Please check your internet connection and try again later.</p>'
                        });
                    } else {
                        var errorPopup = $T.popup.create({
                            content: '<p style="font-size: 14px">The application has been encountered problem. Please try again later.</p>'
                        });
                    }
                }
            });
        };

        build.get = function (url, onComplete) {
            return $T.ajax({
                url: url,
                type: 'GET',
                complete: onComplete
            });
        };

        build.post = function (url, data, onComplete) {
            return $T.ajax({
                url: url,
                type: 'POST',
                data: data,
                contentType: 'application/json',
                complete: onComplete
            });
        };

        /** Shorthand of $T.ajax with URL that have been prepended with serviceUri **/
        build.service = function (data) {
            data.url = $T.config.get('serviceUri') + data.url;
            var ret = build.ajax(data);
            return ret;
        };

        build.logError = function (err) {
            console.error(err);
        };

        build.setConfig = function (configData) {
            config = configData;
        };

        build.hook = function (func) {

        };

        build.help = function () {
            var arr = [];
            for (var i in build) {
                if (typeof build[i] === 'function') {
                    arr.push(i + '()');
                }
            }

            console.info(arr.join(', '));
        };

        return build;
    }
    function initBar() {
        $('body').append($('<div id="loading-bar"></div>').css({
            background: 'rgba(255, 255, 0, 0.8)',
            display: 'none',
            height: '2px',
            position: 'fixed',
            top: '0',
            left: '-2px',
            zIndex: '11999',
            boxShadow: '2px 2px 2px #000'
        }));
    }
})(jQuery);

(function ($, $T) {
    "use strict";

    $T.serialize = function (selector, returnStringify) {
        returnStringify = (returnStringify == null) ? false : returnStringify;

        var json = {};
        jQuery.map($(selector).serializeArray(), function (n, i) {
            var cleanName = n.name.replace(/\[.*\]$/, '');

            if (typeof json[cleanName] == 'undefined') {
                if (/\[\]/.test(n.name)) {
                    json[cleanName] = [n.value];
                } else if (/\[.*?\]/.test(n.name)) {
                    json[cleanName] = {};

                    iterateObject(json[cleanName], n.name, n.value);
                } else {
                    json[cleanName] = n.value;
                }
            } else {
                if (typeof json[cleanName] == 'object') {
                    if (json[cleanName] instanceof Array) {
                        json[cleanName].push(n.value);
                    } else {
                        iterateObject(json[cleanName], n.name, n.value);
                    }
                } else {
                    var temp = json[cleanName];
                    json[cleanName] = [temp, n.value];
                }
            }
        });

        if (returnStringify) {
            return JSON.stringify(json);
        }

        return json;
    };

})(jQuery, $T);
