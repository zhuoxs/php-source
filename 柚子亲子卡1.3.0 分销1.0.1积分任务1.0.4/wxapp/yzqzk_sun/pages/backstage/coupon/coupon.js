var app = getApp();

Page({
    data: {},
    onLoad: function(t) {
        this.setData({
            hxopenid: t.uid
        });
        var o = t.id, n = wx.getStorageSync("setting");
        n ? wx.setNavigationBarColor({
            frontColor: n.fontcolor,
            backgroundColor: n.color
        }) : app.get_setting(!0).then(function(t) {
            wx.setNavigationBarColor({
                frontColor: t.fontcolor,
                backgroundColor: t.color
            });
        }), this.getcoupondetail(o, t.uid);
    },
    getcoupondetail: function(e, t) {
        var a = this;
        app.get_openid().then(function(n) {
            app.util.request({
                url: "entry/wxapp/getCouponDetail",
                cachetime: "0",
                data: {
                    id: e,
                    openid: t
                },
                success: function(t) {
                    console.log(t.data);
                    var o = t.data.data;
                    app.util.request({
                        url: "entry/wxapp/getStoreDetail",
                        cachetime: "0",
                        data: {
                            openid: n,
                            id: o.store_id
                        },
                        success: function(t) {
                            console.log(t.data), a.setData({
                                coupondetail: o,
                                store: t.data,
                                id: e
                            });
                        }
                    });
                }
            });
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toConfirm: function(t) {
        var o = this, n = t.currentTarget.dataset.id;
        app.get_openid().then(function(t) {
            app.util.request({
                url: "entry/wxapp/checkUserCoupon",
                cachetime: "0",
                data: {
                    id: n,
                    uid: t
                },
                success: function(t) {
                    0 == t.data.errcode && wx.showModal({
                        title: "提示",
                        content: t.data.errmsg,
                        showCancel: !1,
                        success: function(t) {
                            o.getcoupondetail(n, o.data.hxopenid);
                        }
                    });
                }
            });
        });
    },
    toOrderlist: function(t) {
        wx.navigateBack({});
    },
    toReconfirm: function(t) {
        wx.showToast({
            title: "该优惠券已核销",
            icon: "none",
            duration: 3e3
        });
    }
});