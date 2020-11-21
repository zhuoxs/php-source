var t = new getApp(), a = t.siteInfo.uniacid;

Page({
    data: {
        userInfo: [],
        farmSetData: [],
        showPost: !1,
        local_src: "",
        post_src: ""
    },
    onLoad: function(s) {
        var e = this, o = wx.getStorageSync("kundian_farm_uid");
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "distribution",
                op: "getQrcode",
                uniacid: a,
                uid: o
            },
            success: function(t) {
                e.setData({
                    userInfo: t.data.user,
                    farmSetData: wx.getStorageSync("kundian_farm_setData")
                });
            }
        });
    },
    onShareAppMessage: function(t) {
        var a = wx.getStorageSync("kundian_farm_setData"), s = wx.getStorageSync("kundian_farm_uid"), e = this.data.userInfo;
        return {
            path: "/kundian_farm/pages/HomePage/index/index?&user_uid=" + s,
            success: function(t) {},
            title: a.share_home_title,
            imageUrl: e.qrcode
        };
    },
    createPoster: function(s) {
        if (this.data.post_src) this.setData({
            showPost: !0
        }); else {
            wx.showLoading({
                title: "海报生成中..."
            });
            var e = this, o = wx.getStorageSync("kundian_farm_uid");
            t.util.request({
                url: "entry/wxapp/class",
                data: {
                    control: "distribution",
                    op: "createPoster",
                    uniacid: a,
                    uid: o
                },
                success: function(t) {
                    e.setData({
                        local_src: t.data.local_src,
                        post_src: t.data.post_src,
                        showPost: !0
                    }), wx.hideLoading();
                }
            });
        }
    },
    hidePost: function(t) {
        this.setData({
            showPost: !1
        });
    },
    savePost: function(t) {
        var a = this.data.local_src;
        wx.downloadFile({
            url: a,
            success: function(t) {
                wx.saveImageToPhotosAlbum({
                    filePath: t.tempFilePath,
                    success: function(t) {
                        wx.showModal({
                            title: "提示",
                            content: "海报保存成功",
                            showCancel: !1
                        });
                    },
                    fail: function(t) {}
                });
            }
        });
    }
});