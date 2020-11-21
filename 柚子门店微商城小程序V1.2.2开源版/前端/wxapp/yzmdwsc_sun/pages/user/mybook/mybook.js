var app = getApp();

Page({
    data: {
        navTile: "我的预约",
        curIndex: 0,
        nav: [ "进行中", "已完成" ],
        curBargain: [ {
            ordernum: "2018032015479354825174",
            status: "1",
            img: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            title: "发财树绿萝栀子花海棠花卉盆栽",
            price: "2.50",
            oldprice: "3.00",
            num: "1",
            booktime: "周二 02-12 10:30"
        }, {
            ordernum: "2018032015479354825174",
            status: "1",
            img: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            title: "发财树绿萝栀子花海棠花卉盆栽",
            price: "2.50",
            oldprice: "3.00",
            num: "1",
            booktime: "周二 02-12 10:30"
        }, {
            ordernum: "2018032015479354825174",
            status: "1",
            img: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            title: "发财树绿萝栀子花海棠花卉盆栽",
            price: "2.50",
            oldprice: "3.00",
            num: "1",
            booktime: "周二 02-12 10:30"
        } ]
    },
    onLoad: function(t) {
        var e = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        var a = wx.getStorageSync("url");
        this.setData({
            curIndex: 0,
            url: a
        });
        var n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getBookOrder",
            cachetime: "0",
            data: {
                uid: n
            },
            success: function(t) {
                e.setData({
                    order: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    bargainTap: function(t) {
        var e = this, a = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: a
        });
        var n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getBookOrder",
            cachetime: "0",
            data: {
                uid: n,
                index: a
            },
            success: function(t) {
                console.log(t.data), e.setData({
                    order: t.data
                });
            }
        });
    },
    toBuy: function(t) {},
    toCancel: function(t) {
        var e = this, a = t.currentTarget.dataset.index, n = (e.data.curBargain, t.currentTarget.dataset.order_id), o = e.data.order, r = (a = t.currentTarget.dataset.index, 
        wx.getStorageSync("openid"));
        console.log(n), wx.showModal({
            title: "提示",
            content: "订单取消后将不再显示",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/cancelOrder",
                    cachetime: "0",
                    data: {
                        uid: r,
                        order_id: n
                    },
                    success: function(t) {
                        o[a].order_status = 7, e.setData({
                            order: o
                        });
                    }
                });
            }
        });
    },
    toDelete: function(t) {
        var e = this, a = t.currentTarget.dataset.index, n = e.data.curBargain;
        wx.showModal({
            title: "提示",
            content: "订单删除后将不再显示",
            success: function(t) {
                t.confirm && (n.splice(a, 1), e.setData({
                    curBargain: n
                }));
            }
        });
    },
    ToBookdet: function(t) {
        var e = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../bookDet/bookDet?order_id=" + e
        });
    },
    toIndex: function(t) {
        wx.redirectTo({
            url: "/yzmdwsc_sun/pages/index/index"
        });
    }
});