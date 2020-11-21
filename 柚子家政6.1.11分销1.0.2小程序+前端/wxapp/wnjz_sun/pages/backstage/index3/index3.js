var app = getApp();

Page({
    data: {
        finance: [ {
            title: "今日收益",
            detail: "0"
        }, {
            title: "昨日收益",
            detail: "0"
        }, {
            title: "总计收益",
            detail: "0"
        } ],
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        var a = this, e = t.id;
        wx.setStorageSync("bid", e), app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        }), wx.getUserInfo({
            success: function(t) {
                a.setData({
                    thumb: t.userInfo.avatarUrl,
                    nickname: t.userInfo.nickName
                });
            }
        });
        var o = this;
        app.util.request({
            url: "entry/wxapp/branch",
            cachetime: "0",
            data: {
                bid: e
            },
            success: function(t) {
                o.setData({
                    name: t.data
                });
            }
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this, t = wx.getStorageSync("bid");
        app.util.request({
            url: "entry/wxapp/Branchtodayfangke",
            cachetime: "0",
            data: {
                bid: t
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    oldData: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/BranchFinanceData",
            cachetime: "0",
            data: {
                bid: t
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    Finance: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    toSet: function(t) {
        wx.redirectTo({
            url: "../set3/set3"
        });
    },
    scanCode: function(t) {
        var o = this, e = wx.getStorageSync("bid");
        wx.scanCode({
            scanType: "",
            success: function(t) {
                console.log("扫描获取数据-成功"), console.log(t);
                var a = JSON.parse(t.result);
                console.log(a.id), app.util.request({
                    url: "entry/wxapp/GetOrderInfo",
                    cachetime: "0",
                    data: {
                        id: a.id,
                        bid: e
                    },
                    success: function(t) {
                        console.log("获取订单数据");
                        var a = t.data;
                        if (5 == a.status && (a.b_name = "该订单已核销"), a.b_name) e = 1; else {
                            var e = 2;
                            a.b_name = "该订单您无权查看";
                        }
                        console.log(a), o.setData({
                            writeoff: a,
                            show: !0,
                            is_build: e
                        });
                    }
                });
            },
            fail: function(t) {
                console.log("扫描获取数据-失败"), console.log(t);
            }
        });
    },
    writeoff: function(t) {
        var a = this, e = a.data.writeoff, o = wx.getStorageSync("bid");
        app.util.request({
            url: "entry/wxapp/SaoBrandOrder",
            cachetime: "0",
            data: {
                id: e.oid,
                bid: o
            },
            success: function(t) {
                console.log("核销订单"), console.log(t.data), a.setData({
                    show: !1
                }), 1 == t.data ? wx.showToast({
                    title: "核销成功",
                    icon: "success",
                    duration: 2e3
                }) : 3 == t.data ? wx.showToast({
                    title: "该订单不存在！",
                    icon: "none",
                    duration: 2e3
                }) : wx.showToast({
                    title: "该订单已核销！",
                    icon: "none",
                    duration: 2e3
                });
            },
            fial: function(t) {
                console.log("核销订单11"), console.log(t.data), wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1
                });
            }
        });
    },
    showModel: function(t) {
        this.setData({
            show: !1
        });
    }
});