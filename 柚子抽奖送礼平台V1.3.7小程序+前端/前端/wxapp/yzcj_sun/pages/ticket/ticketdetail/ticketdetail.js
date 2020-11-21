var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        product: []
    },
    onLoad: function(t) {
        var a = this;
        wx.getUserInfo({
            success: function(t) {
                a.setData({
                    userInfo: t.userInfo
                });
            }
        });
        a = this;
        var e = t.gid;
        a.setData({
            gid: e
        }), app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this, t = e.data.gid;
        app.util.request({
            url: "entry/wxapp/Editor",
            data: {
                gid: t
            },
            success: function(t) {
                console.log(t);
                var a = t.data.goods;
                e.setData({
                    product: a,
                    cjzt: t.data.cjzt,
                    cjzt1: t.data.cjzt ? e.data.url + "/" + t.data.cjzt : "../../../resource/images/banner.jpg"
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onEditor: function() {
        wx.navigateTo({
            url: "../ticketeditor/ticketeditor"
        });
    },
    goTicketmy: function() {
        wx.redirectTo({
            url: "../ticketmy/ticketmy"
        });
    },
    onShareAppMessage: function(t) {
        var a = this, e = a.data.gid;
        if (console.log(t.target.dataset.cid), 2 == t.target.dataset.cid) var n = "红包 " + a.data.product.gname + " 元"; else n = a.data.product.gname;
        return "button" === t.from && console.log(t.target), {
            title: a.data.userInfo.nickName + "邀你参与[" + n + "]抽奖",
            path: "/yzcj_sun/pages/ticket/ticketmiandetail/ticketmiandetail?gid=" + e,
            success: function(t) {},
            fail: function(t) {}
        };
    }
});