var app = getApp();

Page({
    data: {
        navTile: "预约",
        classify: [ "综合", "最新", "推荐" ],
        curIndex: 0,
        goodsList: [ {
            title: "发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽",
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            price: "399.00",
            bookNum: 6
        }, {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
            price: "399.00",
            bookNum: 6
        }, {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
            price: "399.00",
            bookNum: 6
        } ],
        show: "0",
        priceFlag: !0
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
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/getYuyueGoods",
            cachetime: "0",
            success: function(t) {
                e.setData({
                    goodList: t.data
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
    navChange: function(t) {
        var e = this, a = parseInt(t.currentTarget.dataset.index);
        if (3 == a) {
            var o = t.currentTarget.dataset.flag;
            console.log(o), e.setData({
                priceFlag: o
            }), o ? console.log("下") : console.log("上"), e.setData({
                show: 1,
                curIndex: a
            });
        } else e.setData({
            show: 0,
            curIndex: a,
            priceFlag: !0
        });
        app.util.request({
            url: "entry/wxapp/getYuyueGoods",
            cachetime: "0",
            data: {
                index: a,
                flag: o
            },
            success: function(t) {
                e.setData({
                    goodList: t.data
                });
            }
        });
    },
    toBookdet: function(t) {
        var e = parseInt(t.currentTarget.dataset.id);
        wx.navigateTo({
            url: "../bookDet/bookDet?gid=" + e
        });
    },
    toIndex: function(t) {
        wx.redirectTo({
            url: "/yzmdwsc_sun/pages/index/index"
        });
    }
});