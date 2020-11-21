var _Page;

function _defineProperty(n, e, o) {
    return e in n ? Object.defineProperty(n, e, {
        value: o,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : n[e] = o, n;
}

var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page((_defineProperty(_Page = {
    data: {
        allnum: 0,
        launchnum: 0,
        luckynum: 0,
        money: 0
    },
    onLoad: function(n) {
        var e = wx.getStorageSync("user_info"), o = wx.getStorageSync("is_tel"), t = wx.getStorageSync("is_openzx");
        this.setData({
            userInfo: e,
            is_openzx: t,
            is_tel: o
        });
    },
    onReady: function() {},
    goMydance: function(n) {
        wx.navigateTo({
            url: "../../circle/mydance/mydance"
        });
    },
    onShow: function() {
        var e = this, n = wx.getStorageSync("users").openid;
        app.util.request({
            url: "entry/wxapp/My",
            data: {
                openid: n
            },
            success: function(n) {
                console.log(n), e.setData({
                    allnum: n.data.allnum,
                    launchnum: n.data.launchnum,
                    luckynum: n.data.luckynum,
                    money: n.data.money,
                    res: n.data.res
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    goAddress: function(n) {
        wx.chooseAddress({
            success: function(n) {
                console.log(n);
            }
        });
    },
    goTicketadd: function(n) {
        wx.navigateTo({
            url: "../ticketadd/ticketadd"
        });
    },
    goSponsor: function(n) {
        wx.navigateTo({
            url: "../sponsortwo/sponsortwo"
        });
    },
    goTicketmain: function(n) {
        wx.reLaunch({
            url: "../ticketmiannew/ticketmiannew"
        });
    },
    goRecordall: function(n) {
        wx.navigateTo({
            url: "../recordall/recordall"
        });
    },
    goRecordlaunch: function(n) {
        wx.navigateTo({
            url: "../recordlaunch/recordlaunch"
        });
    },
    goRecordlucky: function(n) {
        wx.navigateTo({
            url: "../recordlucky/recordlucky"
        });
    },
    goBalance: function(n) {
        wx.navigateTo({
            url: "../balance/balance"
        });
    },
    goHelpcenter: function(n) {
        wx.navigateTo({
            url: "../helpcenter/helpcenter"
        });
    },
    goGiftorder: function(n) {
        wx.navigateTo({
            url: "../../gift/giftorder/giftorder"
        });
    },
    goAdmin: function() {
        var n = wx.getStorageSync("users").openid;
        app.util.request({
            url: "entry/wxapp/adminLogin",
            data: {
                openid: n
            },
            success: function(n) {
                0 == n.data ? wx.showToast({
                    title: "当前用户不是赞助商！",
                    icon: "none",
                    duration: 1e3
                }) : wx.reLaunch({
                    url: "../../my/admin/work/work?sid=" + n.data
                });
            }
        });
    }
}, "goTicketadd", function(n) {
    wx.navigateTo({
        url: "../ticketadd/ticketadd"
    });
}), _defineProperty(_Page, "goNewawardindex", function(n) {
    wx.reLaunch({
        url: "../newawardindex/newawardindex"
    });
}), _defineProperty(_Page, "goGiftindex", function(n) {
    console.log(this.data.is_tel), 1 == this.data.is_tel || 0 == this.data.is_tel ? wx.navigateTo({
        url: "../../gift/giftindex/giftindex"
    }) : wx.showToast({
        title: "送礼未开启！！！",
        icon: "none",
        duration: 1e3
    });
}), _Page));