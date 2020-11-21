var _extends = Object.assign || function(t) {
    for (var e = 1; e < arguments.length; e++) {
        var a = arguments[e];
        for (var n in a) Object.prototype.hasOwnProperty.call(a, n) && (t[n] = a[n]);
    }
    return t;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: {
        remove: !1
    },
    onLoad: function(t) {
        this.setData({
            pid: t.pid,
            title: t.title,
            img: t.img,
            manage: t.manage
        }), this.onloadData();
    },
    onloadData: function() {
        var e = this, a = {
            pid: this.data.pid,
            uid: wx.getStorageSync("fcInfo").wxInfo.id
        };
        this.checkUrl().then(function(t) {
            return (0, _api.PrizeInfoData)(a);
        }).then(function(t) {
            e.setData({
                info: t
            });
        }).catch(function(t) {
            -1 === t.code ? ("订单已删除" === t.msg && e.setData({
                remove: !0
            }), e.tips(t.msg)) : e.tips("false");
        });
    },
    onDelTab: function() {
        var e = this;
        wx.showModal({
            title: "提示",
            content: "确定删除本订单吗！？",
            success: function(t) {
                t.confirm && e.delOrder();
            }
        });
    },
    delOrder: function() {
        var e = this, t = {
            pid: this.data.pid
        };
        (0, _api.DelPrizeData)(t).then(function(t) {
            wx.showToast({
                title: "订单已删除！",
                icon: "none",
                duration: 2e3
            }), setTimeout(function() {
                e.reTo("../mycard/mycard");
            }, 1e3);
        }).catch(function(t) {
            wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 2e3
            });
        });
    }
}));