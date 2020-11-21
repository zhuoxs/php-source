var e = require("../../../../utils/base.js"), a = require("../../../../../api.js"), t = new e.Base();

Page({
    data: {
        phone: !1
    },
    onLoad: function(e) {
        this.getUserInfo();
    },
    getUserInfo: function() {
        var e = this, o = {
            url: a.default.user
        };
        t.getData(o, function(a) {
            console.log("用户信息=>", a), e.setData({
                userData: a
            });
        });
    },
    inputPhone: function(e) {
        var a = this, o = e.detail.value;
        t.checkPhone(o, function(e) {
            e && a.setData({
                phone: !0
            });
        });
    },
    shareSubmit: function(e) {
        if (console.log(e), 1 == e.detail.value.checkbox && this.data.phone) {
            var o = {
                url: a.default.share_submit,
                data: {
                    name: e.detail.value.name,
                    phone: e.detail.value.phone,
                    formId: e.detail.formId
                }
            };
            t.getData(o, function(e) {
                0 == e.errorCode ? wx.showToast({
                    title: e.msg,
                    icon: "none"
                }) : wx.showModal({
                    title: e.msg,
                    showCancel: !1,
                    success: function(e) {
                        wx.redirectTo({
                            url: "../../../Tab/user/user"
                        });
                    }
                });
            });
        } else {
            var n = this.data.phone ? "请勾选推广代理协议" : "请填写正确手机号码";
            wx.showModal({
                title: n,
                showCancel: !1
            });
        }
    }
});