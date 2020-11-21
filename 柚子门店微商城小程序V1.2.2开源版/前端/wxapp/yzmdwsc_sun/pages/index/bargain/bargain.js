var cdInterval, tool = require("../../../../style/utils/countDown.js"), app = getApp();

Page({
    data: {
        navTile: "砍价",
        classify: [ "综合", "最新", "推荐" ],
        curIndex: 0,
        goodsList: [ {
            title: "发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽",
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            price: "399.00",
            oldPrice: "500.00",
            barNum: 60,
            endtime: "1526483891000",
            clock: ""
        }, {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
            price: "399.00",
            oldPrice: "500.00",
            barNum: 60,
            endtime: "1526483893000",
            clock: ""
        }, {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
            price: "399.00",
            oldPrice: "500.00",
            barNum: 60,
            endtime: "1526483899000",
            clock: ""
        } ],
        show: "0",
        priceFlag: !0,
        remind: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152542355884.png"
    },
    onLoad: function(t) {
        var n = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: n.data.navTile
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), n.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/getBargainGoods",
            cachetime: "0",
            success: function(t) {
                n.setData({
                    goodList: t.data
                });
                var a = t.data;
                cdInterval = setInterval(function() {
                    for (var t = 0; t < a.length; t++) {
                        var e = tool.countDown(n, a[t].endtime);
                        a[t].clock = e ? e[2] + " : " + e[3] + " : " + e[4] : "00 : 00 : 00", n.setData({
                            goodList: a
                        });
                    }
                }, 1e3);
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
    navChange: function(t) {
        var n = this, e = parseInt(t.currentTarget.dataset.index);
        if (clearInterval(cdInterval), 3 == e) {
            var a = t.currentTarget.dataset.flag;
            n.setData({
                priceFlag: a
            }), a ? console.log("下") : console.log("上"), n.setData({
                show: 1,
                curIndex: e
            });
        } else n.setData({
            show: 0,
            curIndex: e,
            priceFlag: !0
        });
        app.util.request({
            url: "entry/wxapp/getBargainGoods",
            cachetime: "0",
            data: {
                index: e,
                flag: a
            },
            success: function(t) {
                var a = t.data;
                cdInterval = setInterval(function() {
                    for (var t = 0; t < a.length; t++) {
                        var e = tool.countDown(n, a[t].endtime);
                        a[t].clock = e ? e[2] + " : " + e[3] + " : " + e[4] : "00 : 00 : 00";
                    }
                    n.setData({
                        goodList: a
                    });
                }, 1e3);
            }
        });
    },
    toBardet: function(t) {
        var e = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "../bardet/bardet?gid=" + e
        });
    },
    toIndex: function(t) {
        wx.redirectTo({
            url: "/yzmdwsc_sun/pages/index/index"
        });
    }
});