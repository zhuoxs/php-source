var _bluebird = require("bluebird"), _bluebird2 = _interopRequireDefault(_bluebird);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function formatTime(e) {
    var t = e.getFullYear(), r = e.getMonth() + 1, n = e.getDate(), u = e.getHours(), o = e.getMinutes(), i = e.getSeconds();
    return [ t, r, n ].map(formatNumber).join("/") + " " + [ u, o, i ].map(formatNumber).join(":");
}

function formatNumber(e) {
    return (e = e.toString())[1] ? e : "0" + e;
}

function getDateStr(e) {
    return e ? e.getFullYear() + "年" + (e.getMonth() + 1) + "月" + e.getDate() + "日" : "";
}

function guid() {
    return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, function(e) {
        var t = 16 * Math.random() | 0;
        return ("x" == e ? t : 3 & t | 8).toString(16);
    });
}

function log(e) {
    if (e) {
        getApp().settings.debug && console.log(e);
        var t = wx.getStorageSync("logs") || [];
        t.unshift(e), wx.setStorageSync("logs", t);
    }
}

function promiseHandle(r, n) {
    return n = n || {}, new _bluebird2.default(function(e, t) {
        "function" != typeof r && t(), n.success = e, n.fail = t, r(n);
    });
}

module.exports = {
    formatTime: formatTime,
    guid: guid,
    log: log,
    promiseHandle: promiseHandle,
    getDateStr: getDateStr,
    formatNumber: formatNumber
};