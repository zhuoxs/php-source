var app = getApp();

Page({
    data: {
        statusType: [ "审核中", "进行中", "已结束", "集齐订单" ],
        currentType: 0,
        tabClass: [ "", "", "", "" ],
        orderListStatus: [ "待支付", "进行中", "已完成", "已完成" ],
        orderList: !0
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        }), wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/GetUserActive",
                    cachetime: "30",
                    data: {
                        user_id: t.data
                    },
                    success: function(t) {
                        console.log(t), a.setData({
                            activelist: t.data.data
                        });
                    }
                }), app.util.request({
                    url: "entry/wxapp/GetUserActived",
                    cachetime: "30",
                    data: {
                        user_id: t.data
                    },
                    success: function(t) {
                        console.log(t), a.setData({
                            activelisted: t.data.data
                        });
                    }
                }), app.util.request({
                    url: "entry/wxapp/GetUserActivend",
                    cachetime: "30",
                    data: {
                        user_id: t.data
                    },
                    success: function(t) {
                        console.log(t), a.setData({
                            activelistend: t.data.data
                        });
                    }
                }), app.util.request({
                    url: "entry/wxapp/jiqiOrder",
                    cachetime: "0",
                    data: {
                        openid: t.data
                    },
                    success: function(t) {
                        console.log(t), a.setData({
                            jiqiorder: t.data.data
                        });
                    }
                });
            }
        });
    },
    statusTap: function(t) {
        var a = this;
        console.log(t);
        var e = t.currentTarget.dataset.index;
        a.data.currentType = e, a.setData({
            currentType: e
        }), 1 == e && this.setData({}), a.onShow();
    },
    gotodetails: function(t) {
        console.log(t), wx.navigateTo({
            url: "../active-list/details?id=" + t.currentTarget.dataset.id
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});