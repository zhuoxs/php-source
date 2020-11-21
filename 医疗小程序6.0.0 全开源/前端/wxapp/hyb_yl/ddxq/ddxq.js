var app = getApp(), until = require("../../utils/util.js");

Page({
    data: {
        id: "",
        url: "",
        images: ""
    },
    del: function(t) {
        var e = t.currentTarget.dataset.date;
        app.util.request({
            url: "entry/wxapp/Selecthxstate",
            data: {
                zy_id: e
            },
            success: function(t) {
                1 == t.data.data.zy_zhenzhuang ? wx.showModal({
                    title: "温馨提示",
                    content: "订单已核销无法取消预约"
                }) : app.util.request({
                    url: "entry/wxapp/Delzjyy",
                    data: {
                        zy_id: e
                    },
                    success: function(t) {
                        console.log(t), wx.showToast({
                            title: "取消成功",
                            icon: "success",
                            duration: 2e3,
                            success: function() {
                                setTimeout(function() {
                                    wx.navigateBack({
                                        url: "../wodeyuyue/wodeyuyue"
                                    });
                                }, 2e3);
                            }
                        });
                    }
                });
            }
        });
    },
    onLoad: function(t) {
        var e = wx.getStorageSync("color"), a = t.yytime.split(" "), o = a[1].split("-"), n = a[0] + " " + o[1], s = new Date(), u = s.getMonth() + 1, i = s.getDate(), l = s.getMinutes();
        1 <= u && u <= 9 && (u = "0" + u), 0 <= i && i <= 9 && (i = "0" + i), 0 <= l && l <= 9 && (l = "0" + l);
        var c = s.getFullYear() + "-" + u + "-" + i + " " + s.getHours() + ":" + l;
        this.setData({
            times: c
        }), console.log(c, n), wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: e
        });
        var r = this, d = t.id;
        t.money;
        app.util.request({
            url: "entry/wxapp/Cxhextype",
            data: {
                id: d
            },
            success: function(t) {
                console.log(t.data);
                var e = until.formatTime(new Date(1e3 * t.data.data.zy_time));
                1 == t.data.data.zy_zhenzhuang ? (r.setData({
                    title: "订单已完成",
                    close: !0
                }), setTimeout(function() {
                    r.setData({
                        close: !1
                    });
                }, 2e3)) : n < c && (r.setData({
                    title: "订单已逾期,您可以选择删除",
                    close: !0
                }), setTimeout(function() {
                    r.setData({
                        close: !1
                    });
                }, 2e3)), r.setData({
                    cxhextype: t.data.data,
                    times: e
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Money",
            data: {
                id: d
            },
            success: function(t) {
                console.log(t), r.setData({
                    detail: t.data.data,
                    images: t.data.data.zy_sex
                });
            }
        });
    },
    getstorurl: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Scurl",
            success: function(t) {
                console.log(t), e.setData({
                    url: t.data.data
                });
            }
        });
    },
    onReady: function() {
        this.getstorurl();
        var e = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                e.setData({
                    tell: t.data.data.yy_telphone
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    tel: function(t) {
        var e = this.data.tell;
        wx.makePhoneCall({
            phoneNumber: e
        });
    },
    onShow: function(t) {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});