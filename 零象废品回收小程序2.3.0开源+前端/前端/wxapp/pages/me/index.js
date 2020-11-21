function e(e, a, t) {
    return a in e ? Object.defineProperty(e, a, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[a] = t, e;
}

var a, t = getApp();

Page((a = {
    data: {
        info: "",
        isShow: !1,
        modalName: "",
        uid: wx.getStorageSync("uid"),
        isJiedan: !1
    },
    onLoad: function(e) {
        var a = this;
        t.util.getUserInfo(function(e) {
            e.memberInfo ? (t.util.request({
                url: "entry/wxapp/Api",
                data: {
                    m: "ox_reclaim",
                    r: "me.getInfo",
                    uid: e.memberInfo.uid
                },
                success: function(e) {
                    e.data.data && (a.setData({
                        info: e.data.data
                    }), 1 == a.data.info.jiedan && a.setData({
                        isJiedan: !0
                    }));
                }
            }), wx.setStorageSync("uid", e.memberInfo.uid)) : a.hideDialog();
        });
    },
    setting: function() {
        wx.navigateTo({
            url: "/pages/me/set/index"
        });
    },
    onPullDownRefresh: function() {
        var e = this;
        t.util.getUserInfo(function(a) {
            a.memberInfo ? (t.util.request({
                url: "entry/wxapp/Api",
                data: {
                    m: "ox_reclaim",
                    r: "me.getInfo",
                    uid: a.memberInfo.uid
                },
                success: function(a) {
                    a.data.data && (e.setData({
                        info: a.data.data
                    }), 1 == e.data.info.jiedan && e.setData({
                        isJiedan: !0
                    })), wx.stopPullDownRefresh();
                }
            }), wx.setStorageSync("uid", a.memberInfo.uid)) : e.hideDialog();
        });
    },
    onShow: function() {},
    address: function() {
        wx.navigateTo({
            url: "/pages/me/address/index"
        });
    },
    hideDialog: function() {
        this.setData({
            isShow: !this.data.isShow
        });
    },
    updateUserInfo: function(e) {
        var a = this;
        a.hideDialog(), t.util.getUserInfo(function(e) {
            t.util.request({
                url: "entry/wxapp/Api",
                data: {
                    m: "ox_reclaim",
                    r: "me.getInfo",
                    uid: e.memberInfo.uid
                },
                success: function(e) {
                    e.data.data && (a.setData({
                        info: e.data.data
                    }), 1 == a.data.info.jiedan && a.setData({
                        isJiedan: !0
                    }));
                }
            }), wx.setStorageSync("uid", e.memberInfo.uid);
        }, e.detail);
    },
    goStore: function() {
        this.data.store && "1" == this.data.store.status ? wx.navigateTo({
            url: "/pages/store/pages/manage/index"
        }) : wx.navigateTo({
            url: "/pages/store/pages/home/index"
        });
    },
    showModal: function(e) {
        this.setData({
            modalName: e.currentTarget.dataset.target
        });
    },
    hideModal: function(e) {
        this.setData({
            modalName: null
        });
    },
    collect: function() {
        wx.navigateTo({
            url: "/pages/me/collect/index"
        });
    },
    suggest: function() {
        wx.navigateTo({
            url: "/pages/me/suggest/index"
        });
    },
    refund: function() {
        wx.navigateTo({
            url: "/pages/me/refund/index"
        });
    },
    richtext: function() {
        wx.navigateTo({
            url: "/pages/me/richtext/index?type=2"
        });
    },
    about: function() {
        wx.navigateTo({
            url: "/pages/me/about/index"
        });
    },
    toRuzhuo: function() {
        this.data.store && "1" == this.data.store.status ? wx.navigateTo({
            url: "/pages/store/pages/manage/index"
        }) : wx.navigateTo({
            url: "/pages/store/pages/home/index"
        });
    }
}, e(a, "hideModal", function(e) {
    this.setData({
        modalName: null
    });
}), e(a, "phoneCall", function() {
    wx.makePhoneCall({
        phoneNumber: this.data.info.store_phone
    });
}), e(a, "moneylog", function(e) {
    wx.navigateTo({
        url: "/pages/me/moneylog/index"
    });
}), e(a, "jifenlog", function(e) {
    wx.navigateTo({
        url: "/pages/me/jifenlog/index"
    });
}), a));