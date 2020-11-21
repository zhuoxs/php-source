var app = getApp();

Page({
    data: {
        shop: {}
    },
    onLoad: function(t) {
        var o = this;
        app.get_imgroot().then(function(t) {
            o.setData({
                imgroot: t
            });
        });
        var e = wx.getStorageSync("setting");
        e ? wx.setNavigationBarColor({
            frontColor: e.fontcolor,
            backgroundColor: e.color
        }) : app.get_setting(!0).then(function(t) {
            wx.setNavigationBarColor({
                frontColor: t.fontcolor,
                backgroundColor: t.color
            });
        }), o.setData({
            sid: t.id
        });
    },
    onReady: function() {},
    onShow: function() {
        var o = this;
        app.get_openid().then(function(t) {
            app.util.request({
                url: "entry/wxapp/getStoreDetail",
                cachetime: "10",
                data: {
                    openid: t,
                    id: o.data.sid
                },
                success: function(t) {
                    o.setData({
                        shop: t.data
                    }), wx.setNavigationBarTitle({
                        title: t.data.store_name
                    });
                }
            });
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toDialog: function(t) {
        wx.makePhoneCall({
            phoneNumber: this.data.shop.tel
        });
    },
    toSwiperAd: function(t) {
        var o = t.currentTarget.dataset.url;
        "" != o && wx.navigateTo({
            url: o
        });
    },
    receRards: function(t) {
        var e = this, n = e.data.shop, a = t.currentTarget.dataset.idx, i = t.currentTarget.dataset.id, o = t.currentTarget.dataset.status, s = t.currentTarget.dataset.vip;
        "2" == o ? wx.showModal({
            title: "提示",
            content: "您已经领取过该优惠券啦~",
            showCancel: !1
        }) : 1 == o ? wx.showModal({
            title: "提示",
            content: "优惠券已被抢光啦~下次早点来",
            showCancel: !1
        }) : "0" == o && app.get_openid().then(function(o) {
            1 == s ? app.get_user_vip().then(function(t) {
                t == s ? app.util.request({
                    url: "entry/wxapp/receiveCoupon",
                    data: {
                        openid: o,
                        coupon_id: i
                    },
                    cachetime: "0",
                    success: function(t) {
                        console.log(t.data), wx.showModal({
                            title: "提示",
                            content: "恭喜你，领取成功",
                            showCancel: !1,
                            success: function(t) {
                                n.coupon_list[a].status = 2, e.setData({
                                    shop: n
                                });
                            }
                        });
                    }
                }) : wx.showModal({
                    title: "",
                    content: "您尚未开通车友会员",
                    confirmText: "去开通",
                    confirmColor: "#ff5e5e",
                    success: function(t) {
                        t.confirm && wx.navigateTo({
                            url: "/yzcyk_sun/pages/member/joinmember/joinmember"
                        });
                    }
                });
            }) : app.util.request({
                url: "entry/wxapp/receiveCoupon",
                data: {
                    openid: o,
                    coupon_id: i
                },
                cachetime: "0",
                success: function(t) {
                    console.log(t.data), wx.showModal({
                        title: "提示",
                        content: "恭喜你，领取成功",
                        showCancel: !1,
                        success: function(t) {
                            n.coupon_list[a].status = 2, e.setData({
                                shop: n
                            });
                        }
                    });
                }
            });
        });
    },
    toMap: function(t) {
        var o = parseFloat(this.data.shop.latitude), e = parseFloat(this.data.shop.longitude);
        wx.getLocation({
            type: "gcj02",
            success: function(t) {
                wx.openLocation({
                    latitude: o,
                    longitude: e,
                    scale: 28
                });
            }
        });
    }
});