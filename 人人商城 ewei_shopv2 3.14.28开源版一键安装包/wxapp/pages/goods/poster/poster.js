var e = getApp(), t = e.requirejs("core"), o = e.requirejs("foxui");

Page({
    data: {
        show: !1,
        accredit: "",
        errMsg: "",
        Image: ""
    },
    onLoad: function(e) {
        (e = e || {}).id ? this.getImage(e.id) : wx.redirectTo({
            url: "/pages/goods/index/index"
        });
    },
    getImage: function(e) {
        var s = this;
        t.json("goods/poster/getimage", {
            id: e
        }, function(e) {
            0 != e.error ? o.toast(s, e.message) : s.setData({
                Image: e.url
            });
        });
    },
    loadImg: function(e) {
        this.setData({
            show: !0
        });
    },
    previewImage: function() {
        var e = this;
        wx.previewImage({
            current: e.data.Image,
            urls: [ e.data.Image ]
        });
    },
    savePicture: function() {
        var e = this;
        wx.getSetting({
            success: function(t) {
                t.authSetting["scope.writePhotosAlbum"] ? (wx.showLoading({
                    title: "图片下载中..."
                }), setTimeout(function() {
                    wx.hideLoading();
                }, 1e3), wx.downloadFile({
                    url: e.data.Image,
                    success: function(t) {
                        wx.saveImageToPhotosAlbum({
                            filePath: t.tempFilePath,
                            success: function(t) {
                                o.toast(e, "保存图片成功");
                            },
                            fail: function(t) {
                                e.setData({
                                    errMsg: t.errMsg
                                }), o.toast(e, "保存图片失败");
                            }
                        });
                    }
                })) : wx.authorize({
                    scope: "scope.writePhotosAlbum",
                    success: function() {
                        wx.showLoading({
                            title: "图片下载中..."
                        }), setTimeout(function() {
                            wx.hideLoading();
                        }, 1e3), wx.downloadFile({
                            url: e.data.Image,
                            success: function(t) {
                                wx.saveImageToPhotosAlbum({
                                    filePath: t.tempFilePath,
                                    success: function(t) {
                                        o.toast(e, "保存图片成功");
                                    },
                                    fail: function(t) {
                                        e.setData({
                                            errMsg: t.errMsg
                                        }), o.toast(e, "保存图片失败");
                                    }
                                });
                            }
                        });
                    },
                    fail: function() {
                        wx.showModal({
                            title: "警告",
                            content: "您点击了拒绝授权，将无法正常使用保存图片或视频的功能体验，请删除小程序重新进入。"
                        });
                    }
                });
            }
        });
    }
});