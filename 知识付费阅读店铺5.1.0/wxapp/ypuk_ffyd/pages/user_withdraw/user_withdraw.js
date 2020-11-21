var _global = require("../../resource/js/global.js"), _global2 = _interopRequireDefault(_global);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp();

Page({
    data: {
        userId: "",
        withdrawprice: ""
    },
    onLoad: function(t) {
        var e = this, a = wx.getStorageSync("userInfo");
        a && 0 != a.memberInfo.uid && "" != a.memberInfo ? (e.setData({
            userId: a.memberInfo.uid
        }), e.GetWithdraw()) : wx.getSetting({
            success: function(t) {
                0 == t.authSetting["scope.userInfo"] ? wx.showModal({
                    title: "提示",
                    content: "允许小程序获取您的用户信息后才可参与砍价哦",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.openSetting({
                            success: function(t) {
                                1 == t.authSetting["scope.userInfo"] && (e.setData({
                                    loginModelHidden: !1
                                }), wx.removeStorageSync("userInfo"));
                            }
                        });
                    }
                }) : (wx.removeStorageSync("userInfo"), e.setData({
                    loginModelHidden: !1
                }));
            }
        }), wx.hideShareMenu();
    },
    GetWithdraw: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/UserWithdrawLog",
            data: {
                uid: e.data.userId
            },
            cachetime: "0",
            success: function(t) {
                e.setData({
                    withdrawInfo: t.data.data,
                    withdrawprice: t.data.data.allow_price
                });
            }
        });
    },
    bindWithdrawPrice: function(t) {
        this.setData({
            withdrawprice: t.detail.value
        });
    },
    GoWithdraw: function() {
        var e = this;
        wx.showModal({
            title: "提示",
            content: "申请提现通过后，款项将直接转账到当前申请的微信号中，确定提交吗？",
            success: function(t) {
                t.confirm && e.postBtn();
            }
        });
    },
    postBtn: function() {
        var t = this, e = {
            uid: t.data.userId,
            withdrawprice: t.data.withdrawprice,
            allprice: t.data.withdrawInfo.all_price
        };
        return Number(e.withdrawprice) > Number(t.data.withdrawInfo.allow_price) ? (wx.showModal({
            title: "提示",
            content: "提取金额不能大于最多可提金额",
            showCancel: !1
        }), !1) : "" == e.withdrawprice ? (wx.showModal({
            title: "提示",
            content: "提取金额不能为空",
            showCancel: !1
        }), !1) : e.withdrawprice < 1 ? (wx.showModal({
            title: "提示",
            content: "提取金额不能小于1",
            showCancel: !1
        }), !1) : void app.util.request({
            url: "entry/wxapp/postuserwithdraw",
            cachetime: "0",
            method: "POST",
            data: e,
            success: function(t) {
                wx.hideToast(), 0 == t.data.errno && wx.showToast({
                    title: "提交成功"
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "提示",
                    content: t.data.message,
                    showCancel: !1
                });
            }
        });
    }
});