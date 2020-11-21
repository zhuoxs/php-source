var app = getApp();

Page({
    data: {
        logo: "",
        url: "",
        hklogo: "/style/images/hklogo.png"
    },
    onLoad: function(o) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "120",
            success: function(o) {
                wx.setStorageSync("url", o.data), a.setData({
                    url: o.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            success: function(o) {
                console.log("获取基本设置参数"), console.log(o.data), a.setData({
                    logo: o.data.loginimg
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    formSubmit: function(o) {
        var a = o.detail.value.loginname, n = o.detail.value.loginpassword, e = wx.getStorageSync("openid");
        if (console.log(app.globalData.islogin), "" == a || "" == n) return wx.showModal({
            title: "提示信息",
            content: "用户名或者密码不能为空！！！",
            showCancel: !1
        }), !1;
        app.util.request({
            url: "entry/wxapp/CheckBrandUser",
            cachetime: "30",
            data: {
                openid: e,
                loginname: a,
                loginpassword: n
            },
            success: function(o) {
                console.log("商家数据"), console.log(o.data), wx.setStorageSync("brand_info", o.data.data), 
                wx.setStorageSync("loginname", a), app.globalData.islogin = 1, wx.redirectTo({
                    url: "/mzhk_sun/pages/backstage/index2/index2"
                });
            }
        });
    }
});