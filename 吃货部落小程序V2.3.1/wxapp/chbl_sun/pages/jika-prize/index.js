var app = getApp();

Page({
    data: {
        statusType: [ "全部订单", "待支付", "进行中", " 已完成" ],
        currentType: 0,
        tabClass: [ "", "", "", "" ],
        orderListStatus: [ "待支付", "进行中", "已完成", "已完成" ],
        orderList: !0,
        orderData: []
    },
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var a = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    gotodetails: function(t) {
        console.log(t);
        wx.navigateTo({
            url: "../jikaOrderDetails/jikaOrderDetails?id=" + t.currentTarget.dataset.id
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/Prizegood",
                    cachetime: "0",
                    data: {
                        uid: t.data
                    },
                    success: function(t) {
                        console.log(t), a.setData({
                            PrizeOrder: t.data.data
                        });
                    }
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});