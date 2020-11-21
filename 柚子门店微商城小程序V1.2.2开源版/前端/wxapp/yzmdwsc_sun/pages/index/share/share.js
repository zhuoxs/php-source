var app = getApp();

Page({
    data: {
        navTile: "分享",
        classify: [ "综合", "最新", "推荐" ],
        curIndex: 0,
        shareList: [ {
            title: "发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽",
            bgSrc: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531162021.png",
            shareprice: "0.15"
        }, {
            title: "发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽",
            bgSrc: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531162021.png",
            shareprice: "0.15"
        }, {
            title: "发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽",
            bgSrc: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531162021.png",
            shareprice: "0.15"
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
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/getShareGoods",
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
        a.setData({
            curIndex: e
        }), app.util.request({
            url: "entry/wxapp/getShareGoods",
            cachetime: "0",
            data: {
                index: e
            },
            success: function(t) {
                var e = t.data;
                a.setData({
                    goodList: e
                });
            }
        });
    },
    toSharedet: function(t) {
        var e = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "../shareDet/shareDet?gid=" + e
        });
    },
    toIndex: function(t) {
        wx.redirectTo({
            url: "/yzmdwsc_sun/pages/index/index"
        });
    }
});