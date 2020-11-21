var _extends = Object.assign || function(a) {
    for (var n = 1; n < arguments.length; n++) {
        var t = arguments[n];
        for (var e in t) Object.prototype.hasOwnProperty.call(t, e) && (a[e] = t[e]);
    }
    return a;
}, _reload = require("../../common/js/reload.js"), _api = require("../../common/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: {
        show: !0,
        auth: 1
    },
    onLoad: function(a) {},
    onloadData: function(a) {
        var n = this;
        a.detail.login && this.checkUrl().then(function(a) {
            var n = {
                uid: wx.getStorageSync("userInfo").wxInfo.id
            };
            return Promise.all([ (0, _api.WeData)(), (0, _api.AdminInfoData)(n) ]);
        }).then(function(a) {
            n.setData({
                shop: a[0],
                show: !0,
                info: a[1]
            }), console.log(a[1].admininfo), 0 == a[1].admininfo ? n.setData({
                auth: 1,
                shopname: a[0].name + "（总管理员）"
            }) : n.setData({
                auth: 0,
                shopname: a[1].branchinfo.name + "（门店管理员）"
            });
        }).catch(function(a) {
            -1 === a.code ? "您还不是管理员哦" == a.msg ? wx.showModal({
                title: "提示",
                content: "您不是管理员哦！",
                showCancel: !1,
                success: function(a) {
                    wx.reLaunch({
                        url: "../mine/mine"
                    });
                }
            }) : n.tips(a.msg) : n.tips("false");
        });
    },
    onManageOrderTab: function() {
        var a = -1;
        a = 1 == this.data.auth ? 0 : this.data.info.branchinfo.id, this.navTo("/yzzc_sun/pages/manageorder/manageorder?sid=" + a);
    },
    onManageCarTab: function() {
        var a = -1;
        a = 1 == this.data.auth ? 0 : this.data.info.branchinfo.id, this.navTo("/yzzc_sun/pages/managecar/managecar?sid=" + a);
    }
}));