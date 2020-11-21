var app = getApp();

Page({
    data: {
        goods_img: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152634825519.png",
        goods_name: "199元美食套食套餐",
        goods_price: "199",
        mobile: "",
        jifen: "199"
    },
    onLoad: function(t) {
        var e = this;
        wx.setStorageSync("id", t.id), wx.setStorageSync("bid", t.bid), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        });
    },
    onShow: function() {
        var e = this, t = wx.getStorageSync("bid"), a = wx.getStorageSync("id");
        app.util.request({
            url: "entry/wxapp/FootData",
            cachetime: "0",
            data: {
                bid: t,
                id: a
            },
            success: function(t) {
                e.setData({
                    buildDrink: t.data
                });
            }
        });
    },
    bindSave: function(t) {
        var e = t.detail.value.tel, n = t.detail.value.room, o = t.detail.value.remark, r = this.data.buildDrink, c = wx.getStorageSync("bid");
        "" != n ? wx.getStorage({
            key: "openid",
            success: function(t) {
                var i = t.data;
                app.util.request({
                    url: "entry/wxapp/Orderarr",
                    cachetime: "30",
                    data: {
                        openid: i,
                        price: r.drink_price
                    },
                    success: function(t) {
                        var a = t.data.package;
                        wx.requestPayment({
                            timeStamp: t.data.timeStamp,
                            nonceStr: t.data.nonceStr,
                            package: t.data.package,
                            signType: "MD5",
                            paySign: t.data.paySign,
                            success: function(t) {
                                wx.getStorage({
                                    key: "openid",
                                    success: function(t) {
                                        app.util.request({
                                            url: "entry/wxapp/FootOrder",
                                            cachetime: "0",
                                            data: {
                                                id: r.id,
                                                openid: i,
                                                price: r.drink_price,
                                                integral: r.integral,
                                                b_name: r.b_name,
                                                drink_name: r.drink_name,
                                                tel: e,
                                                remark: o,
                                                room: n,
                                                bid: c,
                                                img: r.z_imgs
                                            },
                                            success: function(t) {
                                                console.log(t);
                                                var e = t.data;
                                                0 != e ? app.util.request({
                                                    url: "entry/wxapp/Paysuccess",
                                                    cachetime: "0",
                                                    data: {
                                                        prepay_id: a,
                                                        oid: e,
                                                        openid: i,
                                                        local: 2
                                                    },
                                                    success: function(t) {
                                                        console.log(t.data), wx.navigateTo({
                                                            url: "../../my/myorder/myorder"
                                                        });
                                                    }
                                                }) : wx.showToast({
                                                    title: "请核对您的信息！",
                                                    icon: "none",
                                                    duration: 0
                                                });
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function(t) {}
                        });
                    }
                });
            }
        }) : wx.showToast({
            title: "请输入包厢号！",
            icon: "none",
            duration: 2e3
        });
    },
    onReady: function() {},
    mobileInput: function(t) {
        this.setData({
            mobile: t.detail.value
        });
    },
    submit: function() {
        var t = this.data.mobile;
        if ("" == t) return wx.showToast({
            title: "手机号不能为空"
        }), !1;
        if (11 != t.length) return wx.showToast({
            title: "手机号长度有误！",
            icon: "success",
            duration: 1500
        }), !1;
        return /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/.test(t) ? void 0 : (wx.showToast({
            title: "手机号有误！",
            icon: "success",
            duration: 1500
        }), !1);
    },
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});