var app = getApp();

Page({
    data: {
        navTile: "商品详情",
        imgArr: [ "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152540565197.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152540565217.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152229433564.png" ],
        goodsDet: [ {
            title: "发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽",
            price: "399.00",
            freight: "免运费",
            detail: [ "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264562.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264579.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/15254126459.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264601.png" ]
        } ],
        guarantee: [ "正品保障", "超时赔付", "7天无忧退货" ],
        isIpx: app.globalData.isIpx,
        swiperIndex: 1
    },
    onLoad: function(t) {
        var o = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: o.data.navTile
        });
        var a = t.gid;
        o.setData({
            gid: a
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), o.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GoodsDetails",
            cachetime: "0",
            data: {
                id: a
            },
            success: function(t) {
                console.log(t), o.setData({
                    goodinfo: t.data.data
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
    onShareAppMessage: function(t) {
        return "button" === t.from && console.log(t), {
            title: this.data.goodinfo.goods_name,
            path: "yzmdwsc_sun/pages/index/bookDet/bookDet?gid=" + this.data.gid
        };
    },
    toIndex: function(t) {
        wx.redirectTo({
            url: "../index"
        });
    },
    toBookorder: function(t) {
        var o = this;
        app.util.request({
            url: "entry/wxapp/checkGoods",
            cachetime: "0",
            data: {
                gid: o.data.gid
            },
            success: function(t) {
                wx.navigateTo({
                    url: "../bookOrder/bookOrder?gid=" + o.data.gid
                });
            }
        });
    },
    swiperChange: function(t) {
        this.setData({
            swiperIndex: t.detail.current + 1
        });
    }
});