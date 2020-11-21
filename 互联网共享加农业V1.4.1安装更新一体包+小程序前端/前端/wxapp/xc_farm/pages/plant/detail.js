var dd, common = require("../common/common.js"), app = getApp(), WxParse = require("../../../wxParse/wxParse.js");

function time_up(n) {
    dd = setInterval(function() {
        var a = n.data.xc;
        if (0 < a.group.length) for (var t = 0; t < a.group.length; t++) {
            var e = a.group[t].fail;
            0 == (e -= 1) ? a.group.splice(t, 1) : (a.group[t].fail = e, a.group[t].hour = parseInt(e / 3600), 
            a.group[t].min = parseInt(e % 3600 / 60), a.group[t].second = parseInt(e % 60)), 
            n.setData({
                xc: a
            });
        } else clearInterval(dd);
    }, 1e3);
}

Page({
    data: {
        choose: -1,
        numbervalue: 1
    },
    tan: function(a) {
        var t = this.data.xc, e = a.currentTarget.dataset.index;
        this.setData({
            yin: !0,
            list: t.seed[e]
        });
    },
    tan_close: function(a) {
        this.setData({
            yin: !1,
            showbuy: !1,
            numbervalue: 1
        });
    },
    choose: function(a) {
        for (var t = a.currentTarget.dataset.index, e = this.data.xc, n = 0; n < e.seed.length; n++) e.seed[n].choose = -1;
        e.seed[t].choose = 1, this.setData({
            xc: e,
            choose: t
        });
    },
    menu_on: function() {
        -1 != this.data.choose ? this.setData({
            showbuy: !0
        }) : wx.showModal({
            title: "错误",
            content: "请先选择种子",
            showCancel: !1
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
        parseInt(t) < parseInt(a.data.xc.seed_member) && a.setData({
            numbervalue: t + 1
        });
    },
    valChange: function(a) {
        var t = this, e = (t.data.xc, parseInt(a.detail.value));
        e <= 1 ? e = 1 : e > parseInt(t.data.xc.seed_member) && (e = parseInt(t.data.xc.seed_member)), 
        t.setData({
            numbervalue: e
        });
    },
    closect: function() {
        this.setData({
            showct: !1
        });
    },
    showct: function() {
        this.setData({
            showct: !0
        });
    },
    submit: function() {
        var a = this;
        wx.navigateTo({
            url: "porder?&land=" + a.data.id + "&seed=" + a.data.xc.seed[a.data.choose].id + "&member=" + a.data.numbervalue
        });
    },
    onLoad: function(a) {
        var e = this;
        common.config(e), e.setData({
            id: a.id
        }), app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "plant_detail",
                id: e.data.id
            },
            success: function(a) {
                var t = a.data;
                if ("" != t.data && (e.setData({
                    xc: t.data
                }), "" != t.data.group && null != t.data.group && (clearInterval(dd), time_up(e)), 
                "" != t.data.content && null != t.data.content)) WxParse.wxParse("article", "html", t.data.content, e, 0);
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
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "plant_detail",
                id: e.data.id
            },
            success: function(a) {
                var t = a.data;
                wx.stopPullDownRefresh(), "" != t.data && (e.setData({
                    xc: t.data
                }), "" != t.data.group && null != t.data.group && (clearInterval(dd), time_up(e)));
            }
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var a = this, t = "/xc_farm/pages/plant/detail?&id=" + a.data.id, e = a.data.xc;
        return {
            title: app.config.webname + "-" + a.data.xc.name,
            imageUrl: e.simg,
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