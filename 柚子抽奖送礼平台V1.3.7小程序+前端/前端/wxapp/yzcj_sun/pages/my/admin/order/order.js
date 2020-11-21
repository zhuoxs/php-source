var app = getApp(), Page = require("../../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        currentTab: 0
    },
    onLoad: function(e) {
        var t = e.nav;
        wx.setStorageSync("currentTab", t);
    },
    onShow: function() {
        var n = this, e = wx.getStorageSync("sid"), i = wx.getStorageSync("currentTab");
        app.util.request({
            url: "entry/wxapp/AdminOrder",
            data: {
                sid: e
            },
            success: function(e) {
                console.log(e.data), n.setData({
                    list1: e.data.waitorder,
                    list2: e.data.yiorder,
                    list3: e.data.completeorder
                });
                var t = e.data.waitorder, a = e.data.yiorder, r = e.data.completeorder;
                if (0 == i) var s = 222 * t.length; else if (1 == i) s = 222 * a.length; else s = 222 * r.length;
                n.setData({
                    swiperH: s,
                    currentTab: i
                });
            }
        }), n.getUrl();
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
    bindChange: function(e) {
        console.log(e);
        var t = this;
        if (t.setData({
            currentTab: e.detail.current
        }), 0 == e.detail.current) {
            var a = 222 * t.data.list1.length;
            t.setData({
                swiperH: a
            });
        } else if (1 == e.detail.current) {
            a = 222 * t.data.list2.length;
            t.setData({
                swiperH: a
            });
        } else {
            a = 222 * t.data.list3.length;
            t.setData({
                swiperH: a
            });
        }
    },
    swichNav: function(e) {
        var t = this;
        if (this.data.currentTab === e.target.dataset.index) return !1;
        if (t.setData({
            currentTab: e.target.dataset.index
        }), wx.setStorageSync("currentTab", t.data.currentTab), console.log(), 0 == e.target.dataset.index) {
            var a = 222 * t.data.list1.length;
            t.setData({
                swiperH: a
            });
        } else if (1 == e.target.dataset.index) {
            a = 222 * t.data.list2.length;
            t.setData({
                swiperH: a
            });
        } else {
            a = 222 * t.data.list3.length;
            t.setData({
                swiperH: a
            });
        }
    },
    doSdelivery: function() {
        var r = this, e = wx.getStorageSync("sid");
        app.util.request({
            url: "entry/wxapp/doSdelivery",
            data: {
                sid: e
            },
            success: function(e) {
                if (0 == e.data) wx.showToast({
                    title: "当前无可发货项！",
                    icon: "none",
                    duration: 2e3,
                    mask: !0
                }); else for (var t = 0; t < e.data.length; t++) {
                    var a = e.data[t];
                    app.util.request({
                        url: "entry/wxapp/AccessToken",
                        cachetime: "0",
                        success: function(e) {
                            var t = e.data.access_token;
                            console.log(t), app.util.request({
                                url: "entry/wxapp/DeliveryMessage",
                                cachetime: "0",
                                data: {
                                    oid: a,
                                    page: "yzcj_sun/pages/gift/giftorder/giftorder?navIndex=1",
                                    access_token: t
                                },
                                success: function(e) {
                                    r.onShow(), console.log("模板消息发送"), wx.showToast({
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
            }
        });
    },
    goOrderone: function(e) {
        var t = e.currentTarget.dataset.oid;
        wx.navigateTo({
            url: "../orderone/orderone?oid=" + t
        });
    },
    goOrdertwo: function() {
        wx.navigateTo({
            url: "../ordertwo/ordertwo"
        });
    },
    goOrderthree: function() {
        wx.navigateTo({
            url: "../orderthree/orderthree"
        });
    }
});