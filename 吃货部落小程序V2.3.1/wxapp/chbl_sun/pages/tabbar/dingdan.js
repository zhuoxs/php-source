Page({
    data: {
        statusType: [ "全部订单", "待支付", "进行中", " 已完成" ],
        currentType: 0,
        tabClass: [ "", "", "", "" ],
        orderListStatus: [ "待支付", "进行中", "已完成", "已完成" ],
        orderList: !1
    },
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), console.log(t), this.setData({
            current: t.currentIndex
        });
    },
    statusTap: function(t) {
        var n = this;
        console.log(t);
        var o = t.currentTarget.dataset.index;
        n.data.currentType = o, n.setData({
            currentType: o
        }), n.onShow();
    },
    goDetails: function(t) {
        wx.navigateTo({
            url: "../myOrder-list/details"
        });
    },
    goTap: function(t) {
        console.log(t);
        var n = this;
        n.setData({
            current: t.currentTarget.dataset.index
        }), 0 == n.data.current && wx.redirectTo({
            url: "../tabbar/gongzuotai"
        }), 1 == n.data.current && wx.redirectTo({
            url: "../tabbar/dingdan?currentIndex=1"
        }), 2 == n.data.current && wx.redirectTo({
            url: "../tabbar/setting?currentIndex=2"
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