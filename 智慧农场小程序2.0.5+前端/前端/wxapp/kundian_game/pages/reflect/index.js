var a = new getApp(), t = a.siteInfo.uniacid;

Page({
    data: {
        money: 0,
        withdrawSet: [],
        user: [],
        kundianFarmSet: wx.getStorageSync("kundian_farm_setData")
    },
    onLoad: function(e) {
        var n = this;
        a.util.setNavColor(t);
        var o = wx.getStorageSync("kundian_farm_uid"), r = a.util.getNewUrl("entry/wxapp/withdraw", "kundian_farm_plugin_play");
        wx.request({
            url: r,
            data: {
                op: "calculateMoney",
                uniacid: t,
                uid: o
            },
            success: function(a) {
                0 == a.data.code ? n.setData({
                    money: a.data.money,
                    withdrawSet: a.data.withdrawSet,
                    user: a.data.user
                }) : (wx.showModal({
                    title: "提示",
                    content: a.data.msg,
                    showCancel: !1
                }), n.setData({
                    user: a.data.user
                }));
            }
        });
    },
    withdrawNow: function(e) {
        var n = this, o = wx.getStorageSync("kundian_farm_uid"), r = n.data.money;
        if (parseFloat(r) < 1 && parseFloat(r) > 2e6) return wx.showModal({
            title: "提示",
            content: "目前最低付款金额为1元，最高200w，请确认是否付款金额超限",
            showCancel: !1
        }), !1;
        var i = n.data.user, d = n.data.withdrawSet;
        if (i.gold < d.withdraw_low_gold || i.gold <= 0) return wx.showModal({
            title: "提示",
            content: "提现金币不足！最少提现金币为" + d.withdraw_low_gold,
            showCancel: !1
        }), !1;
        var w = a.util.getNewUrl("entry/wxapp/withdraw", "kundian_farm_plugin_play");
        wx.request({
            url: w,
            data: {
                op: "withdrawNow",
                uid: o,
                uniacid: t,
                money: r
            },
            success: function(a) {
                wx.showModal({
                    title: "提示",
                    content: a.data.msg,
                    showCancel: !1,
                    success: function() {
                        wx.redirectTo({
                            url: "../recode/index"
                        });
                    }
                });
            }
        });
    },
    history: function() {
        wx.navigateTo({
            url: "../recode/index"
        });
    }
});