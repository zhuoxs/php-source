function _defineProperty(e, t, n) {
    return t in e ? Object.defineProperty(e, t, {
        value: n,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = n, e;
}

var app = getApp();

Page(_defineProperty({
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
    onLoad: function(e) {
        var t = this;
        wx.getUserInfo({
            success: function(e) {
                t.setData({
                    thumb: e.userInfo.avatarUrl,
                    nickname: e.userInfo.nickName
                });
            }
        });
        var n = this;
        app.util.request({
            url: "entry/wxapp/system",
            cachetime: "0",
            success: function(e) {
                n.setData({
                    pt_name: e.data.pt_name
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
        var t = this;
        app.util.request({
            url: "entry/wxapp/todayfangke",
            cachetime: "0",
            success: function(e) {
                console.log(e.data), t.setData({
                    oldData: e.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/FinanceData",
            cachetime: "0",
            success: function(e) {
                console.log(e.data), t.setData({
                    Finance: e.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    scanCode: function(e) {
        var o = this;
        wx.scanCode({
            scanType: "",
            success: function(e) {
                console.log("扫描获取数据-成功"), console.log(e);
                var n = JSON.parse(e.result), t = wx.getStorageSync("build_id").bid;
                app.util.request({
                    url: "entry/wxapp/GetOrderInfo",
                    cachetime: "0",
                    data: {
                        id: n.id,
                        ordertype: n.ordertype,
                        bid: t
                    },
                    success: function(e) {
                        console.log("获取订单数据");
                        var t = e.data;
                        t.ordertype = n.ordertype, console.log(t), o.setData({
                            writeoff: t,
                            goodsnum: 1,
                            show: !0
                        });
                    }
                });
            },
            fail: function(e) {
                console.log("扫描获取数据-失败"), console.log(e);
            }
        });
    },
    onShareAppMessage: function() {},
    toMessage: function(e) {
        wx.redirectTo({
            url: "../message/message"
        });
    },
    toSet: function(e) {
        wx.redirectTo({
            url: "../set/set"
        });
    }
}, "scanCode", function(e) {
    wx.scanCode({
        success: function(e) {
            var t = e.result;
            wx.navigateTo({
                url: t
            });
        }
    });
}));