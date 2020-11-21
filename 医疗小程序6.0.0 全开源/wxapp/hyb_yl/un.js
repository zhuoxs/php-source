function getqu() {
    app.util.request({
        url: "entry/wxapp/mywquestion",
        data: {
            openid: openid
        },
        success: function(u) {
            function t(t) {
                return u.apply(this, arguments);
            }
            return t.toString = function() {
                return u.toString();
            }, t;
        }(function(t) {
            t && 200 == t.statusCode && success(t);
        })
    });
}

module.exports = {
    getqu: getqu
};