var ajaxs = require("../../../we7/js/util.js");

module.exports = function(a) {
    a.data || (a.data = {}), a.data.m || (a.data.m = "sqtg_sun"), ajaxs.request({
        url: "entry/wxapp/" + a.url,
        data: a.data,
        method: a.method ? a.method : "POST",
        showLoading: !1,
        success: function(t) {
            a.success && (t.data.code ? a.fail ? a.fail(t) : wx.showToast({
                title: t.data.msg,
                icon: "none",
                duration: 1500
            }) : a.success(t.data));
        },
        fail: function(t) {
            wx.showToast({
                title: t.errMsg,
                icon: "none",
                duration: 2e3
            }), a.fail && a.fail(t);
        },
        complete: function(t) {
            200 != t.statusCode && wx.showToast({
                title: t.statusCode + "。。。",
                icon: "none",
                duration: 2e3
            }), a.complete && a.complete(t);
        }
    });
};