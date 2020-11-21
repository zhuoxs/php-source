var app = getApp(), Page = require("../../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        list3: [ {
            imgSrc: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152634825519.png",
            name: "精美礼物礼品",
            num: 2,
            price: "167.00"
        } ]
    },
    onLoad: function(e) {
        var t = e.oid;
        wx.setStorageSync("oid", t);
    },
    onReady: function() {},
    onShow: function() {
        var t = this, e = wx.getStorageSync("oid");
        app.util.request({
            url: "entry/wxapp/Orderdetail",
            data: {
                oid: e
            },
            success: function(e) {
                console.log(e.data), t.setData({
                    list3: e.data
                });
            }
        }), t.getUrl();
    },
    getUrl: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url", e.data), t.setData({
                    url: e.data
                });
            }
        });
    },
    delivery: function() {
        var a = this, n = wx.getStorageSync("oid");
        app.util.request({
            url: "entry/wxapp/delivery",
            data: {
                oid: n
            },
            success: function(e) {
                app.util.request({
                    url: "entry/wxapp/AccessToken",
                    cachetime: "0",
                    success: function(e) {
                        var t = e.data.access_token;
                        console.log(t), app.util.request({
                            url: "entry/wxapp/DeliveryMessage",
                            cachetime: "0",
                            data: {
                                oid: n,
                                page: "yzcj_sun/pages/gift/giftorder/giftorder?navIndex=1",
                                access_token: t
                            },
                            success: function(e) {
                                a.onShow(), console.log("模板消息发送"), wx.showToast({
                                    title: "已成功发货！",
                                    icon: "success",
                                    duration: 1e3,
                                    mask: !0
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});