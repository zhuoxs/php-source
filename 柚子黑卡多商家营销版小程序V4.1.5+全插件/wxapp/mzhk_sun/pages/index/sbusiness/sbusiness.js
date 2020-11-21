var app = getApp(), WxParse = require("../../wxParse/wxParse.js");

Page({
    data: {
        hk_userrules: ""
    },
    onLoad: function(e) {
        var t = this, n = wx.getStorageSync("System");
        if (console.log(n), 0 == e.index) {
            var i = n.license;
            WxParse.wxParse("content", "html", i, t, 10), wx.setNavigationBarTitle({
                title: "营业执照"
            });
        }
        if (1 == e.index) {
            i = n.icplicense;
            WxParse.wxParse("content", "html", i, t, 10), wx.setNavigationBarTitle({
                title: "icp许可证"
            });
        }
        if (2 == e.index) {
            i = n.agreement;
            WxParse.wxParse("content", "html", i, t, 10), wx.setNavigationBarTitle({
                title: "服务协议"
            });
        }
        if (3 == e.index) {
            i = n.policy;
            WxParse.wxParse("content", "html", i, t, 10), wx.setNavigationBarTitle({
                title: "隐私政策"
            });
        }
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});