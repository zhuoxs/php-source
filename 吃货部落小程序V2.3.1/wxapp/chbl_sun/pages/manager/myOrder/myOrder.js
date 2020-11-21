var app = getApp();

Page({
    data: {
        statusType: [ "全部", "待核销", " 已完成", "退款" ],
        currentType: 0,
        tabClass: [ "", "", "", "", "" ],
        orderListStatus: [ "待核销", "已完成", "待退款" ],
        orderList: !0,
        isHexiao: !0
    },
    onLoad: function(t) {
        var e = this;
        console.log(t);
        var a = wx.getStorageSync("url");
        e.setData({
            currentType: t.currentTab,
            url: a
        });
        var o = wx.getStorageSync("auth_type");
        e.diyWinColor(), app.util.request({
            url: "entry/wxapp/GetOrderList",
            cachetime: "10",
            data: {
                currentTab: t.currentTab,
                openid: wx.getStorageSync("openid"),
                auth_type: o
            },
            success: function(t) {
                console.log(t), e.setData({
                    orderList: t.data
                });
            }
        });
    },
    statusTap: function(t) {
        var e = this;
        console.log(t);
        var a = t.currentTarget.dataset.index;
        e.data.currentType = a;
        var o = wx.getStorageSync("auth_type");
        e.setData({
            currentType: a
        }), app.util.request({
            url: "entry/wxapp/GetOrderList",
            cachetime: "0",
            data: {
                currentTab: a,
                openid: wx.getStorageSync("openid"),
                auth_type: o
            },
            success: function(t) {
                console.log(t), e.setData({
                    orderList: t.data
                });
            }
        });
    },
    goDetails: function(t) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    diyWinColor: function(t) {
        wx.setNavigationBarColor({
            frontColor: "black",
            backgroundColor: "#fff"
        }), wx.setNavigationBarTitle({
            title: "我的订单"
        });
    }
});