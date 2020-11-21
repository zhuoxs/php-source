var app = getApp(), Page = require("../../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {},
    onLoad: function(t) {
        var e = this;
        e.setData({
            ordernum: t.ordernum
        });
        var a = wx.getStorageSync("url");
        app.util.request({
            url: "entry/wxapp/getScan",
            data: {
                ordernum: t.ordernum
            },
            success: function(t) {
                console.log(t), e.setData({
                    url: a,
                    res: t.data.res,
                    num: t.data.num
                });
            }
        });
    },
    onShow: function() {},
    once: function() {
        var t = this.data.ordernum;
        app.util.request({
            url: "entry/wxapp/DoScan",
            data: {
                ordernum: t
            },
            success: function(t) {
                1 == t.data ? wx.showModal({
                    title: "提示",
                    content: "核销成功",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && (console.log("用户点击确定"), wx.navigateTo({
                            url: "/yzcj_sun/pages/ticket/ticketmy/ticketmy"
                        }));
                    }
                }) : wx.showToast({
                    title: "失败了!",
                    icon: "none",
                    duration: 2e3
                });
            }
        });
    }
});