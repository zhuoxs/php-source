var app = getApp();

Page({
    data: {
        curIndex: 0,
        arrLen: [ "0", "0" ],
        curbargain: [ {
            imgsrc: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152093045121.png",
            title: "单人中度受损发质拉直",
            minprice: "298.00",
            price: "600"
        }, {
            imgsrc: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152093045121.png",
            title: "单人中度受损发质拉直",
            minprice: "298.00",
            price: "600"
        } ],
        overbargain: []
    },
    onLoad: function(a) {
        var n = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var t = n.data.arrLen;
        0 < n.data.curbargain.length && (t[0] = "1"), 0 < n.data.overbargain.length && (t[1] = "1");
        var e = wx.getStorageSync("url");
        n.setData({
            arrLen: t,
            url: e
        });
        var r = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/bargainIng",
            cachetime: "30",
            data: {
                openid: r
            },
            success: function(a) {
                console.log(a), n.setData({
                    bargainlist: a.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/bargainEd",
            cachetime: "30",
            data: {
                openid: r
            },
            success: function(a) {
                console.log(a), n.setData({
                    bargainListEd: a.data
                });
            }
        });
    },
    gotoBargain: function(a) {
        console.log(a), wx.navigateTo({
            url: "../../bargain/detail/detail?id=" + a.currentTarget.dataset.id
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    bargainTap: function(a) {
        var n = parseInt(a.currentTarget.dataset.index);
        this.setData({
            curIndex: n
        });
    }
});