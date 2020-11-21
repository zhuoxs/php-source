var app = getApp();

Page({
    data: {
        postData: [ "快递", "到店取货" ],
        flag: !0,
        addressData: [],
        addNew: [],
        cid: "",
        payData: ""
    },
    onLoad: function(e) {
        console.log(e);
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/getActiveList",
                    cachetime: "30",
                    data: {
                        id: e.jika
                    },
                    success: function(t) {
                        console.log(t), a.setData({
                            active: t.data
                        });
                    }
                });
            }
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), console.log(e), a.urls();
    },
    urls: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        });
    },
    selectPost: function(t) {
        console.log(t), this.setData({
            currentSelect: t.currentTarget.dataset.index
        }), 1 == t.currentTarget.dataset.index || wx.showToast({
            title: "暂不支持快递！",
            icon: "none",
            duration: 2e3
        });
    },
    message: function(t) {
        var e = t.detail.value;
        this.setData({
            msg: e
        });
    },
    consignee: function(t) {
        var e = t.detail.value;
        console.log(e), this.setData({
            consignee: e
        });
    },
    tel: function(t) {
        var e = t.detail.value;
        this.setData({
            tel: e
        });
    },
    onReady: function() {},
    toPay: function(t) {
        console.log(t);
        var e = t.currentTarget.dataset.consignee, a = t.currentTarget.dataset.msg, o = t.currentTarget.dataset.tel, n = t.currentTarget.dataset.id;
        console.log(n);
        var s = this, i = s.data.flag;
        console.log(i), e && o ? app.util.request({
            url: "entry/wxapp/isReceiveGift",
            data: {
                id: n,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                console.log(t), 1 == t.data ? wx.showToast({
                    title: "您已领取！"
                }) : 1 == i ? (s.setData({
                    flag: !1
                }), console.log(i), wx.getStorage({
                    key: "openid",
                    success: function(t) {
                        app.util.request({
                            url: "entry/wxapp/jikaOrder",
                            cachetime: "30",
                            data: {
                                consignee: e,
                                msg: a,
                                tel: o,
                                id: n,
                                uid: t.data
                            },
                            success: function(t) {
                                console.log(t), wx.showToast({
                                    title: "领取成功！",
                                    icon: "success",
                                    duration: 2e3,
                                    mask: !0,
                                    success: function(t) {
                                        wx.redirectTo({
                                            url: "../first/index"
                                        });
                                    },
                                    fail: function(t) {},
                                    complete: function(t) {}
                                });
                            }
                        });
                    }
                })) : wx.showToast({
                    title: "请勿重复提交请求！",
                    icon: "none"
                });
            }
        }) : wx.showToast({
            title: "请填写收货人和联系电话",
            icon: "none"
        });
    },
    goToAddress: function() {
        wx.navigateTo({
            url: "../address-add/details"
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});