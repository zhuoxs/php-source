var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var i = arguments[a];
        for (var e in i) Object.prototype.hasOwnProperty.call(i, e) && (t[e] = i[e]);
    }
    return t;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js");

function _defineProperty(t, a, i) {
    return a in t ? Object.defineProperty(t, a, {
        value: i,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = i, t;
}

var app = getApp(), WxParse = require("../common/wxParse/wxParse.js");

Page(_extends({}, _reload.reload, {
    data: _extends({}, _reload.data, {
        showRule: !1,
        showGift: !1,
        ajax: !1
    }),
    onLoad: function(t) {
        this.setData({
            cid: t.cid
        });
    },
    onloadData: function(t) {
        var e = this;
        t.detail.login && this.checkUrl().then(function(t) {
            var a = wx.getStorageSync("fcInfo"), i = {
                cid: e.data.cid,
                uid: a.wxInfo.id
            };
            return (0, _api.CardDetailsData)(i);
        }).then(function(t) {
            t.font.length < 1 ? wx.showModal({
                title: "提示",
                content: "该活动暂未设置集卡卡片，请联系商家进行设置！",
                showCancel: !1,
                success: function(t) {
                    wx.navigateBack({
                        delta: 1
                    });
                }
            }) : (WxParse.wxParse("content", "html", t.info.prize_details, e, 0), e.countDown(t.info.start_time, t.info.end_time), 
            e.setData({
                info: t,
                show: !0
            }));
        }).catch(function(t) {
            -1 === t.code ? e.tips(t.msg) : e.tips("false");
        });
    },
    onDrawATab: function(t) {
        var a = t.detail.formId;
        this.onDrawTab(!0, a);
    },
    onDrawBTab: function(t) {
        var a = t.detail.formId;
        this.onDrawTab(!1, a);
    },
    onDrawTab: function(o, t) {
        var r = this;
        if (!this.data.ajax) {
            this.setData({
                ajax: !0
            }), wx.showLoading({
                title: "抽奖中..."
            });
            var a = {
                cid: this.data.cid,
                uid: wx.getStorageSync("fcInfo").wxInfo.id,
                formId: t
            };
            (0, _api.CardDrawData)(a).then(function(t) {
                if (wx.hideLoading(), r.setData({
                    ajax: !1
                }), r.data.info.info.drawtimes - 0 + (r.data.info.sharenum - 0) - (r.data.info.drawnum - 0 + 1) < 0) wx.showToast({
                    title: "您的抽獎次數已全用完~",
                    icon: "none",
                    duration: 2e3
                }), r.onGiftTab(); else {
                    var a, i = null;
                    for (var e in r.data.info.font) r.data.info.font[e].id === t.id && (i = e);
                    for (var n in r.setData((_defineProperty(a = {
                        draw: t
                    }, "info.drawnum", r.data.info.drawnum - 0 + 1), _defineProperty(a, "info.font[" + i + "].num", r.data.info.font[i].num - 0 + 1), 
                    a)), o && r.onGiftTab(), r.data.info.font) {
                        if (r.data.info.font[n].num < 1) return void r.setData(_defineProperty({}, "info.isprize", 0));
                        r.setData(_defineProperty({}, "info.isprize", 1));
                    }
                }
            }).catch(function(t) {
                wx.hideLoading(), wx.showToast({
                    title: t.msg,
                    icon: "none",
                    duration: 2e3
                }), r.setData({
                    showGift: !1
                });
            });
        }
    },
    onGiftTab: function() {
        this.setData({
            showGift: !this.data.showGift
        });
    },
    onRuleTab: function() {
        this.setData({
            showRule: !this.data.showRule
        });
    },
    onGetPrizeTab: function() {
        var t = this.data.imgLink + this.data.info.info.img_cover, a = this.data.info.info.prizename, i = this.data.cid, e = this.data.info.info.prizetype;
        0 !== this.data.info.isgetprize ? this.navTo("../card/card?pid=" + this.data.info.isgetprize + "&title=" + a + "&img=" + t) : this.navTo("../getprize/getprize?cid=" + i + "&title=" + a + "&img=" + t + "&prizetype=" + e);
    },
    dealShareAction: function() {
        var a = this, t = {
            cid: this.data.cid,
            uid: wx.getStorageSync("fcInfo").wxInfo.id
        };
        (0, _api.CardShareData)(t).then(function(t) {
            a.setData(_defineProperty({}, "info.sharenum", a.data.info.sharenum - 0 + 1)), wx.showToast({
                title: "分享成功，恭喜获得一次抽奖机会",
                icon: "none",
                duration: 2e3
            });
        }).catch(function(t) {
            wx.showToast({
                title: "分享成功",
                icon: "none",
                duration: 2e3
            });
        });
    },
    countDown: function(t, a) {
        var i = this;
        clearInterval(c);
        var e = Math.floor(new Date().getTime() / 1e3 - 0);
        t -= 0, a -= 0;
        var n = Math.floor(t - e), o = 0, r = 0, s = 0, f = 0, d = 1, c = (new Date(), setInterval(function() {
            if (--n <= 0) {
                if (e = Math.floor(new Date().getTime() / 1e3 - 0), 0 <= t - e ? d = 1 : t - e < 0 && 0 <= a - e ? (n = Math.floor(a - e), 
                d = 2) : a - e < 0 && (d = 3), 3 == d) return his.setData({
                    countTime: {
                        D: 0,
                        H: 0,
                        M: 0,
                        S: 0,
                        status: d
                    }
                }), clearInterval(c), !1;
            } else o = Math.floor(n / 86400), r = Math.floor(n / 60 / 60 % 24), s = Math.floor(n / 60 % 60), 
            f = Math.floor(n % 60), r = 9 < r ? r : "0" + r, s = 9 < s ? s : "0" + s, f = 9 < f ? f : "0" + f, 
            i.setData({
                countTime: {
                    D: o,
                    H: r,
                    M: s,
                    S: f,
                    status: d
                }
            });
        }, 1e3));
    },
    onShareAppMessage: function(t) {
        var a = this;
        return {
            title: "集卡活动",
            path: "/yzpx_sun/pages/activity/activity?cid=" + a.data.cid,
            success: function() {
                a.dealShareAction();
            }
        };
    }
}));