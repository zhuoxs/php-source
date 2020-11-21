var app = getApp();

Page({
    data: {
        navTile: "好物详情",
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        goods: [],
        isIpx: app.globalData.isIpx
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
        });
        var o = t.gid;
        a.setData({
            gid: o
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GoodsDetails",
            cachetime: "0",
            data: {
                id: o
            },
            success: function(t) {
                console.log(t), a.setData({
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
            path: "yzmdwsc_sun/pages/index/goodDet/goodDet?gid=" + this.data.gid
        };
    },
    toIndex: function(t) {
        wx.redirectTo({
            url: "../index"
        });
    },
    toShop: function(t) {
        var o = t.currentTarget.dataset.gid;
        app.util.request({
            url: "entry/wxapp/GoodsDetails",
            cachetime: "0",
            data: {
                id: o
            },
            success: function(t) {
                var a = t.data.data.lid;
                1 == a || 2 == a || 3 == a ? wx.navigateTo({
                    url: "../goodsDet/goodsDet?gid=" + o
                }) : 4 == a ? wx.navigateTo({
                    url: "../groupDet/groupDet?gid=" + o
                }) : 5 == a ? wx.navigateTo({
                    url: "../bardet/bardet?gid=" + o
                }) : 6 == a ? wx.navigateTo({
                    url: "../limitDet/limitDet?gid=" + o
                }) : 7 == a && wx.navigateTo({
                    url: "../shareDet/shareDet?gid=" + o
                });
            }
        });
    }
});