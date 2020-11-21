/*   time:2019-08-09 13:18:39*/
var app = getApp();
Page({
    data: {
        is_modal_Hidden: !0,
        user_id: "",
        is_share: "",
        order_id: "",
        bgurl: "http://img4.imgtn.bdimg.com/it/u=2066584298,1763950916&fm=26&gp=0.jpg"
    },
    onLoad: function(t) {
        var a = this;
        console.log(t), app.wxauthSetting();
        var e = t.id,
            n = t.bid,
            i = (a.data.user_id, a.data.order_id, a.data.is_share, wx.getStorageSync("openid"));
        t.user_id && t.order_id && t.is_share && a.setData({
            user_id: t.user_id,
            order_id: t.order_id,
            is_share: t.is_share
        }), e && app.util.request({
            url: "entry/wxapp/GetContent",
            showLoading: !1,
            data: {
                id: e,
                bid: n,
                openid: i,
                m: app.globalData.Plugin_fission
            },
            success: function(t) {
                console.log(t.data), 2 != t.data ? a.setData({
                    content: t.data
                }) : (wx.showToast({
                    title: "活动不存在！",
                    icon: "none",
                    duration: 2e3
                }), wx.reLaunch({
                    url: "/mzhk_sun/pages/index/index"
                }))
            }
        }), app.util.request({
            url: "entry/wxapp/GetSet",
            showLoading: !1,
            data: {
                m: app.globalData.Plugin_fission
            },
            success: function(t) {
                console.log(t.data), t.data.detailbanner ? a.setData({
                    bgurl: t.data.url_detailbanner
                }) : a.setData({
                    bgurl: "http://img4.imgtn.bdimg.com/it/u=2066584298,1763950916&fm=26&gp=0.jpg"
                })
            }
        })
    },
    onReady: function() {},
    onShow: function() {
        app.func.islogin(app, this)
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    callPhone: function(t) {
        var a = t.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: a
        })
    },
    getAddress: function(t) {
        var a = t.currentTarget.dataset.lat,
            e = t.currentTarget.dataset.lng,
            n = t.currentTarget.dataset.address;
        wx.openLocation({
            latitude: a - 0,
            longitude: e - 0,
            address: n,
            scale: 28
        })
    },
    toShop: function(t) {
        var a = parseInt(t.currentTarget.dataset.bid);
        wx.navigateTo({
            url: "/mzhk_sun/pages/index/shop/shop?id=" + a
        })
    },
    getCoupon: function(t) {
        var a = this,
            e = a.data.user_id,
            n = a.data.is_share,
            i = a.data.order_id,
            o = parseInt(t.currentTarget.dataset.fid),
            r = parseInt(t.currentTarget.dataset.bid),
            s = wx.getStorageSync("openid"),
            d = parseInt(t.currentTarget.dataset.isreceive),
            u = parseInt(t.currentTarget.dataset.isover);
        if (1 == d || 1 == u) return !1;
        app.util.request({
            url: "entry/wxapp/AddFission",
            data: {
                fid: o,
                bid: r,
                user_id: e,
                is_share: n,
                order_id: i,
                openid: s,
                m: app.globalData.Plugin_fission
            },
            showLoading: !1,
            success: function(t) {
                if (console.log(t), 2 == t.data || 11 == t.data) return 11 == t.data ? wx.showToast({
                    title: t.data.message,
                    icon: "none",
                    duration: 2e3
                }) : wx.showToast({
                    title: "领取失败！",
                    icon: "none",
                    duration: 2e3
                }), !1;
                wx.showToast({
                    title: "领取成功！",
                    icon: "none"
                }), wx.navigateTo({
                    url: "/mzhk_sun/plugin/fission/coupon/coupon?fid=" + o + "&bid=" + r
                })
            }
        })
    },
    toIndex: function(t) {
        var a = parseInt(t.currentTarget.dataset.fid),
            e = parseInt(t.currentTarget.dataset.bid);
        wx.navigateTo({
            url: "/mzhk_sun/plugin/fission/coupon/coupon?fid=" + a + "&bid=" + e
        })
    },
    updateUserInfo: function(t) {
        app.wxauthSetting()
    },
    toIndex2: function(t) {
        wx.reLaunch({
            url: "/mzhk_sun/pages/index/index"
        })
    }
});