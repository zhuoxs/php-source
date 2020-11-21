var app = getApp(), WxParse = require("../../../wxParse/wxParse.js");

Page({
    data: {
        bg: ""
    },
    shengcheng: function() {
        var a = this;
        a.data.detail;
        wx.showLoading({
            title: "加载中"
        }), app.util.request({
            url: "entry/wxapp/distribution",
            showLoading: !0,
            method: "POST",
            data: {
                op: "distribution_poster"
            },
            success: function(t) {
                wx.hideLoading(), a.setData({
                    poster: t.data.data,
                    shengc: !0
                });
            }
        });
    },
    saveImageToPhotosAlbum: function() {
        wx.downloadFile({
            url: this.data.poster,
            success: function(t) {
                console.log(t);
                var a = t.tempFilePath;
                wx.authorize({
                    scope: "scope.writePhotosAlbum",
                    success: function(t) {
                        wx.saveImageToPhotosAlbum({
                            filePath: a,
                            success: function(t) {
                                app.look.alert("保存成功");
                            },
                            fail: function(t) {
                                "saveImageToPhotosAlbum:fail auth deny" === t.errMsg && wx.openSetting({
                                    success: function(t) {}
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    hidesc: function() {
        this.setData({
            shengc: !1
        });
    },
    previewImage_poster: function() {
        wx.previewImage({
            urls: [ this.data.poster ]
        });
    },
    onLoad: function(t) {
        var e = this;
        e.setData({
            "goHome.blackhomeimg": app.globalData.blackhomeimg,
            userinfo: app.globalData.userInfo
        }), null != app.user_set ? e.setData({
            bg: app.user_set.bg
        }) : e.setData({
            bg: app.module_url + "resource/images/userbanner.jpg"
        }), app.util.request({
            url: "entry/wxapp/distribution",
            showLoading: !1,
            data: {
                op: "distribution"
            },
            success: function(t) {
                var a = t.data;
                a.data.list && e.setData({
                    list: a.data.list
                }), a.data.pageset && (WxParse.wxParse("article", "html", a.data.pageset.contents, e, 17), 
                e.setData({
                    pageset: a.data.pageset
                }));
            },
            fail: function(t) {
                console.log(t), 2 == t.data.errno && wx.redirectTo({
                    url: "../distribution_join/distribution_join"
                }), 3 == t.data.errno && wx.showModal({
                    title: "系统提示",
                    content: "请等待管理员的审核",
                    showCancel: !1,
                    success: function() {
                        wx.reLaunch({
                            url: "/xc_xinguwu/pages/user/user"
                        });
                    }
                });
            }
        });
    },
    onReady: function() {
        app.look.navbar(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/distribution",
            showLoading: !0,
            data: {
                op: "distribution"
            },
            success: function(t) {
                wx.stopPullDownRefresh();
                var a = t.data;
                a.data.list && e.setData({
                    list: a.data.list
                });
            }
        });
    },
    onReachBottom: function() {}
});