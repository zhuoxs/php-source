var _extends = Object.assign || function(e) {
    for (var a = 1; a < arguments.length; a++) {
        var t = arguments[a];
        for (var r in t) Object.prototype.hasOwnProperty.call(t, r) && (e[r] = t[r]);
    }
    return e;
}, _reload = require("../../common/js/reload.js"), _api = require("../../common/js/api.js"), app = getApp(), wxParse = require("../wxParse/wxParse.js");

Page(_extends({}, _reload.reload, {
    data: {},
    onLoad: function(e) {
        this.getAvatar();
    },
    onloadData: function(e) {
        var n = this;
        e.detail.login && (this.setData({
            show: !0
        }), this.checkUrl().then(function(e) {
            var a = {
                uid: wx.getStorageSync("userInfo").wxInfo.id
            };
            return (0, _api.MemberData)(a);
        }).then(function(e) {
            var a = e.list[e.list.length - 1].level_score - 0, t = e.userinfo.all_integral - 0, r = parseInt(t / a * 100);
            wxParse.wxParse("rule", "html", e.rule, n, 15), n.setData({
                msg: e,
                per: r
            });
        }).catch(function(e) {
            -1 === e.code ? n.tips(e.msg) : n.tips("false");
        }));
    },
    getAvatar: function() {
        var e = wx.getStorageSync("userInfo").wxInfo;
        this.setData({
            nickName: e.user_name,
            avatar: e.headimg
        });
    }
}));