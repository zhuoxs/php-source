var _bluebird = require("bluebird"), _bluebird2 = _interopRequireDefault(_bluebird);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function formatTime(e) {
    var t = e.getFullYear(), r = e.getMonth() + 1, o = e.getDate(), a = e.getHours(), n = e.getMinutes(), u = e.getSeconds();
    return [ t, r, o ].map(formatNumber).join("/") + " " + [ a, n, u ].map(formatNumber).join(":");
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

function promiseHandle(r, o) {
    return o = o || {}, new _bluebird2.default(function(e, t) {
        "function" != typeof r && t(), o.success = e, o.fail = t, r(o);
    });
}

function switchTabBar(e, t) {
    var r = e, o = t;
    0 != r.indexOf("/") && (r = "/" + r), r != o ? navigateBackToExistOrNavigateToNew(getCurrentPages(), o) : wx.showToast({
        title: "试试下拉页面刷新页面吧"
    });
}

function navigateBackToExistOrNavigateToNew(e, t) {
    for (var r = e.length, o = e.length; o--; ) {
        if ("/" + e[o].__route__ == t) return console.log("__route__: /", e[o].__route__, " == target:", t), 
        console.log("Result:path equal,back delta:", r - 1, ",", o, ",", r - 1 - o), wx.navigateBack({
            delta: r - 1 - o
        }), !0;
        console.log("__route__: /", e[o].__route__, " != target:", t);
    }
    return wx.navigateTo({
        url: t
    }), !1;
}

module.exports = {
    formatTime: formatTime,
    guid: guid,
    log: log,
    promiseHandle: promiseHandle,
    getDateStr: getDateStr,
    formatNumber: formatNumber,
    switchTabBar: switchTabBar
};