var util = {
    promisify: function(e) {
        return function(i) {
            for (var r = arguments.length, n = Array(1 < r ? r - 1 : 0), t = 1; t < r; t++) n[t - 1] = arguments[t];
            return new Promise(function(r, t) {
                e.apply(void 0, [ Object.assign({}, i, {
                    success: r,
                    fail: t
                }) ].concat(n));
            });
        };
    }
};

module.exports = util;