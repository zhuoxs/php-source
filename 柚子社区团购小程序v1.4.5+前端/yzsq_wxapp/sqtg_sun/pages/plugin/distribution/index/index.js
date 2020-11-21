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
    onLoad: function(a) {},
    onHide: function() {},
    onUnload: function() {},
    formSubmit: function(a) {
        var e = this;
        wx.getStorageSync("user_info");
        if (e.data.form = a.detail.value, null != e.data.form.name && "" != e.data.form.name) if (null != e.data.form.mobile && "" != e.data.form.mobile) {
            var i = wx.getStorageSync("users"), t = a.detail.value;
            if (t.uid = i.id, t.form_id = a.detail.formId, 0 != e.data.agree) {
                console.log(e.data.agree), wx.showLoading({
                    title: "正在提交",
                    mask: !0
                });
                var n = wx.getStorageSync("openid");
                t.openid = n, t.m = app.globalData.Plugin_distribution, app.util.request({
                    url: "entry/wxapp/SavePromoter",
                    data: t,
                    success: function(a) {
                        1 == a.data.code ? wx.redirectTo({
                            url: "/mzhk_sun/plugin/distribution/fxAddShare/fxAddShare"
                        }) : (wx.showToast({
                            title: a.data.msg,
                            image: "/style/images/icon-warning.png"
                        }), 0 == a.data.code && app.func.islogin(app, e));
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
        var a = this, e = a.data.agree;
        0 == e ? (e = 1, a.setData({
            img: "/style/images/img-share-agree.png",
            agree: e
        })) : 1 == e && (e = 0, a.setData({
            img: "/style/images/img-share-un.png",
            agree: e
        }));
    }
});