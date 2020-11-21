var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {},
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.util.request({
            url: "entry/wxapp/system",
            cachetime: "0",
            success: function(t) {
                a.setData({
                    background: t.data.shop_img
                });
            }
        }), a.url();
    },
    url: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url2", t.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = wx.getStorageSync("account"), a = wx.getStorageSync("password");
        this.setData({
            account: t,
            password: a
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    login: function(t) {
        wx.getStorageSync("bid");
        var a = t.detail.value;
        "" != a.account ? "" != a.password ? (wx.setStorageSync("account", a.account), wx.setStorageSync("password", a.password), 
        app.util.request({
            url: "entry/wxapp/adminlogin",
            cachetime: "0",
            data: {
                account: a.account,
                password: a.password
            },
            success: function(t) {
                console.log(t.data), 1 == t.data.re ? wx.redirectTo({
                    url: "../work/work"
                }) : 2 == t.data.re ? wx.redirectTo({
                    url: "../newwork/newwork?sid=" + t.data.sid
                }) : 3 == t.data.re ? wx.redirectTo({
                    url: "../work2/work2?bid=" + t.data.bid + "&b_name=" + t.data.b_name
                }) : wx.showToast({
                    title: "账号或密码错误！",
                    icon: "none",
                    duration: 2e3
                });
            }
        })) : wx.showModal({
            title: "提示",
            content: "请输入密码！",
            showCancel: !1
        }) : wx.showModal({
            title: "提示",
            content: "请输入账号！",
            showCancel: !1
        });
    }
});