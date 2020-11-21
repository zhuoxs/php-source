Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.default = pay;

var _request = require("./request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _defineProperty(e, r, t) {
    return r in e ? Object.defineProperty(e, r, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[r] = t, e;
}

function pay(e) {
    return _request2.default.post("pay", _defineProperty({
        orderid: e
    }, "orderid", e)).then(function(e) {
        return !0 === e.hasOwnProperty("errno") ? Promise.reject(e.message) : wxPay(e);
    }, function(e) {
        return Promise.reject(e);
    });
}

function wxPay(e) {
    return console.log("wxPay"), new Promise(function(r, t) {
        wx.requestPayment({
            timeStamp: e.timeStamp,
            nonceStr: e.nonceStr,
            package: e.package,
            signType: "MD5",
            paySign: e.paySign,
            success: function(e) {
                console.log(e), r(e);
            },
            fail: function(e) {
                console.log(e), t(e.errMsg);
            }
        });
    });
}