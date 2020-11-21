var cdInterval, app = getApp(), tool = require("../../../../style/utils/countDown.js");

Page({
    data: {
        navTile: "我的拼团",
        curIndex: 0,
        nav: [ "拼团中", "已拼成", "拼团失败" ],
        curBargain: [ {
            ordernum: "2018032015479354825174",
            status: "1",
            img: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            title: "发财树绿萝栀子花海棠花卉盆栽",
            price: "2.50",
            oldprice: "3.00",
            num: "1",
            userNum: 2,
            endtime: "1526483891000",
            clock: ""
        }, {
            ordernum: "2018032015479354825174",
            status: "1",
            img: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            title: "发财树绿萝栀子花海棠花卉盆栽",
            price: "2.50",
            oldprice: "3.00",
            num: "1",
            userNum: 2,
            endtime: "1526483891000",
            clock: ""
        }, {
            ordernum: "2018032015479354825174",
            status: "1",
            img: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            title: "发财树绿萝栀子花海棠花卉盆栽",
            price: "2.50",
            oldprice: "3.00",
            num: "1",
            userNum: 2,
            endtime: "1526483891000",
            clock: ""
        } ]
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
        var e = wx.getStorageSync("url");
        this.setData({
            url: e
        }), wx.setNavigationBarTitle({
            title: this.data.navTile
        });
    },
    onReady: function() {},
    onShow: function() {
        var n = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getUserGroups",
            cachetime: "0",
            data: {
                openid: t,
                index: n.data.curIndex
            },
            success: function(t) {
                var a = t.data;
                cdInterval = setInterval(function() {
                    for (var t = 0; t < a.length; t++) {
                        var e = tool.countDown(n, a[t].endtime);
                        a[t].clock = e ? e[2] + " : " + e[3] + " : " + e[4] : "00 : 00 : 00", n.setData({
                            groups: a
                        });
                    }
                }, 1e3);
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(t) {
        if ("button" === t.from) {
            var e = t.target.dataset.order_id;
            return {
                title: t.target.dataset.gname,
                path: "yzmdwsc_sun/pages/index/groupjoin/groupjoin?order_id=" + e,
                success: function(t) {
                    console.log("转发成功");
                },
                fail: function(t) {
                    console.log("转发失败");
                }
            };
        }
    },
    bargainTap: function(t) {
        var e = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: e
        });
        var n = this, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getUserGroups",
            cachetime: "0",
            data: {
                openid: a,
                index: n.data.curIndex
            },
            success: function(t) {
                if (clearInterval(cdInterval), console.log(111111), n.setData({
                    groups: t.data
                }), clearInterval(cdInterval), 0 == e) {
                    var a = t.data;
                    cdInterval = setInterval(function() {
                        for (var t = 0; t < a.length; t++) {
                            var e = tool.countDown(n, a[t].endtime);
                            a[t].clock = e ? e[2] + " : " + e[3] + " : " + e[4] : "00 : 00 : 00", n.setData({
                                groups: a
                            });
                        }
                    }, 1e3);
                } else n.setData({
                    groups: t.data
                });
            }
        });
    },
    toBuy: function(t) {
        var e = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "../../index/goodsDet/goodsDet?gid=" + e
        });
    },
    togroupdet: function(t) {
        var e = t.currentTarget.dataset.order_id;
        wx.navigateTo({
            url: "../groupdet/groupdet?order_id=" + e
        });
    },
    toCancel: function(t) {
        var e = this, a = t.currentTarget.dataset.index, n = e.data.groups, o = t.currentTarget.dataset.id, r = wx.getStorageSync("openid");
        wx.showModal({
            title: "提示",
            content: "订单删除后将不再显示",
            success: function(t) {
                t.confirm && (n.splice(a, 1), app.util.request({
                    url: "entry/wxapp/delUserGroups",
                    cachetime: "0",
                    data: {
                        id: o,
                        openid: r
                    },
                    success: function(t) {
                        e.setData({
                            groups: n
                        });
                    }
                }));
            }
        });
    }
});