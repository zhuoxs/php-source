var common = require("../common/common.js"), app = getApp();

Page({
    data: {
        numbervalue: 1
    },
    menu_on: function() {
        this.setData({
            showbuy: !0
        });
    },
    tan_close: function() {
        this.setData({
            showbuy: !1
        });
    },
    numMinus: function() {
        var a = this.data.numbervalue;
        1 < parseInt(a) && this.setData({
            numbervalue: a - 1
        });
    },
    numPlus: function() {
        var a = this, t = a.data.numbervalue;
        parseInt(t) < parseInt(a.data.xc.member) - parseInt(a.data.xc.member_on) && a.setData({
            numbervalue: t + 1
        });
    },
    valChange: function(a) {
        var t = this, e = (t.data.xc, parseInt(a.detail.value));
        e <= 1 ? e = 1 : e > parseInt(t.data.xc.member) - parseInt(t.data.xc.member_on) && (e = parseInt(t.data.xc.member) - parseInt(t.data.xc.member_on)), 
        t.setData({
            numbervalue: e
        });
    },
    submit: function() {
        var a = this;
        wx.navigateTo({
            url: "../plant/porder?&land=" + a.data.xc.land + "&seed=" + a.data.xc.seed + "&member=" + a.data.numbervalue + "&group=" + a.data.id
        });
    },
    onLoad: function(a) {
        var e = this;
        common.config(e), e.setData({
            id: a.id
        }), app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "plant_group",
                id: e.data.id
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && e.setData({
                    xc: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "plant_group",
                id: e.data.id
            },
            success: function(a) {
                var t = a.data;
                wx.stopPullDownRefresh(), "" != t.data && e.setData({
                    xc: t.data
                });
            }
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var a = this, t = "/xc_farm/pages/plant_pin/index?&id=" + a.data.id, e = a.data.xc;
        return {
            title: app.config.webname + "-" + a.data.xc.seed_list.name,
            imageUrl: e.seed_list.simg,
            path: t,
            success: function(a) {
                console.log(a);
            },
            fail: function(a) {
                console.log(a);
            }
        };
    }
});