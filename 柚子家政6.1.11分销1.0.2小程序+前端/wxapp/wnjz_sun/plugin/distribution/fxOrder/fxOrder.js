var wxbarcode = require("../../../../style/utils/index.js"), app = getApp();

Page({
    data: {
        curIndex: 0,
        orderCurIndex: 0,
        bignav: [ "普通订单", "砍价订单" ],
        bignavtype: [ 1, 2 ],
        nav: [ "全部", "待付款", "已付款", "完成" ],
        statusstr: [ "", "订单取消", "待付款", "已付款", "待发货", "已完成", "待发货" ],
        status: [ 0, 2, 3, 5 ],
        page: [ 1, 1, 1, 1 ],
        orderlist: [],
        distribution_set: []
    },
    onLoad: function(t) {
        var e = this, a = app.getSiteUrl();
        e.setData({
            url: a
        });
        var r = wx.getStorageSync("System");
        wx.setNavigationBarColor({
            frontColor: r.fontcolor ? r.fontcolor : "#000000",
            backgroundColor: r.color ? r.color : "#ffffff",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var d = wx.getStorageSync("openid"), n = wx.getStorageSync("users"), o = e.data.orderCurIndex, s = e.data.bignavtype[o], i = e.data.curIndex, u = e.data.status[i];
        app.util.request({
            url: "entry/wxapp/getDistributionOrder",
            data: {
                ordertype: s,
                orderstatus: u,
                openid: d,
                uid: n.id,
                m: app.globalData.Plugin_distribution
            },
            success: function(t) {
                console.log("订单数据"), console.log(t.data), 2 == t.data ? e.setData({
                    orderlist: []
                }) : e.setData({
                    orderlist: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 1
            },
            showLoading: !1,
            success: function(t) {
                var a = t.data;
                2 != a && e.setData({
                    distribution_set: a
                });
            }
        });
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var a = this, t = wx.getStorageSync("openid"), e = wx.getStorageSync("users"), r = a.data.orderCurIndex, d = a.data.bignavtype[r], n = a.data.curIndex, o = a.data.status[n], s = a.data.page, i = s[n], u = a.data.orderlist;
        app.util.request({
            url: "entry/wxapp/getDistributionOrder",
            data: {
                ordertype: d,
                orderstatus: o,
                openid: t,
                uid: e.id,
                page: i,
                m: app.globalData.Plugin_distribution
            },
            success: function(t) {
                2 == t.data ? wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }) : (u = u.concat(t.data), s[n] = i + 1, a.setData({
                    orderlist: u,
                    page: s
                }));
            }
        });
    },
    bargainTap: function(t) {
        var a = parseInt(t.currentTarget.dataset.index), e = this, r = [ 1, 1, 1, 1 ], d = wx.getStorageSync("openid"), n = wx.getStorageSync("users"), o = e.data.orderCurIndex, s = e.data.bignavtype[o], i = e.data.status[a];
        app.util.request({
            url: "entry/wxapp/getDistributionOrder",
            data: {
                ordertype: s,
                orderstatus: i,
                openid: d,
                uid: n.id,
                m: app.globalData.Plugin_distribution
            },
            success: function(t) {
                2 == t.data ? e.setData({
                    orderlist: [],
                    curIndex: a,
                    page: r
                }) : e.setData({
                    orderlist: t.data,
                    curIndex: a,
                    page: r
                });
            }
        }), e.setData({
            curIndex: a
        });
    },
    chooseordertype: function(t) {
        var a = parseInt(t.currentTarget.dataset.index), e = this, r = [ 1, 1, 1, 1 ], d = wx.getStorageSync("openid"), n = wx.getStorageSync("users"), o = e.data.bignavtype[a], s = e.data.status[0];
        app.util.request({
            url: "entry/wxapp/getDistributionOrder",
            data: {
                ordertype: o,
                orderstatus: s,
                openid: d,
                uid: n.id,
                m: app.globalData.Plugin_distribution
            },
            success: function(t) {
                2 == t.data ? e.setData({
                    orderlist: [],
                    curIndex: 0,
                    orderCurIndex: a,
                    page: r
                }) : e.setData({
                    orderlist: t.data,
                    curIndex: 0,
                    orderCurIndex: a,
                    page: r
                });
            }
        });
    },
    showGoods: function(t) {
        var a = parseInt(t.currentTarget.dataset.index), e = this.data.orderlist;
        e[a].hidden = !e[a].hidden, this.setData({
            orderlist: e
        });
    }
});