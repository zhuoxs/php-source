var _extends = Object.assign || function(e) {
    for (var n = 1; n < arguments.length; n++) {
        var a = arguments[n];
        for (var t in a) Object.prototype.hasOwnProperty.call(a, t) && (e[t] = a[t]);
    }
    return e;
}, _reload = require("../../common/js/reload.js"), _api = require("../../common/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: {
        login: !1,
        imgLink: wx.getStorageSync("url")
    },
    onLoad: function(e) {
        this.getAvatar();
    },
    onloadData: function(e) {
        var n = this;
        e.detail.login && (this.setData({
            login: !0
        }), this.getUrl().then(function(e) {
            var n = {
                uid: wx.getStorageSync("userInfo").wxInfo.id
            };
            return (0, _api.UsersData)(n);
        }).then(function(e) {
            n.setData({
                msg: e
            });
        }).catch(function(e) {
            -1 === e.code ? n.tips(e.msg) : n.tips("false");
        }));
    },
    getAvatar: function() {
        wx.getStorageSync("userInfo").wxInfo;
        this.setData({
            nickName: wx.getStorageSync("userInfo").wxInfo.user_name,
            avatar: wx.getStorageSync("userInfo").wxInfo.headimg
        });
    },
    goYouhuiquan: function(e) {
        var n = e.currentTarget.dataset.key;
        this.navTo("../couponmy/couponmy?ctype=" + n);
    },
    goMinejifen: function() {
        this.navTo("../jifen/jifen");
    },
    goNewerguide: function(e) {
        this.navTo("../help/newerGuide/newerGuide");
    },
    goServerRules: function(e) {
        this.navTo("../help/serverRule/serverRule");
    },
    goAboutUs: function(e) {
        this.navTo("../help/company-show/company-show");
    },
    goWeizhang: function(e) {
        this.navTo("../help/weizhangDeal/weizhangDeal");
    },
    goMemberLevel: function(e) {
        this.navTo("../member-Level/member-Level");
    },
    goManage: function() {
        this.navTo("../manage/manage");
    },
    goManager: function(e) {
        this.navTo("../manager-entr/index");
    }
}));