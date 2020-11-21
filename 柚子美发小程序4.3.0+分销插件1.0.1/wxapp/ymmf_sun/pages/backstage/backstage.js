var app = getApp();

Page({
    data: {},
    onLoad: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/system",
            cachetime: "0",
            success: function(t) {
                console.log(t.data), a.setData({
                    pt_name: t.data.pt_name
                });
            }
        });
        var o = wx.getStorageSync("account"), n = wx.getStorageSync("password");
        a.setData({
            account: o,
            password: n
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    formSubmit: function(t) {
        console.log(t);
        var a = this, o = t.detail.value;
        if ("" != o.account) if ("" != o.password) {
            var n = o.account, e = o.password;
            app.util.request({
                url: "entry/wxapp/Verification",
                cachetime: "0",
                data: {
                    account: n,
                    password: e
                },
                success: function(t) {
                    if (wx.setStorageSync("account", n), wx.setStorageSync("password", e), 1 == t.data.r) wx.navigateTo({
                        url: "index/index"
                    }); else if (2 == t.data.r) a.setData({
                        account: "",
                        password: ""
                    }), wx.navigateTo({
                        url: "index2/index2?id=" + t.data.id
                    }); else {
                        if (3 != t.data.r) return void wx.showModal({
                            title: "提示",
                            content: "账号或密码错误！",
                            showCancel: !1
                        });
                        wx.navigateTo({
                            url: "index3/index3?b_id=" + t.data.b_id
                        });
                    }
                }
            });
        } else wx.showModal({
            title: "提示",
            content: "请输入密码！",
            showCancel: !1
        }); else wx.showModal({
            title: "提示",
            content: "请输入账号！",
            showCancel: !1
        });
    }
});