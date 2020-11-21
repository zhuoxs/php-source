var t = getApp();

Page({
    data: {
        info: "",
        isShow: !1,
        is_store: 0
    },
    onLoad: function(a) {
        var e = this;
        t.util.getUserInfo(function(a) {
            a.memberInfo ? (t.util.request({
                url: "entry/wxapp/Api",
                data: {
                    m: "ox_master",
                    r: "home.getInfo",
                    uid: a.memberInfo.uid
                },
                success: function(t) {
                    t.data.data && (e.setData({
                        info: t.data.data.info,
                        store: t.data.data.store
                    }), 1 == e.data.store.status && e.setData({
                        is_store: t.data.data.store.status
                    }));
                }
            }), wx.setStorageSync("uid", a.memberInfo.uid)) : e.hideDialog();
        });
    },
    onPullDownRefresh: function() {
        var a = this;
        t.util.getUserInfo(function(e) {
            e.memberInfo ? (t.util.request({
                url: "entry/wxapp/Api",
                data: {
                    m: "ox_master",
                    r: "home.getInfo",
                    uid: e.memberInfo.uid
                },
                success: function(t) {
                    t.data.data && (a.setData({
                        info: t.data.data.info,
                        store: t.data.data.store
                    }), a.data.store && a.setData({
                        is_store: t.data.data.store.status
                    })), wx.stopPullDownRefresh();
                }
            }), wx.setStorageSync("uid", e.memberInfo.uid)) : a.hideDialog();
        });
    },
    onShow: function() {},
    hideDialog: function() {
        this.setData({
            isShow: !this.data.isShow
        });
    },
    updateUserInfo: function(a) {
        var e = this;
        e.hideDialog(), t.util.getUserInfo(function(a) {
            t.util.request({
                url: "entry/wxapp/Api",
                data: {
                    m: "ox_master",
                    r: "home.getInfo",
                    uid: a.memberInfo.uid
                },
                success: function(t) {
                    t.data.data && e.setData({
                        info: t.data.data.info,
                        store: t.data.data.store
                    });
                }
            }), wx.setStorageSync("uid", a.memberInfo.uid);
        }, a.detail);
    },
    goStore: function() {
        this.data.store && "1" == this.data.store.status ? wx.navigateTo({
            url: "/pages/store/pages/manage/index"
        }) : wx.navigateTo({
            url: "/pages/store/pages/home/index"
        });
    },
    showModal: function(t) {
        this.setData({
            modalName: t.currentTarget.dataset.target
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
    },
    hideModal: function(t) {
        this.setData({
            modalName: null
        });
    },
    phoneCall: function() {
        wx.makePhoneCall({
            phoneNumber: this.data.info.phone
        });
    },
    moneylog: function(t) {
        wx.navigateTo({
            url: "/pages/me/money/index?id=" + t.currentTarget.dataset.id
        });
    }
});