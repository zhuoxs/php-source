var app = getApp(), Toast = require("../../libs/zanui/toast/toast");

Page({
    data: {
        credit_on: !1,
        showCategoryPopup: !1,
        bindPhone: !1,
        recycle: {
            open: !1,
            style: []
        }
    },
    onLoad: function() {
        var t = this, a = wx.getStorageSync("loading_img");
        a ? t.setData({
            loadingImg: a
        }) : t.setData({
            loadingImg: "../../libs/images/loading.gif"
        }), "" != wx.getStorageSync("userInfo").memberInfo.mobile && t.setData({
            bindPhone: !0
        }), t.setData({
            credit_title: app.globalData.credit_title
        }), app.viewCount(), t.checkPlugin(), app.util.footer(t), app.setTabBar(t), app.checkRedDot(t);
    },
    onShow: function() {
        this.getMyInfo();
    },
    checkPlugin: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/home",
            cachetime: "0",
            data: {
                act: "plugin",
                m: "superman_hand2"
            },
            success: function(t) {
                if (t.data.errno) e.showIconToast(t.data.errmsg); else {
                    var a = t.data.data;
                    e.setData({
                        wechat_on: 1 == a.superman_hand2_plugin_wechat
                    });
                }
            },
            fail: function(t) {
                e.showIconToast(t.data.errmsg);
            }
        });
    },
    getMyInfo: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/my",
            cachetime: "0",
            data: {
                m: "superman_hand2"
            },
            success: function(t) {
                t.data.errno ? a.showIconToast(t.data.errmsg) : a.setData({
                    my: t.data.data,
                    credit_on: 1 == t.data.data.credit_setting,
                    version: app.data.version,
                    completed: !0
                });
            },
            fail: function(t) {
                a.setData({
                    completed: !0
                }), a.showIconToast(t.data.errmsg);
            }
        });
    },
    onPullDownRefresh: function() {
        this.getMyInfo(), wx.stopPullDownRefresh();
    },
    showPopup: function() {
        this.setData({
            showBottomPopup: !0
        });
    },
    toggleBottomPopup: function() {
        this.setData({
            showBottomPopup: !this.data.showBottomPopup
        });
    },
    toggleCategoryPopup: function() {
        this.setData({
            category: wx.getStorageSync("category") ? wx.getStorageSync("category") : [],
            showCategoryPopup: !this.data.showCategoryPopup
        });
    },
    showIconToast: function(t) {
        var a = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "fail";
        Toast({
            type: a,
            message: t,
            selector: "#zan-toast"
        });
    },
    jumpToPage: function(t) {
        var a = t.currentTarget.dataset.url;
        -1 != a.indexOf("http") ? wx.navigateTo({
            url: "../ad/index?path=" + encodeURIComponent(a)
        }) : wx.navigateTo({
            url: a
        });
    },
    linktoWxapp: function(t) {
        var a = t.currentTarget.dataset.appid, e = t.currentTarget.dataset.path;
        wx.navigateToMiniProgram({
            appId: a,
            path: e,
            success: function(t) {
                console.log("打开成功");
            }
        });
    }
});