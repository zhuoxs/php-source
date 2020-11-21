var app = getApp();

Page({
    data: {
        bg: "",
        shengc: !1
    },
    onLoad: function(a) {
        var o = this;
        this.setData({
            nickname: app.globalData.userInfo.nickname,
            avatar: app.globalData.userInfo.avatarurl,
            admin2: app.globalData.userInfo.admin2,
            "goHome.blackhomeimg": app.globalData.blackhomeimg,
            bg: app.module_url + "resource/images/user-banner.jpg"
        }), app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            data: {
                op: "manageindex"
            },
            success: function(a) {
                var e = a.data;
                o.setData({
                    today_price: e.data.today_price,
                    order_price: e.data.order_price,
                    order_num: e.data.order_num,
                    moon_num: e.data.moon_num
                });
            },
            fail: function(a) {
                console.log(a), 2 == a.data.errno && app.util.message({
                    title: a.data.message,
                    redirect: "redirect:../index/index",
                    type: "error"
                });
            }
        });
    },
    shengcheng: function() {
        var e = this;
        e.setData({
            shengc: !0
        }), app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !0,
            method: "POST",
            data: {
                op: "manage_poster"
            },
            success: function(a) {
                e.setData({
                    poster: a.data.data
                });
            }
        });
    },
    holdblock: function() {},
    close_shengc: function() {
        this.setData({
            shengc: !1
        });
    },
    previewImage_poster: function() {
        wx.previewImage({
            urls: [ this.data.poster ]
        });
    },
    saveImageToPhotosAlbum: function() {
        wx.downloadFile({
            url: this.data.poster,
            success: function(a) {
                console.log(a);
                var e = a.tempFilePath;
                wx.authorize({
                    scope: "scope.writePhotosAlbum",
                    success: function(a) {
                        wx.saveImageToPhotosAlbum({
                            filePath: e,
                            success: function(a) {
                                app.look.alert("保存成功");
                            },
                            fail: function(a) {
                                "saveImageToPhotosAlbum:fail auth deny" === a.errMsg && wx.openSetting({
                                    success: function(a) {}
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});