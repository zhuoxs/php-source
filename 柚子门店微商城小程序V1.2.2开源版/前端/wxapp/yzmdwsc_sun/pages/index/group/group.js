var app = getApp();

Page({
    data: {
        navTile: "拼团",
        classify: [ "综合", "最新", "推荐" ],
        curIndex: 0,
        goodsList: [ {
            title: "发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽",
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            price: "399.00",
            groupNum: 6,
            userNum: 2,
            discount: 20
        }, {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
            price: "399.00",
            groupNum: 6,
            userNum: 2,
            discount: 20
        }, {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
            price: "399.00",
            groupNum: 6,
            userNum: 2,
            discount: 20
        } ],
        show: "0",
        priceFlag: !0,
        remind: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152542355884.png"
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
            url: "entry/wxapp/getGroupGoods",
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
        var a = this, e = parseInt(t.currentTarget.dataset.index);
        if (3 == e) {
            var o = t.currentTarget.dataset.flag;
            a.setData({
                priceFlag: o
            }), o ? console.log("下") : console.log("上"), a.setData({
                show: 1,
                curIndex: e
            });
        } else a.setData({
            show: 0,
            curIndex: e,
            priceFlag: !0
        });
        app.util.request({
            url: "entry/wxapp/getGroupGoods",
            cachetime: "0",
            data: {
                index: e,
                flag: o
            },
            success: function(t) {
                var e = t.data;
                a.setData({
                    goodList: e
                });
            }
        });
    },
    toGroupdet: function(t) {
        var e = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "../groupDet/groupDet?gid=" + e
        });
    },
    toIndex: function(t) {
        wx.redirectTo({
            url: "/yzmdwsc_sun/pages/index/index"
        });
    }
});