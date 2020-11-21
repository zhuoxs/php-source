var a = getApp();

Page({
    data: {
        phonecall: "13188888888",
        info: [],
        publish: 0
    },
    onLoad: function() {
        var t = this;
        a.util.getUserInfo(function(e) {
            console.log(e), e.memberInfo ? (a.util.request({
                url: "entry/wxapp/Api",
                data: {
                    m: "ox_reathouse",
                    r: "user.getInfo",
                    uid: e.memberInfo.uid
                },
                success: function(a) {
                    a.data.data && t.setData({
                        info: a.data.data.info,
                        publish: a.data.data.info.publish
                    });
                }
            }), wx.setStorageSync("uid", e.memberInfo.uid)) : t.hideDialog();
        });
    },
    updateUserInfo: function(t) {
        var e = this;
        e.hideDialog(), t.detail.userInfo && a.util.getUserInfo(function(t) {
            a.util.request({
                url: "entry/wxapp/Api",
                data: {
                    m: "ox_reathouse",
                    r: "user.getInfo",
                    uid: t.memberInfo.uid
                },
                success: function(a) {
                    a.data.data && e.setData({
                        info: a.data.data.info,
                        publish: a.data.data.info.publish
                    });
                }
            }), wx.setStorageSync("uid", t.memberInfo.uid);
        }, t.detail);
    },
    hideDialog: function() {
        this.setData({
            isShow: !this.data.isShow
        });
    },
    phoneCall: function(a) {
        wx.makePhoneCall({
            phoneNumber: this.data.info.phone
        });
    },
    refund: function() {
        wx.navigateTo({
            url: "/pages/me/refund/index"
        });
    },
    showModal: function(a) {
        this.setData({
            modalName: a.currentTarget.dataset.target
        });
    },
    hideModal: function(a) {
        this.setData({
            modalName: null
        });
    },
    about: function() {
        wx.navigateTo({
            url: "/pages/me/about/index"
        });
    },
    favlink: function() {
        "" != wx.getStorageSync("uid") && "undefined" != wx.getStorageSync("uid") ? wx.switchTab({
            url: "../fav/index"
        }) : this.hideDialog();
    }
});