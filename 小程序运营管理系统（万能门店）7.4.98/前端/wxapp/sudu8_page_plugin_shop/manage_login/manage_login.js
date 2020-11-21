var app = getApp();

Page({
    data: {},
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = this;
        t.is_apply();
        var e = a.id;
        t.setData({
            id: e
        });
        var n = 0;
        a.fxsid && (n = a.fxsid, t.setData({
            fxsid: a.fxsid
        }));
        var i = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: i,
            data: {
                vs1: 1
            },
            cachetime: "30",
            success: function(a) {
                a.data.data;
                t.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            }
        }), app.util.getUserInfo(t.getinfos, n);
    },
    is_apply: function() {
        app.util.request({
            url: "entry/wxapp/LoginS",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                0 < a.data.data ? (wx.setStorageSync("mlogin", a.data.data), app.util.request({
                    url: "entry/wxapp/is_apply",
                    data: {
                        openid: wx.getStorageSync("openid"),
                        id: wx.getStorageSync("mlogin")
                    },
                    success: function(a) {
                        2 == a.data.data.is_apply ? wx.redirectTo({
                            url: "/sudu8_page_plugin_shop/manage_index/manage_index"
                        }) : wx.redirectTo({
                            url: "/sudu8_page_plugin_shop/register/register"
                        });
                    }
                })) : wx.redirectTo({
                    url: "/sudu8_page_plugin_shop/register/register"
                });
            }
        });
    },
    bindinput: function(a) {
        var t = a.currentTarget.dataset.name, e = a.detail.value;
        "name" == t ? this.setData({
            name: e
        }) : this.setData({
            pass: e
        });
    },
    formSubmit: function() {
        app.util.request({
            url: "entry/wxapp/Login",
            data: {
                name: this.data.name,
                pass: this.data.pass
            },
            success: function(a) {
                0 < a.data.data ? (wx.setStorageSync("mlogin", a.data.data), wx.redirectTo({
                    url: "/sudu8_page_plugin_shop/manage_index/manage_index"
                })) : wx.showModal({
                    title: "提示",
                    content: "登录失败，请重新登录！",
                    showCancel: !1
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});