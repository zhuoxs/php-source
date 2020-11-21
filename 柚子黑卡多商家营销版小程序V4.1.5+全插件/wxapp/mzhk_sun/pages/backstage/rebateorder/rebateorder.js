var app = getApp();

Page({
    data: {
        bignav: [ "普通订单", "砍价订单", "拼团订单", "抢购订单" ],
        curIndex: 0,
        page: [ 1, 1, 1, 1 ],
        orderlist: []
    },
    onLoad: function(t) {
        var e = this, a = t.bid;
        a && app.util.request({
            url: "entry/wxapp/GetRebateOrder",
            data: {
                bid: a,
                ordertype: 1
            },
            success: function(t) {
                console.log(t.data), 2 == t.data ? e.setData({
                    orderlist: [],
                    curIndex: 0
                }) : e.setData({
                    orderlist: t.data,
                    curIndex: 0
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
        var a = this, r = a.data.curIndex, t = r + 1, e = wx.getStorageSync("brand_info"), n = a.data.orderlist, o = a.data.page, d = o[r];
        app.util.request({
            url: "entry/wxapp/GetRebateOrder",
            data: {
                bid: e.bid,
                ordertype: t,
                page: d
            },
            success: function(t) {
                if (console.log(t.data), 2 == t.data) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }); else {
                    var e = t.data;
                    n = n.concat(e), o[r] = d + 1, a.setData({
                        orderlist: n,
                        page: o
                    });
                }
            }
        });
    },
    chooseordertype: function(t) {
        var e = this, a = parseInt(t.currentTarget.dataset.index), r = a + 1, n = wx.getStorageSync("brand_info"), o = [ 1, 1, 1, 1 ];
        app.util.request({
            url: "entry/wxapp/GetRebateOrder",
            data: {
                bid: n.bid,
                ordertype: r
            },
            success: function(t) {
                console.log(t.data), 2 == t.data ? e.setData({
                    orderlist: [],
                    curIndex: a,
                    page: o
                }) : e.setData({
                    orderlist: t.data,
                    curIndex: a,
                    page: o
                });
            }
        });
    }
});