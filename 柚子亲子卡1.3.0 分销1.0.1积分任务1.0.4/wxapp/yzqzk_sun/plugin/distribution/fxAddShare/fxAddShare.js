var app = getApp();

Page({
    data: {
        is_modal_Hidden: !0,
        user_info: !1,
        distribution_set: [],
        form: {
            name: "",
            mobile: ""
        },
        img: "/style/images/img-share-un.png",
        agree: 0
    },
    onLoad: function(a) {
        var e = this;
        wx.setNavigationBarTitle({
            title: e.data.navTile
        }), e.setData({
            url: wx.getStorageSync("imgroot")
        }), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "0",
            showLoading: !1,
            success: function(a) {
                e.setData({
                    pt_name: a.data.pt_name ? a.data.pt_name : ""
                }), wx.setNavigationBarColor({
                    frontColor: a.data.fontcolor ? a.data.fontcolor : "#000000",
                    backgroundColor: a.data.color ? a.data.color : "#ffffff",
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                });
            }
        });
        var t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/IsPromoter",
            data: {
                openid: t,
                m: app.globalData.Plugin_distribution
            },
            showLoading: !1,
            success: function(a) {
                if (a && 9 != a.data) {
                    var t = a.data;
                    e.setData({
                        user_info: t
                    });
                }
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 1
            },
            showLoading: !1,
            success: function(a) {
                var t = a.data;
                2 != t && e.setData({
                    distribution_set: t
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetUser",
            data: {
                openid: t,
                m: app.globalData.Plugin_distribution
            },
            showLoading: !1,
            success: function(a) {
                var t = a.data;
                2 != t && e.setData({
                    form: t
                });
            }
        });
    },
    updateUserInfo: function(a) {
        console.log("授权操作更新");
        app.wxauthSetting();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    formSubmit: function(a) {
        var t = this;
        wx.getStorageSync("user_info");
        if (t.data.form = a.detail.value, null != t.data.form.name && "" != t.data.form.name) if (null != t.data.form.mobile && "" != t.data.form.mobile) {
            var e = wx.getStorageSync("users"), i = a.detail.value;
            if (i.uid = e.id, i.form_id = a.detail.formId, 0 != t.data.agree) {
                console.log(t.data.agree), wx.showLoading({
                    title: "正在提交",
                    mask: !0
                });
                var o = wx.getStorageSync("openid");
                i.openid = o, i.m = app.globalData.Plugin_distribution, app.util.request({
                    url: "entry/wxapp/SavePromoter",
                    data: i,
                    success: function(a) {
                        1 == a.data.code ? wx.redirectTo({
                            url: "/yzqzk_sun/plugin/distribution/fxAddShare/fxAddShare"
                        }) : (wx.showToast({
                            title: a.data.msg,
                            image: "/style/images/icon-warning.png"
                        }), 0 == a.data.code && app.func.islogin(app, t));
                    }
                });
            } else wx.showToast({
                title: "请先阅读并确认分销申请协议！！",
                image: "/style/images/icon-warning.png"
            });
        } else wx.showToast({
            title: "请填写联系方式！",
            image: "/style/images/icon-warning.png"
        }); else wx.showToast({
            title: "请填写姓名！",
            image: "/style/images/icon-warning.png"
        });
    },
    agreement: function() {
        var a = this.data.distribution_set.application;
        wx.showModal({
            title: "分销协议",
            content: a,
            showCancel: !1,
            confirmText: "我已阅读",
            confirmColor: "#ff4544",
            success: function(a) {
                a.confirm && console.log("用户点击确定");
            }
        });
    },
    agree: function() {
        var a = this, t = a.data.agree;
        0 == t ? (t = 1, a.setData({
            img: "/style/images/img-share-agree.png",
            agree: t
        })) : 1 == t && (t = 0, a.setData({
            img: "/style/images/img-share-un.png",
            agree: t
        }));
    }
});