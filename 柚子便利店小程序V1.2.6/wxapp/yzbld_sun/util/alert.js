function alert(n) {
    var o = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "提示";
    return new Promise(function(t, e) {
        wx.showModal({
            title: o,
            content: n,
            cancel: !1,
            success: function() {
                t();
            },
            fail: function() {
                e();
            }
        });
    });
}

function toast(n) {
    return new Promise(function(t, e) {
        wx.showToast({
            title: n,
            success: function() {
                t();
            },
            fail: function(t) {
                e(t);
            }
        });
    });
}

Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.toast = toast, exports.default = alert;