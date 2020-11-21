var t = new getApp(), a = t.siteInfo.uniacid;

Page({
    data: {
        imgArr: [],
        currentIndexId: 0,
        isShow: !0,
        lid: "",
        plate: 1,
        adoptid: "",
        farmSetData: []
    },
    onLoad: function(e) {
        var i = e.plate;
        if (1 == i) {
            var s = e.lid, o = e.seed_id;
            this.setData({
                lid: s,
                plate: i,
                seed_id: o
            });
        } else {
            var d = e.adoptid;
            this.setData({
                adoptid: d,
                plate: i
            });
        }
        t.util.setNavColor(a), this.setData({
            farmSetData: wx.getStorageSync("kundian_farm_setData")
        });
    },
    addImg: function() {
        var t = this;
        wx.chooseImage({
            count: 9,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                for (var e = a.tempFilePaths, i = 0; i < e.length; i++) t.data.imgArr.push(e[i]);
                t.setData({
                    imgArr: t.data.imgArr
                });
            }
        });
    },
    deleteImg: function(t) {
        var a = t.currentTarget.dataset.url, e = this.data.imgArr;
        e.map(function(t, i) {
            t == a && e.splice(i, 1);
        }), this.setData({
            imgArr: e
        });
    },
    checked: function(t) {
        var a = t.currentTarget.dataset.id, e = this.data.seedList;
        e.map(function(t) {
            t.select = !1, t.id == a && (t.select = !0);
        }), this.setData({
            seedList: e,
            currentIndexId: a
        });
    },
    isShow: function() {
        var t = this.data.isShow;
        this.setData({
            isShow: !t
        });
    },
    submitData: function(e) {
        var i = this, s = this.data, o = s.plate, d = s.imgArr;
        siteroot = t.siteInfo.siteroot.replace("app/index.php", "web/index.php");
        var n = siteroot + "?i=" + t.siteInfo.uniacid + "&c=utility&a=file&do=upload&thumb=0", r = [], l = e.detail.value.txt;
        if (1 == o) {
            !function() {
                var e = i.data, s = e.lid, o = e.seed_id;
                if (wx.showToast({
                    title: "正在上传...",
                    icon: "loading",
                    mask: !0,
                    duration: 1e4
                }), d.length > 0) for (c = 0, u = 0; u < d.length; u++) wx.uploadFile({
                    url: n,
                    filePath: d[u],
                    name: "file",
                    formData: {
                        op: "upload_file"
                    },
                    success: function(e) {
                        c++;
                        var i = JSON.parse(e.data);
                        if (r.push(i.url), c == d.length) {
                            wx.hideToast();
                            var n = "";
                            d.length > 0 && (n = JSON.stringify(r)), t.util.request({
                                url: "entry/wxapp/class",
                                data: {
                                    op: "statusSave",
                                    action: "land",
                                    control: "seller",
                                    uniacid: a,
                                    txt: l,
                                    src: n,
                                    lid: s,
                                    seed_id: o
                                },
                                method: "POST",
                                success: function(t) {
                                    1 == t.data.code ? wx.showModal({
                                        title: "提示",
                                        content: t.data.msg,
                                        showCancel: !1,
                                        success: function() {
                                            wx.navigateBack({
                                                delta: 1
                                            });
                                        }
                                    }) : wx.showToast({
                                        title: t.data.msg
                                    });
                                }
                            });
                        }
                    }
                });
            }();
        } else {
            var c, u;
            !function() {
                var e = i.data.adoptid;
                if (wx.showToast({
                    title: "正在上传...",
                    icon: "loading",
                    mask: !0,
                    duration: 1e4
                }), d.length > 0) for (c = 0, u = 0; u < d.length; u++) wx.uploadFile({
                    url: n,
                    filePath: d[u],
                    name: "file",
                    formData: {
                        op: "upload_file"
                    },
                    success: function(i) {
                        c++;
                        var s = JSON.parse(i.data);
                        if (r.push(s.url), c == d.length) {
                            wx.hideToast();
                            var o = "";
                            d.length > 0 && (o = JSON.stringify(r)), t.util.request({
                                url: "entry/wxapp/class",
                                data: {
                                    op: "statusSave",
                                    action: "adopt",
                                    control: "seller",
                                    uniacid: a,
                                    txt: l,
                                    src: o,
                                    adoptid: e
                                },
                                method: "POST",
                                success: function(t) {
                                    1 == t.data.code ? wx.showToast({
                                        title: t.data.msg,
                                        success: function() {
                                            wx.navigateBack({
                                                delta: 1
                                            });
                                        }
                                    }) : wx.showToast({
                                        title: t.data.msg
                                    });
                                }
                            });
                        }
                    }
                });
            }();
        }
    }
});