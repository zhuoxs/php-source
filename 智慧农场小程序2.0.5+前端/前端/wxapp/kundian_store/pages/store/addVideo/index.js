var t = new getApp(), e = t.util.getNewUrl("entry/wxapp/store", "kundian_farm_plugin_store");

Page({
    data: {
        get_method: 1,
        cover: "",
        store_id: "",
        id: 0,
        live: [],
        setData: []
    },
    onLoad: function(o) {
        var a = this, i = wx.getStorageSync("kundian_farm_setData");
        a.setData({
            store_id: o.store_id,
            id: o.id || 0,
            setData: i
        }), t.util.setNavColor(t.siteInfo.uniacid), o.id && wx.request({
            url: e,
            data: {
                control: "store",
                op: "handleLive",
                type: "getLiveById",
                id: o.id,
                store_id: o.store_id
            },
            success: function(t) {
                a.setData({
                    live: t.data.live,
                    cover: t.data.live.cover
                });
            }
        });
    },
    changeMethod: function(t) {
        this.setData({
            get_method: t.currentTarget.dataset.state
        });
    },
    chooseImage: function() {
        var e = this;
        wx.chooseImage({
            count: 1,
            success: function(o) {
                var a = t.siteInfo.siteroot.replace("app/index.php", "web/index.php") + "?i=" + t.siteInfo.uniacid + "&c=utility&a=file&do=upload&thumb=0";
                wx.showToast({
                    title: "正在上传...",
                    icon: "loading",
                    mask: !0,
                    duration: 1e3
                }), wx.uploadFile({
                    url: a,
                    filePath: o.tempFilePaths[0],
                    name: "file",
                    formData: {
                        op: "upload_file"
                    },
                    success: function(t) {
                        var o = JSON.parse(t.data);
                        e.setData({
                            cover: o.url
                        });
                    }
                });
            }
        });
    },
    saveHand: function(t) {
        var o = this, a = t.detail.value, i = a.title, s = a.src, n = a.status, d = o.data, c = d.cover, r = d.store_id, u = d.id;
        "" != i && void 0 != i ? "" != c && void 0 != c ? "" != s && void 0 != s ? wx.request({
            url: e,
            data: {
                control: "store",
                op: "handleLive",
                type: "editLive",
                title: i,
                cover: c,
                src: s,
                store_id: r,
                id: u,
                status: n ? 1 : 0
            },
            success: function(t) {
                wx.showToast({
                    title: t.data.msg,
                    icon: "none",
                    success: function() {
                        if (0 == t.data.code) var e = setTimeout(function() {
                            clearTimeout(e), wx.navigateBack({
                                delta: 1
                            });
                        }, 1500);
                    }
                });
            }
        }) : wx.showToast({
            title: "请填写监控地址",
            icon: "none"
        }) : wx.showToast({
            title: "请选择监控封面",
            icon: "none"
        }) : wx.showToast({
            title: "请填写监控标题",
            icon: "none"
        });
    },
    getNetVideo: function(t) {
        var o = this, a = t.detail.value, i = a.username, s = a.password, n = o.data.store_id;
        "" != i && void 0 != i ? "" != s && void 0 != s ? (wx.showLoading({
            title: "正在获取..."
        }), wx.request({
            url: e,
            data: {
                control: "store",
                op: "getNetVideo",
                store_id: n,
                username: i,
                password: s
            },
            success: function(t) {
                wx.hideLoading(), wx.showToast({
                    title: t.data.msg,
                    icon: "none",
                    success: function() {
                        if (0 == t.data.code) var e = setTimeout(function() {
                            clearTimeout(e), wx.navigateBack({
                                delta: 1
                            });
                        }, 1e3);
                    }
                });
            }
        })) : wx.showToast({
            title: "请输入物联网密码",
            icon: "none"
        }) : wx.showToast({
            title: "请输入物联网账号",
            icon: "none"
        });
    }
});