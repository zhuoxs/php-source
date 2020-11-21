var e = getApp();

Page({
    data: {
        nid: "",
        pathfile: ""
    },
    onLoad: function(t) {
        var o = this;
        try {
            var n = wx.getStorageSync("session");
            n && (console.log("logintag:", n), o.setData({
                logintag: n
            }));
        } catch (e) {}
        var a = o.data.logintag;
        wx.request({
            url: e.data.url + "show_car_owner_share_view",
            data: {
                logintag: a
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(e) {
                if (console.log(e), "0000" == e.data.retCode) o.setData({
                    nid: e.data.nid
                }); else if (wx.showToast({
                    title: e.data.retDesc,
                    icon: "none",
                    duration: 1e3
                }), "账号已冻结" == e.data.retDesc) return void wx.navigateTo({
                    url: "/pages/index/index"
                });
            }
        }), o.getappcode();
    },
    keep: function(e) {
        var t = this.data.pathfile;
        wx.downloadFile({
            url: t,
            success: function(e) {
                console.log(e.tempFilePath), wx.saveImageToPhotosAlbum({
                    filePath: e.tempFilePath,
                    success: function(e) {
                        wx.showModal({
                            title: "存图成功",
                            content: "图片成功保存到相册了，去发圈噻~",
                            showCancel: !1,
                            confirmText: "好哒",
                            confirmColor: "#72B9C3",
                            success: function(e) {
                                e.confirm && console.log("用户点击确定");
                            }
                        });
                    },
                    fail: function(e) {
                        console.log(e), console.log("fail");
                    }
                });
            }
        });
    },
    bindtap: function(e) {},
    getappcode: function(t) {
        var o = this, n = o.data.logintag;
        wx.request({
            url: e.data.url + "getappcode",
            data: {
                logintag: n
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(e) {
                console.log(e), "0000" == e.data.retCode ? o.setData({
                    pathfile: e.data.pathfile
                }) : wx.showToast({
                    title: e.data.retDesc,
                    icon: "none",
                    duration: 1e3
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
    onShareAppMessage: function() {
        var e = this.data.nid;
        return console.log("分享：", e), console.log("ntype", 2), {
            title: "拼车",
            desc: "拼车!",
            imageUrl: "/images/eqweqw.jpg",
            path: "/pages/index/index?id=" + e + "&ntype=2"
        };
    }
});