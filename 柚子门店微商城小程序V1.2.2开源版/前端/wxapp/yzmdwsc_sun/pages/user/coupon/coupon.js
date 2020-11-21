var app = getApp();

Page({
    data: {
        navTile: "我的优惠券",
        curIndex: 0,
        nav: [ "线上优惠券", "门店优惠券" ],
        cards: [ {
            price: "30",
            minprice: "398",
            time: "2018.01.12-2018.02.12"
        }, {
            price: "30",
            minprice: "398",
            time: "2018.01.12-2018.02.12"
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
        }), wx.setNavigationBarTitle({
            title: this.data.navTile
        });
    },
    onReady: function() {},
    onShow: function() {
        var n = this, t = n.data.curIndex + 1, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getMyCoupon",
            cachetime: "0",
            data: {
                uid: a,
                signs: t
            },
            success: function(t) {
                console.log(t.data.data), n.setData({
                    coupon: t.data.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    bargainTap: function(t) {
        var n = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: n
        });
        var a = this, o = wx.getStorageSync("openid"), e = n + 1;
        app.util.request({
            url: "entry/wxapp/getMyCoupon",
            cachetime: "0",
            data: {
                uid: o,
                signs: e
            },
            success: function(t) {
                a.setData({
                    coupon: t.data.data
                });
            }
        });
    },
    toGoods: function(t) {
        wx.redirectTo({
            url: "../../shop/shop?currentIndex=1"
        });
    },
    toCoupondet: function(t) {
        var n = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../couponDet/couponDet?id=" + n
        });
    }
});