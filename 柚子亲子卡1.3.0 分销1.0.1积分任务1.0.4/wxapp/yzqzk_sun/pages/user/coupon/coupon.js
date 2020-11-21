var app = getApp();

Page({
    data: {
        navTile: "卡券",
        cards: [ {
            price: "30",
            remark: "满398可用",
            time: "2018.01.12-2018.02.12",
            types: 1
        }, {
            price: "柚子万达城体验券",
            remark: "免费体验券",
            time: "2018.01.12-2018.02.12",
            types: 2
        } ],
        coupon: [],
        curPage: 1,
        pagesize: 6
    },
    onLoad: function(t) {
        wx.setNavigationBarTitle({
            title: this.data.navTile
        });
        var a = wx.getStorageSync("setting");
        a ? wx.setNavigationBarColor({
            frontColor: a.fontcolor,
            backgroundColor: a.color
        }) : app.get_setting(!0).then(function(t) {
            wx.setNavigationBarColor({
                frontColor: t.fontcolor,
                backgroundColor: t.color
            });
        });
    },
    onReady: function() {},
    onShow: function() {
        this.get_coupon();
    },
    get_coupon: function() {
        var e = this, n = e.data.curPage, i = e.data.coupon;
        app.get_openid().then(function(t) {
            app.util.request({
                url: "entry/wxapp/getMyCoupon",
                cachetime: "0",
                data: {
                    openid: t,
                    page: n,
                    pagesize: e.data.pagesize
                },
                success: function(t) {
                    var a = t.data.data.length == e.data.pagesize;
                    if (1 == n) i = t.data.data; else for (var o in t.data.data) i.push(t.data.data[o]);
                    n += 1, console.log(t.data.data), e.setData({
                        coupon: i,
                        curPage: n,
                        hasMore: a
                    });
                }
            });
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        this.data.hasMore ? this.get_coupon() : wx.showToast({
            title: "没有更多优惠券啦~",
            icon: "none"
        });
    },
    toCoupondet: function(t) {
        var a = t.currentTarget.dataset.sign, o = t.currentTarget.dataset.id;
        2 == a ? wx.navigateTo({
            url: "../coupondet/coupondet?id=" + o
        }) : wx.showModal({
            title: "提示",
            content: "该优惠券下单时使用",
            showCancel: !1
        });
    }
});