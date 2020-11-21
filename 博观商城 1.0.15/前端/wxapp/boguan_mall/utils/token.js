function e(e, n) {
    if (!(e instanceof n)) throw new TypeError("Cannot call a class as a function");
}

Object.defineProperty(exports, "__esModule", {
    value: !0
});

var n = function() {
    function e(e, n) {
        for (var t = 0; t < n.length; t++) {
            var o = n[t];
            o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), 
            Object.defineProperty(e, o.key, o);
        }
    }
    return function(n, t, o) {
        return t && e(n.prototype, t), o && e(n, o), n;
    };
}(), t = require("../../api.js"), o = require("../../siteinfo.js"), r = function() {
    function r() {
        e(this, r);
    }
    return n(r, [ {
        key: "verify",
        value: function(e) {
            var n = wx.getStorageSync("token");
            n ? this._veirfyFromServer(e, n) : this.getTokenFromServer(e);
        }
    }, {
        key: "_veirfyFromServer",
        value: function(e, n) {
            var r = this;
            wx.request({
                url: e + t.default.verifyUrl,
                header: {
                    "content-type": "application/json",
                    uniacid: o.uniacid
                },
                method: "POST",
                data: {
                    token: n
                },
                success: function(n) {
                    var t = n.data.isValid;
                    console.log("token----" + t), t || r.getTokenFromServer(e);
                }
            });
        }
    }, {
        key: "getTokenFromServer",
        value: function(e, n) {
            wx.login({
                success: function(r) {
                    wx.request({
                        url: e + t.default.tokenUrl,
                        header: {
                            "content-type": "application/json",
                            uniacid: o.uniacid
                        },
                        method: "POST",
                        data: {
                            code: r.code
                        },
                        success: function(e) {
                            e.data.token && wx.setStorageSync("token", e.data.token), n && n(e.data.token);
                        },
                        fail: function(e) {
                            console.log("tokenFail=>", e);
                        }
                    });
                }
            });
        }
    } ]), r;
}();

exports.Token = r;