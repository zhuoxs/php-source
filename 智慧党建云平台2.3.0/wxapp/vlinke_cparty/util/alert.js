Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.toast = function(t) {
    return new Promise(function(e, n) {
        wx.showToast({
            title: t,
            success: function() {
                e();
            },
            fail: function(t) {
                n(t);
            }
        });
    });
}, exports.default = function(t) {
    var e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : "提示";
    return new Promise(function(n, o) {
        wx.showModal({
            title: e,
            content: t,
            cancel: !1,
            success: function() {
                n();
            },
            fail: function() {
                o();
            }
        });
    });
};