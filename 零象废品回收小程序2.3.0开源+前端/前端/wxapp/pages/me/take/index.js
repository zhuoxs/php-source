var e = getApp();

Page({
    data: {
        paytype: 1,
        userinfo: []
    },
    onLoad: function(e) {
        this.getinfo();
    },
    onShow: function() {
        this.getinfo();
    },
    getinfo: function() {
        var t = this;
        e.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "me.collect",
                uid: wx.getStorageSync("uid")
            },
            success: function(e) {
                t.setData({
                    userinfo: e.data.data
                });
            }
        });
    },
    tixian: function(t) {
        var a = this;
        1 != a.data.paytype || "" != a.data.userinfo.ali_id && null != a.data.userinfo.ali_id && "undefined" != a.data.userinfo.ali_id ? 1 != a.data.paytype || "" != a.data.userinfo.ali_name && null != a.data.userinfo.ali_name && "undefined" != a.data.userinfo.ali_name ? "" != t.detail.value.takemoney && "undefined" != t.detail.value.takemoney ? a.data.userinfo.money - t.detail.value.takemoney < 0 ? e.util.message({
            title: "账户余额不足",
            type: "error"
        }) : t.detail.value.takemoney - 1 < 0 ? e.util.message({
            title: "最低提现额：1元",
            type: "error"
        }) : e.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "me.takeAdd",
                uid: wx.getStorageSync("uid"),
                formid: t.detail.formId,
                takemoney: t.detail.value.takemoney,
                paytype: a.data.paytype
            },
            success: function(t) {
                e.util.message({
                    title: "提交成功",
                    type: "success"
                }), setTimeout(function() {
                    wx.navigateTo({
                        url: "/pages/me/takelog/index"
                    });
                }, 2e3);
            }
        }) : e.util.message({
            title: "请填写提现金额",
            type: "error"
        }) : wx.showModal({
            title: "您还没输入支付宝账号姓名，前往绑定页面",
            content: "",
            success: function(e) {
                e.confirm && wx.navigateTo({
                    url: "/pages/me/collectDetails/index?type=1&tixian=1"
                });
            }
        }) : wx.showModal({
            title: "您还没绑定账号，前往绑定页面",
            content: "",
            success: function(e) {
                e.confirm && wx.navigateTo({
                    url: "/pages/me/collectDetails/index?type=1&tixian=1"
                });
            }
        });
    },
    collect: function(e) {
        this.setData({
            paytype: e.currentTarget.dataset.type
        });
    },
    quanti: function() {
        this.setData({
            timoney: this.data.userinfo.money
        });
    }
});