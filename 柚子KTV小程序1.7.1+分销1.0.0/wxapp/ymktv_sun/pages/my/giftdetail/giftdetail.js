var app = getApp();

Page({
    data: {
        indicatorDots: !1,
        autoplay: !1,
        interval: 5e3,
        duration: 1e3,
        bannerHeight: 0,
        showplay: 0,
        styleindex: 0
    },
    onLoad: function(t) {
        var s = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), s.url();
        var a = t.id;
        app.util.request({
            url: "entry/wxapp/integralDetails",
            cachetime: "0",
            data: {
                id: a
            },
            success: function(t) {
                console.log(t.data);
                var a = t.data.spec[0], e = t.data.specstock[0];
                s.setData({
                    details: t.data,
                    spec: a,
                    stock: e
                });
            }
        }), wx.getSystemInfo({
            success: function(t) {
                s.setData({
                    bannerHeight: 36 * t.screenWidth / 75
                });
            }
        });
    },
    url: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url2", t.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    bindSave: function(t) {
        var a = this;
        a.closeplay(), console.log(t), console.log(a.data);
        var e = t.detail.value.address, s = a.data.details.id, o = a.data.styleindex, i = a.data.spec, n = a.data.details.integral_price;
        console.log(i), console.log(o), "" != e ? wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/Duigift",
                    cachetime: "0",
                    data: {
                        openid: t.data,
                        id: s,
                        index: o,
                        spec: i,
                        address: e,
                        gift: n
                    },
                    success: function(t) {
                        1 == t.data ? (wx.showToast({
                            title: "兑换成功",
                            icon: "success",
                            duration: 2e3
                        }), wx.redirectTo({
                            url: "../../my/mygift/mygift"
                        })) : 2 == t.data ? wx.showToast({
                            title: "改款式库存不足！",
                            icon: "none",
                            duration: 2e3
                        }) : wx.showToast({
                            title: "积分不足!",
                            icon: "none",
                            duration: 2e3
                        });
                    }
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "请填写地址",
            showCancel: !1
        });
    },
    showplay: function() {
        this.data.showplay;
        this.setData({
            showplay: 1
        });
    },
    closeplay: function() {
        this.data.showplay;
        this.setData({
            showplay: 0
        });
    },
    chosetime: function(t) {
        var a = this, e = t.currentTarget.dataset.index, s = a.data.details.spec[e], o = a.data.details.specstock[e], i = a.data.styleindex;
        i = e, a.setData({
            styleindex: i,
            spec: s,
            stock: o
        });
    }
});