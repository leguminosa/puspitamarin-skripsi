var CONFIG = (function() {
    var private = {
        'BASE_URI': 'http://localhost/malaria/',
        'MY_CONST': '1',
        'ANOTHER_CONST': '2'
    };

    return {
        get: function(name) { return private[name]; }
    };
})();

// how to use :
// alert('MY_CONST: ' + CONFIG.get('MY_CONST'));  // 1
//
// CONFIG.MY_CONST = '2';
// alert('MY_CONST: ' + CONFIG.get('MY_CONST'));  // 1
//
// CONFIG.private.MY_CONST = '2';                 // error
// alert('MY_CONST: ' + CONFIG.get('MY_CONST'));  // 1
