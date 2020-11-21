var _extends = Object.assign || function(n) {
    for (var a = 1; a < arguments.length; a++) {
        var t = arguments[a];
        for (var o in t) Object.prototype.hasOwnProperty.call(t, o) && (n[o] = t[o]);
    }
    return n;
}, _reload = require("../../resource/js/reload.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: _extends({}, _reload.data, {
        manage: !1
    }),
    onLoad: function() {},
    onShow: function() {
        "" != wx.getStorageSync("manage") && this.setData({
            manage: !0
        });
    },
    onloadData: function(n) {
        var a = this;
        n.detail.login && this.checkUrl().then(function(n) {
            a.setData({
                show: !0,
                avatar: wx.getStorageSync("fcInfo").wxInfo.headurl,
                nick: wx.getStorageSync("fcInfo").wxInfo.username
            });
        }).catch(function(n) {
            -1 === n.code ? a.tips(n.msg) : a.tips("false");
        });
    },
    onMyCardTab: function() {
        this.navTo("../mycard/mycard");
    },
    onMyBookingTab: function() {
        this.navTo("../appointment/appointment");
    },
    onMyAskTab: function() {
        this.navTo("../myask/myask");
    },
    onMyFindTab: function() {
        this.navTo("../myfind/myfind");
    },
    onMyCollectTab: function() {
        this.navTo("../mycollect/mycollect");
    },
    onLoginTab: function() {
        this.data.manage ? this.navTo("../manage/manage") : this.navTo("../login/login");
    }
}));