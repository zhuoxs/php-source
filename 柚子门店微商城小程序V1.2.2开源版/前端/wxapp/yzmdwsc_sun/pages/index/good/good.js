var app = getApp();

Page({
    data: {
        navTile: "好物",
        classify: [ "综合", "最新", "推荐", "专栏" ],
        curIndex: 0,
        goodsList: [ {
            title: "蝴蝶兰花苗蝴蝶兰花苗蝴蝶兰花苗蝴蝶兰花苗蝴蝶兰花苗蝴蝶兰花苗",
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531842309.png",
            desc: "发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽花卉盆栽发财树绿萝栀子花海棠花卉盆栽花卉盆栽发财树绿萝栀子花海棠花卉盆栽"
        }, {
            title: "蝴蝶兰花苗",
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531842319.png",
            desc: "发财花卉盆栽花卉盆栽发财树绿萝栀子花海棠花卉盆栽"
        } ]
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: a.data.navTile
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/getHaowuGoods",
            cachetime: "0",
            success: function(t) {
                a.setData({
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
            show: 0,
            curIndex: e,
            priceFlag: !0
        }), app.util.request({
            url: "entry/wxapp/getHaowuGoods",
            cachetime: "0",
            data: {
                index: e
            },
            success: function(t) {
                a.setData({
                    goodList: t.data
                });
            }
        });
    },
    toGooddet: function(t) {
        var a = parseInt(t.currentTarget.dataset.id);
        wx.navigateTo({
            url: "../goodDet/goodDet?gid=" + a
        });
    },
    toIndex: function(t) {
        wx.redirectTo({
            url: "/yzmdwsc_sun/pages/index/index"
        });
    }
});