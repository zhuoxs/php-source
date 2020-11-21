var t = getApp(), e = t.siteInfo.uniacid;

Page({
    data: {
        price: 0,
        selected: 0,
        user: [],
        farmSetData: []
    },
    onLoad: function(a) {
        var i = this, o = wx.getStorageSync("kundian_farm_uid");
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "user",
                op: "getWallet",
                uniacid: e,
                uid: o
            },
            success: function(t) {
                i.setData({
                    user: t.data.userInfo
                });
            }
        }), i.setData({
            farmSetData: wx.getStorageSync("kundian_farm_setData")
        });
    },
    formSubmit: function(a) {
        var i = this, o = wx.getStorageSync("kundian_farm_uid"), r = parseFloat(parseFloat(a.detail.value.price).toFixed(2)), s = i.data, n = s.user, d = s.selected;
        if (r <= 0) return wx.showModal({
            title: "提示",
            content: "提现金额不能小于0",
            showCancel: !1
        }), !1;
        if (!r) return wx.showModal({
            title: "提示",
            content: "请输入提现金额",
            showCancel: !1
        }), !1;
        if (n.money < r) return wx.showModal({
            title: "提示",
            content: "提现金额不足",
            showCancel: !1
        }), !1;
        if (r < parseFloat(this.data.farmSetData.user_withdraw_low_price)) wx.showModal({
            title: "提示",
            content: "提现金额不能低于" + this.data.farmSetData.user_withdraw_low_price + "元",
            showCancel: !1
        }); else {
            var l = a.detail.value, c = l.name, u = l.mobile;
            if (0 == d) {
                if (!c || void 0 == c) return void wx.showToast({
                    title: "姓名不能为空"
                });
                if (!u || void 0 == u) return void wx.showToast({
                    title: "账号不能为空"
                });
            }
            0 == d || 1 == d ? (wx.showLoading({
                title: "正在提交",
                mask: !0
            }), t.util.request({
                url: "entry/wxapp/class",
                data: {
                    control: "user",
                    op: "user_withdraw",
                    uid: o,
                    name: c,
                    phone: u,
                    price: r,
                    uniacid: e,
                    method: d,
                    form_id: a.detail.formId
                },
                success: function(t) {
                    wx.showModal({
                        title: "提示",
                        content: t.data.msg,
                        showCancel: !1,
                        success: function() {
                            wx.redirectTo({
                                url: "../recode/index"
                            });
                        }
                    });
                }
            })) : wx.showToast({
                title: "请选择提现方式"
            });
        }
    },
    select: function(t) {
        var e = t.currentTarget.dataset.index;
        this.setData({
            selected: e
        });
    }
});