var app = getApp();

Page({
    data: {
        writeoff: [],
        show: !1
    },
    onLoad: function(e) {
        var t = this, a = e.bid, o = e.b_name;
        wx.setStorageSync("bid", a), console.log(a), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url", e.data), t.setData({
                    url: e.data
                });
            }
        }), wx.getUserInfo({
            success: function(e) {
                t.setData({
                    userInfo: e.userInfo,
                    b_name: o
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this, e = wx.getStorageSync("bid");
        app.util.request({
            url: "entry/wxapp/todayorder",
            cachetime: "0",
            data: {
                bid: e
            },
            success: function(e) {
                t.setData({
                    orderData: e.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/buildkeepwineData",
            cachetime: "0",
            data: {
                bid: e
            },
            success: function(e) {
                console.log(e.data), t.setData({
                    Dkeep: e.data.Dkeep,
                    Ykeep: e.data.Ykeep,
                    extwine: e.data.extwine
                });
            }
        }), app.util.request({
            url: "entry/wxapp/financeData",
            cachetime: "0",
            data: {
                bid: e
            },
            success: function(e) {
                t.setData({
                    Finance: e.data
                });
            }
        });
    },
    scanCode: function(e) {
        var o = this, a = wx.getStorageSync("bid");
        wx.scanCode({
            scanType: "",
            success: function(e) {
                console.log("扫描获取数据-成功"), console.log(e);
                var t = JSON.parse(e.result);
                app.util.request({
                    url: "entry/wxapp/GetOrderInfo",
                    cachetime: "0",
                    data: {
                        id: t.id,
                        ordertype: t.ordertype,
                        bid: a
                    },
                    success: function(e) {
                        console.log("获取订单数据");
                        var t = e.data;
                        if (t.b_name) a = 1; else {
                            var a = 2;
                            t.b_name = "该订单您无权查看";
                        }
                        console.log(t), o.setData({
                            writeoff: t,
                            show: !0,
                            is_build: a
                        });
                    }
                });
            },
            fail: function(e) {
                console.log("扫描获取数据-失败"), console.log(e);
            }
        });
    },
    writeoff: function(e) {
        var a = this, o = a.data.writeoff, n = wx.getStorageSync("bid");
        app.util.request({
            url: "entry/wxapp/SaoBrandOrder",
            cachetime: "0",
            data: {
                id: o.id,
                bid: n,
                ordertype: o.ordertype
            },
            success: function(e) {
                if (console.log("核销订单"), console.log(e.data), a.setData({
                    show: !1
                }), 2 == e.data) {
                    if (1 == o.ordertype) var t = "已过预约时间，是否继续核销？"; else t = "超过存放时间，是否继续核销？";
                    wx.showModal({
                        title: "提示信息",
                        content: t,
                        success: function(e) {
                            e.confirm ? app.util.request({
                                url: "entry/wxapp/SaoBrandOrder",
                                cachetime: "0",
                                data: {
                                    id: o.id,
                                    bid: n,
                                    ordertype: o.ordertype,
                                    overtype: 1
                                },
                                success: function(e) {
                                    wx.showToast({
                                        title: "核销成功",
                                        icon: "success",
                                        duration: 2e3
                                    });
                                },
                                fial: function(e) {}
                            }) : e.cancel && console.log("用户点击取消");
                        }
                    });
                } else wx.showToast({
                    title: "核销成功",
                    icon: "success",
                    duration: 2e3
                });
            },
            fial: function(e) {}
        });
    },
    showModel: function(e) {
        this.setData({
            show: !1
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    goSet: function() {
        wx.redirectTo({
            url: "../set2/set2?b_name=" + this.data.b_name
        });
    },
    goOrdery: function() {
        var e = wx.getStorageSync("bid");
        wx.redirectTo({
            url: "../order2/order2?bid=" + e + "&b_name=" + this.data.b_name
        });
    },
    goDeposit: function() {
        var e = wx.getStorageSync("bid");
        wx.redirectTo({
            url: "../deposit/deposit?bid=" + e + "&b_name=" + this.data.b_name
        });
    }
});