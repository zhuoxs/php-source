var app = getApp();

Page({
    data: {
        writeoff: [],
        show: !1
    },
    onLoad: function(e) {
        var o = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var t = e.sid;
        wx.setStorageSync("sid", t), wx.getUserInfo({
            success: function(e) {
                o.setData({
                    userInfo: e.userInfo
                });
            }
        });
    },
    onShow: function() {
        var o = this, e = wx.getStorageSync("sid");
        app.util.request({
            url: "entry/wxapp/allData",
            cachetime: "0",
            data: {
                sid: e
            },
            success: function(e) {
                o.setData({
                    num: e.data
                });
            }
        });
    },
    bindSave: function(e) {
        var o = this, t = e.detail.value.order_num;
        "" != t ? app.util.request({
            url: "entry/wxapp/Writeoff",
            cachetime: "0",
            data: {
                ordernum: t
            },
            success: function(e) {
                1 == e.data ? (o.setData({
                    ordernum: ""
                }), wx.showToast({
                    title: "核销成功！",
                    icon: "none",
                    duration: 2e3
                })) : wx.showToast({
                    title: "核销失败！",
                    icon: "none",
                    duration: 2e3
                });
            }
        }) : wx.showToast({
            title: "请输入订单号！",
            icon: "none",
            duration: 2e3
        });
    },
    goSignout: function() {
        wx.navigateTo({
            url: "../admin/admin"
        });
    },
    onReady: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    goNewOrder: function(e) {
        var o = wx.getStorageSync("sid");
        wx.redirectTo({
            url: "../neworder/neworder?sid=" + o
        });
    },
    goEndOrder: function(e) {
        var o = wx.getStorageSync("sid");
        wx.redirectTo({
            url: "../endorder/endorder?sid=" + o
        });
    },
    scanCode: function(e) {
        var n = this, t = wx.getStorageSync("sid"), a = wx.getStorageSync("url");
        wx.scanCode({
            scanType: "",
            success: function(e) {
                console.log("扫描获取数据-成功"), console.log(e);
                var o = JSON.parse(e.result);
                app.util.request({
                    url: "entry/wxapp/GetOrderInfo",
                    cachetime: "0",
                    data: {
                        id: o.id,
                        ordertype: o.ordertype,
                        sid: t
                    },
                    success: function(e) {
                        console.log("获取订单数据");
                        var o = e.data;
                        if (o.b_name) t = 1; else {
                            var t = 2;
                            o.b_name = "该订单您无权查看";
                        }
                        console.log(o), n.setData({
                            writeoff: o,
                            show: !0,
                            is_build: t,
                            url: a
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
        var t = this, n = t.data.writeoff, a = wx.getStorageSync("sid");
        app.util.request({
            url: "entry/wxapp/SaoBrandOrder",
            cachetime: "0",
            data: {
                id: n.id,
                sid: a,
                ordertype: n.ordertype
            },
            success: function(e) {
                if (console.log("核销订单"), console.log(e.data), t.setData({
                    show: !1
                }), 2 == e.data) {
                    if (1 == n.ordertype) var o = "已过预约时间，是否继续核销？"; else o = "超过存放时间，是否继续核销？";
                    wx.showModal({
                        title: "提示信息",
                        content: o,
                        success: function(e) {
                            e.confirm ? app.util.request({
                                url: "entry/wxapp/SaoBrandOrder",
                                cachetime: "0",
                                data: {
                                    id: n.id,
                                    sid: a,
                                    ordertype: n.ordertype,
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
    }
});