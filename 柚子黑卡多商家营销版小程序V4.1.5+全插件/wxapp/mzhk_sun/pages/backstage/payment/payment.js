var app = getApp();

Page({
    data: {
        page: 1,
        orderlist: []
    },
    onLoad: function(t) {
        var a = this, e = t.bid;
        e && app.util.request({
            url: "entry/wxapp/GetPayment",
            data: {
                bid: e,
                type: 2
            },
            success: function(t) {
                console.log(t.data), 2 != t.data ? a.setData({
                    orderlist: t.data
                }) : a.setData({
                    orderlist: []
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var e = this, t = wx.getStorageSync("brand_info"), n = e.data.orderlist, o = e.data.page;
        app.util.request({
            url: "entry/wxapp/GetPayment",
            data: {
                bid: t.bid,
                page: o,
                type: 2
            },
            success: function(t) {
                if (console.log(t.data), 2 == t.data) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }); else {
                    var a = t.data;
                    n = n.concat(a), e.setData({
                        orderlist: n,
                        page: o + 1
                    });
                }
            }
        });
    }
});