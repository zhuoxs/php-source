/*   time:2019-08-09 13:18:39*/
var app = getApp();
Page({
    data: {
        curIndex: 0,
        orderCurIndex: 0,
        bignav: ["普通订单", "砍价订单", "拼团订单", "抢购订单", "会员卡", "商家入驻", "线下付", "次卡", "优惠券", "配送订单"],
        bignavtype: [1, 2, 3, 4, 6, 7, 10, 12, 13, 14],
        nav: ["全部", "待付款", "已付款", "完成"],
        statusstr: ["", "订单取消", "待付款", "已付款", "待发货", "已完成", "待发货", "已付款，因商户号原因导致失败"],
        status: [0, 2, 3, 5],
        page: [1, 1, 1, 1],
        orderlist: [],
        distribution_set: [],
        deliveryStatus: [0, 2, 3, 4, 5],
        deliveryNav: ["全部", "待支付", "待配送", "配送中", "完成/售后"],
        deliveryStatusstr: ["", "已取消订单", "待支付", "待配送", "配送中", "已完成"]
    },
    onLoad: function(t) {
        var e = this,
            a = app.getSiteUrl();
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
        var d = wx.getStorageSync("openid"),
            n = wx.getStorageSync("users"),
            i = e.data.orderCurIndex,
            o = e.data.bignavtype[i],
            s = e.data.curIndex,
            u = e.data.status[s];
        app.util.request({
            url: "entry/wxapp/getDistributionOrder",
            data: {
                ordertype: o,
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
                })
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
                })
            }
        })
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var a = this,
            t = wx.getStorageSync("openid"),
            e = wx.getStorageSync("users"),
            r = a.data.orderCurIndex,
            d = a.data.bignavtype[r],
            n = 0 == a.data.curIndex ? 0 : 14 == a.data.bignavtype[a.data.orderCurIndex] ? a.data.curIndex + 1 : a.data.curIndex,
            i = 14 == a.data.bignavtype[a.data.orderCurIndex] ? a.data.deliveryStatus[n] : a.data.status[n],
            o = a.data.page,
            s = o[n],
            u = a.data.orderlist;
        app.util.request({
            url: "entry/wxapp/getDistributionOrder",
            data: {
                ordertype: d,
                orderstatus: i,
                openid: t,
                uid: e.id,
                page: s,
                m: app.globalData.Plugin_distribution
            },
            success: function(t) {
                console.log("订单数据"), console.log(t.data), 2 == t.data ? wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }) : (u = u.concat(t.data), o[n] = s + 1, a.setData({
                    orderlist: u,
                    page: o
                }))
            }
        })
    },
    bargainTap: function(t) {
        var a = parseInt(t.currentTarget.dataset.index),
            e = this,
            r = [1, 1, 1, 1],
            d = wx.getStorageSync("openid"),
            n = wx.getStorageSync("users"),
            i = e.data.orderCurIndex,
            o = e.data.bignavtype[i],
            s = e.data.status[a];
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
                    curIndex: a,
                    page: r
                }) : e.setData({
                    orderlist: t.data,
                    curIndex: a,
                    page: r
                })
            }
        }), e.setData({
            curIndex: a
        })
    },
    bargainTaps: function(t) {
        var a = parseInt(t.currentTarget.dataset.index),
            e = this,
            r = [1, 1, 1, 1],
            d = wx.getStorageSync("openid"),
            n = wx.getStorageSync("users"),
            i = e.data.orderCurIndex,
            o = e.data.bignavtype[i],
            s = e.data.deliveryStatus[a];
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
                    curIndex: a,
                    page: r
                }) : e.setData({
                    orderlist: t.data,
                    curIndex: a,
                    page: r
                })
            }
        }), e.setData({
            curIndex: a
        })
    },
    chooseordertype: function(t) {
        var a = parseInt(t.currentTarget.dataset.index),
            e = this,
            r = [1, 1, 1, 1],
            d = wx.getStorageSync("openid"),
            n = wx.getStorageSync("users"),
            i = e.data.bignavtype[a],
            o = 14 == i ? e.data.deliveryStatus[0] : e.data.status[0];
        app.util.request({
            url: "entry/wxapp/getDistributionOrder",
            data: {
                ordertype: i,
                orderstatus: o,
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
                })
            }
        })
    },
    showGoods: function(t) {
        var a = parseInt(t.currentTarget.dataset.index),
            e = this.data.orderlist;
        e[a].hidden = !e[a].hidden, this.setData({
            orderlist: e
        })
    }
});