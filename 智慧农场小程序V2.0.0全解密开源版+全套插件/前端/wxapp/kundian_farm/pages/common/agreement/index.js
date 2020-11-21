var e = require("../../../../wxParse/wxParse.js"), t = new getApp(), a = t.siteInfo.uniacid;

Page({
    data: {},
    onLoad: function(s) {
        var i = this, n = s.type, c = "";
        1 == n ? c = "农场协议" : 2 == n ? c = "认养协议" : 3 == n ? c = "积分规则说明" : 4 == n ? c = "农产简介" : 5 == n && (c = "用户购买协议"), 
        wx.setNavigationBarTitle({
            title: c
        }), t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "index",
                op: "getAgreement",
                uniacid: a,
                type: n
            },
            success: function(t) {
                if (0 != t.data.code) wx.showModal({
                    title: "提示",
                    content: t.data.msg,
                    showCancel: "false",
                    success: function() {
                        wx.navigateBack({
                            delta: 1
                        });
                    }
                }); else {
                    var a = t.data.value;
                    "" != a && e.wxParse("article", "html", a, i, 5);
                }
            }
        }), t.util.setNavColor(a);
    }
});