var _extends = Object.assign || function(t) {
    for (var e = 1; e < arguments.length; e++) {
        var a = arguments[e];
        for (var n in a) Object.prototype.hasOwnProperty.call(a, n) && (t[n] = a[n]);
    }
    return t;
}, _reload = require("../../common/js/reload.js"), _api = require("../../common/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: {
        show: !1,
        name: "",
        tel: ""
    },
    onLoad: function(t) {
        this.setData({
            options: t,
            oid: t.oid
        });
        var e = wx.getStorageSync("concatInfo");
        e ? this.setData({
            name: e.username,
            tel: e.tel
        }) : this.setData({
            name: "",
            tel: ""
        });
    },
    onloadData: function(t) {
        var a = this;
        t.detail.login && (this.setData({
            show: !0
        }), this.getUrl().then(function(t) {
            var e = {
                id: a.data.options.sid
            };
            return (0, _api.BranchData)(e);
        }).then(function(t) {
            a.setData({
                msg: t
            });
        }).catch(function(t) {
            -1 === t.code ? "门店id不存在" == t.msg ? wx.showModal({
                title: "提示",
                content: "门店不存在",
                showCancel: !1,
                success: function(t) {
                    wx.navigateBack({
                        delta: 1
                    });
                }
            }) : a.tips(t.msg) : a.tips("false");
        }));
    },
    onSendTab: function() {
        var t = {
            oid: this.data.oid,
            username: this.data.name,
            tel: this.data.tel
        };
        console.log(t), t.username.length < 2 ? wx.showToast({
            title: "请输入正确的姓名",
            icon: "none",
            duration: 1e3
        }) : t.tel.length < 7 ? wx.showToast({
            title: "请输入正确的电话号码",
            icon: "none",
            duration: 1e3
        }) : (0, _api.GetcarData)(t).then(function(t) {
            wx.showToast({
                title: "提车成功",
                icon: "none",
                duration: 1e3
            }), setTimeout(function() {
                wx.reLaunch({
                    url: "../order/order"
                });
            }, 1e3);
        }, function(t) {
            wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 1e3
            });
        });
    },
    getName: function(t) {
        var e = t.detail.value.trim();
        this.setData({
            name: e
        });
    },
    getTel: function(t) {
        var e = t.detail.value.trim();
        this.setData({
            tel: e
        });
    }
}));