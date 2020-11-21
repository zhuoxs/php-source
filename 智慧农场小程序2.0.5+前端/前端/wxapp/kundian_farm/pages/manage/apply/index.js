var t = new getApp(), e = t.util.getNewUrl("entry/wxapp/store", "kundian_farm_plugin_store"), a = t.siteInfo.siteroot.replace("app/index.php", "web/index.php") + "?i=" + t.siteInfo.uniacid + "&c=utility&a=file&do=upload&thumb=0";

Page({
    data: {
        logo: "",
        tmpPhoto: [],
        addressInfo: [],
        setData: [],
        phone: "",
        store: []
    },
    onLoad: function(e) {
        var a = wx.getStorageSync("kundian_farm_setData");
        this.setData({
            setData: a
        }), t.util.setNavColor(t.siteInfo.uniacid);
    },
    chooseImage: function(t) {
        var e = this, o = t.currentTarget.dataset.type;
        1 != o ? 2 == o && wx.chooseImage({
            success: function(t) {
                var o = t.tempFilePaths, s = [];
                if (o.length > 0) {
                    wx.showToast({
                        title: "正在上传...",
                        icon: "loading",
                        mask: !0,
                        duration: 1e4
                    });
                    for (var n = 0, i = 0; i < o.length; i++) wx.uploadFile({
                        url: a,
                        filePath: o[i],
                        name: "file",
                        formData: {
                            op: "upload_file"
                        },
                        success: function(t) {
                            n++;
                            var a = JSON.parse(t.data);
                            s.push(a.url), n == o.length && (wx.hideToast(), e.setData({
                                tmpPhoto: s
                            }));
                        }
                    });
                }
            }
        }) : wx.chooseImage({
            count: 1,
            success: function(t) {
                wx.uploadFile({
                    url: a,
                    filePath: t.tempFilePaths[0],
                    name: "file",
                    formData: {
                        op: "upload_file"
                    },
                    success: function(t) {
                        var a = JSON.parse(t.data);
                        e.setData({
                            logo: a.url
                        });
                    }
                });
            }
        });
    },
    chooseAddress: function(t) {
        var e = this;
        wx.chooseLocation({
            success: function(t) {
                e.setData({
                    addressInfo: t
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "提示",
                    content: "无法打开地址",
                    showCancel: !1
                });
            }
        });
    },
    delImg: function(t) {
        this.data.tmpPhoto.splice(t.currentTarget.dataset.index, 1), this.setData({
            tmpPhoto: this.data.tmpPhoto
        });
    },
    viewImage: function(t) {
        wx.previewImage({
            urls: this.data.tmpPhoto,
            current: t.currentTarget.dataset.url
        });
    },
    submitData: function(t) {
        var a = this, o = t.detail.value, s = o.name, n = o.phone, i = o.intro, r = o.status, u = a.data, c = u.tmpPhoto, l = u.addressInfo, d = u.logo, h = (u.store, 
        "");
        c.length > 0 && (h = c.join(",")), wx.request({
            url: e,
            data: {
                op: "adminAddStore",
                control: "store",
                name: s,
                phone: n,
                intro: i,
                src: h,
                logo: d,
                status: r,
                address: l.address,
                longitude: l.longitude,
                latitude: l.latitude
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
                        }, 1e3);
                    }
                });
            }
        });
    }
});