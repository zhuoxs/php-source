function e(e, n, r) {
    return n in e ? Object.defineProperty(e, n, {
        value: r,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[n] = r, e;
}

function n(e) {
    return console.log("wxPay"), new Promise(function(n, r) {
        wx.requestPayment({
            timeStamp: e.timeStamp,
            nonceStr: e.nonceStr,
            package: e.package,
            signType: "MD5",
            paySign: e.paySign,
            success: function(e) {
                console.log(e), n(e);
            },
            fail: function(e) {
                console.log(e), r(e.errMsg);
            }
        });
    });
}

Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.default = function(t) {
    return r.default.post("pay", e({
        orderid: t
    }, "orderid", t)).then(function(e) {
        return !0 === e.hasOwnProperty("errno") ? Promise.reject(e.message) : n(e);
    }, function(e) {
        return Promise.reject(e);
    });
};

var r = function(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}(require("./request.js"));