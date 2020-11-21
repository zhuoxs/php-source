var _webview = require("../../../we7/resource/js/webview"), app = getApp();

Page({
    data: {
        canIUse: wx.canIUse("web-view"),
        url: ""
    },
    onLoad: function(e) {
        var w = "";
        if (e.url && (w = decodeURIComponent(e.url)), e.scene && (w = app.util.url("entry/site/index", {
            p: "common",
            ac: "wxapp",
            m: "weliam_merchant",
            url: e.scene
        })), !w) try {
            (w = wx.getStorageSync("we7_webview")) && wx.removeStorageSync("we7_webview");
        } catch (e) {}
        w || (w = app.util.url("entry/site/index", {
            p: "common",
            ac: "wxapp",
            m: "weliam_merchant"
        })), (0, _webview.urlAddCode)(w);
    },
    onShow: function() {
        var e = "";
        try {
            (e = wx.getStorageSync("we7_webview")) && wx.removeStorageSync("we7_webview");
        } catch (e) {}
        e && (0, _webview.urlAddCode)(e);
    },
    onShareAppMessage: function(e) {
        var w = app.util.url("wxapp/home/wxapp_web");
        return console.log(e.webViewUrl), w = w + "&url=" + encodeURIComponent(e.webViewUrl), 
        {
            path: "/wxapp_web/pages/view/index?url=" + encodeURIComponent(w),
            success: function(e) {},
            fail: function(e) {}
        };
    }
});