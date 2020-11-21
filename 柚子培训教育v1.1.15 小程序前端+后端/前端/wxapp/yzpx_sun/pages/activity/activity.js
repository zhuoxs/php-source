var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var i = arguments[a];
        for (var n in i) Object.prototype.hasOwnProperty.call(i, n) && (t[n] = i[n]);
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

var app = getApp(), WxParse = require("../components/wxParse/wxParse.js");

Page(_extends({}, _reload.reload, {
    data: {
        showRule: !1,
        showGift: !1
    },
    onLoad: function(t) {
        this.setData({
            cid: t.cid
        });
    },
    onloadData: function(n) {
        var e = this;
        this.getSchoolList(), this.setData({
            shopname: wx.getStorageSync("shopinfo").name
        }), this.checkUrl().then(function(t) {
            if (n.detail.login) {
                e.setData({
                    login: n.detail.login
                });
                var a = wx.getStorageSync("userInfo"), i = {
                    cid: e.data.cid,
                    uid: a.wxInfo.id
                };
                return (0, _api.CardDetailsData)(i);
            }
        }).then(function(t) {
            WxParse.wxParse("content", "html", t.info.prize_details, e, 0), e.setData({
                info: t
            });
        }).catch(function(t) {
            -1 === t.code ? e.tips(t.msg) : e.tips("false");
        });
    },
    getSchoolList: function() {
        var a = this;
        (0, _api.GetPrizeSchoolData)().then(function(t) {
            a.setData({
                school: t
            });
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
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
        var r = this, a = wx.getStorageSync("userInfo"), i = {
            cid: this.data.cid,
            uid: a.wxInfo.id,
            formId: t
        };
        (0, _api.CardDrawData)(i).then(function(t) {
            if (r.data.info.info.drawtimes - 0 + (r.data.info.sharenum - 0) - (r.data.info.drawnum - 0 + 1) < 0) wx.showToast({
                title: "您的抽獎次數已全用完~",
                icon: "none",
                duration: 2e3
            }), r.onGiftTab(); else {
                var a, i = null;
                for (var n in r.data.info.font) r.data.info.font[n].id === t.id && (i = n);
                for (var e in r.setData((_defineProperty(a = {
                    draw: t
                }, "info.drawnum", r.data.info.drawnum - 0 + 1), _defineProperty(a, "info.font[" + i + "].num", r.data.info.font[i].num - 0 + 1), 
                a)), o && r.onGiftTab(), r.data.info.font) {
                    if (r.data.info.font[e].num < 1) return void r.setData(_defineProperty({}, "info.isprize", 0));
                    r.setData(_defineProperty({}, "info.isprize", 1));
                }
            }
        }).catch(function(t) {
            wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 2e3
            }), r.setData({
                showGift: !1
            });
        });
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
        var t = this.data.imgLink + this.data.info.info.img_cover, a = this.data.info.info.prizename, i = this.data.cid, n = this.data.info.info.prizetype;
        0 !== this.data.info.isgetprize ? this.navTo("../card/card?pid=" + this.data.info.isgetprize + "&title=" + a + "&img=" + t) : this.navTo("../getprize/getprize?cid=" + i + "&title=" + a + "&img=" + t + "&prizetype=" + n);
    },
    dealShareAction: function() {
        var a = this, t = {
            cid: this.data.cid,
            uid: wx.getStorageSync("userInfo").wxInfo.id
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
    onShareAppMessage: function(t) {
        return this.dealShareAction(), {
            title: "集卡活动",
            path: "/yzpx_sun/pages/activity/activity?cid=" + this.data.cid,
            success: function() {}
        };
    }
}));