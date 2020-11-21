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
    },
    onReady: function() {},
    onShow: function() {
        var t = wx.getStorageSync("account"), a = wx.getStorageSync("password");
        t && a ? this.setData({
            account: t,
            password: a
        }) : this.setData({
            account: "",
            password: ""
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    formSubmit: function(t) {
        console.log(t);
        var a = t.detail.value;
        "" == a.account && wx.showModal({
            title: "提示",
            content: "请输入账号",
            showCancel: !1
        }), "" == a.password ? wx.showModal({
            title: "提示",
            content: "请输入密码",
            showCancel: !1
        }) : app.util.request({
            url: "entry/wxapp/isLogin",
            cachetime: "0",
            data: {
                account: a.account,
                password: a.password
            },
            success: function(t) {
                if (1 == t.data.r) wx.setStorageSync("account", a.account), wx.setStorageSync("password", a.password), 
                wx.redirectTo({
                    url: "index/index"
                }); else if (2 == t.data.r) wx.setStorageSync("account", a.account), wx.setStorageSync("password", a.password), 
                wx.redirectTo({
                    url: "index2/index2?id=" + t.data.id
                }); else {
                    if (3 != t.data.r) return void wx.showModal({
                        title: "提示",
                        content: "账号或密码错误",
                        showCancel: !1
                    });
                    wx.setStorageSync("account", a.account), wx.setStorageSync("password", a.password), 
                    wx.redirectTo({
                        url: "index3/index3?id=" + t.data.id
                    });
                }
            }
        });
    }
});