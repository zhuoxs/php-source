var _extends = Object.assign || function(e) {
    for (var t = 1; t < arguments.length; t++) {
        var a = arguments[t];
        for (var n in a) Object.prototype.hasOwnProperty.call(a, n) && (e[n] = a[n]);
    }
    return e;
}, _reload = require("../../common/js/reload.js"), _api = require("../../common/js/api.js"), app = getApp(), wxParse = require("../wxParse/wxParse.js");

Page(_extends({}, _reload.reload, {
    data: {
        statusType: [ "积分明细", "兑换记录" ],
        quanData: [],
        now: 0,
        all: 0,
        rule: "",
        preventJifen: 0
    },
    onLoad: function(e) {},
    onloadData: function(e) {
        var t = this;
        e.detail.login && (this.setData({
            show: !0
        }), this.checkUrl().then(function(e) {
            var t = {
                uid: wx.getStorageSync("userInfo").wxInfo.id
            };
            return (0, _api.IntegralData)(t);
        }).then(function(e) {
            wxParse.wxParse("rule", "html", e.rentrule.content, t, 15), wxParse.wxParse("jifenrule", "html", e.jfrule.rule, t, 15), 
            t.setData({
                quanData: e.rent,
                all: e.user.all_integral,
                now: e.user.now_integral
            });
        }).catch(function(e) {
            -1 === e.code ? t.tips(e.msg) : t.tips("false");
        }));
    },
    statusTap: function(e) {
        wx.navigateTo({
            url: "../jifendetails/jifendetails?title=" + e.currentTarget.dataset.title + "&&curIndex=" + e.currentTarget.dataset.index
        });
    },
    onExchangeTab: function(e) {
        var t = this;
        if (1 !== this.data.preventJifen) {
            var a = {
                uid: wx.getStorageSync("userInfo").wxInfo.id,
                cid: e.currentTarget.dataset.cid
            };
            (0, _api.ExchangeData)(a).then(function(e) {
                t.setData({
                    preventJifen: 1
                }), wx.showToast({
                    title: "领取成功！",
                    icon: "none",
                    duration: 1e3
                });
            }, function(e) {
                wx.showToast({
                    title: e.msg,
                    icon: "none",
                    duration: 1e3
                });
            });
        } else wx.showToast({
            title: "您已领过！",
            icon: "none",
            duration: 1e3
        });
    }
}));