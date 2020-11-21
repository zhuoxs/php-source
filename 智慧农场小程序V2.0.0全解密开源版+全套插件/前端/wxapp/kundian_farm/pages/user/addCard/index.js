var a = new getApp(), t = a.siteInfo.uniacid;

Page({
    data: {
        records: [],
        card_num: "",
        card_pwd: "",
        farmSetData: [],
        icon: []
    },
    onLoad: function(e) {
        var d = this, n = wx.getStorageSync("kundian_farm_uid");
        0 != n ? (a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "sign",
                op: "getCardRecord",
                uid: n,
                uniacid: t
            },
            success: function(a) {
                d.setData({
                    records: a.data.cardData,
                    icon: a.data.icon
                });
            }
        }), a.util.setNavColor(t)) : wx.redirectTo({
            url: "../../login/index"
        }), d.setData({
            farmSetData: wx.getStorageSync("kundian_farm_setData")
        });
    },
    submitInfo: function(e) {
        var d = wx.getStorageSync("kundian_farm_uid"), n = e.detail.value, o = n.card_num, r = n.card_pwd;
        if ("" == o) return wx.showToast({
            title: "请填写卡号"
        }), !1;
        if ("" == r) return wx.showToast({
            title: "请填写密码"
        }), !1;
        var i = this;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "sign",
                op: "addCard",
                uniacid: t,
                uid: d,
                card_num: o,
                card_pwd: r
            },
            success: function(a) {
                0 == a.data.code ? (wx.showToast({
                    title: "绑定成功"
                }), i.setData({
                    card_num: "",
                    card_pwd: ""
                })) : 1 == a.data.code ? wx.showToast({
                    title: "绑定失败"
                }) : 2 == a.data.code ? wx.showModal({
                    title: "提示",
                    content: "卡号或密码输入错误"
                }) : 3 == a.data.code && wx.showModal({
                    title: "提示",
                    content: "卡号已被绑定"
                });
            }
        });
    },
    onShareAppMessage: function(a) {}
});